<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use App\WorkspaceRevision;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class WorkspaceSecurityTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_owner_cannot_perform_reviewer_actions_or_assign_an_unprivileged_user(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $owner->id]);
        $this->actingAs($owner);
        foreach (['reviews.store', 'approvals.store', 'proposal.store'] as $route) {
            $this->post(route($route, $project))->assertForbidden();
        }
        $this->post(route('projects.reviewer', $project), ['reviewer_id' => $other->id])->assertUnprocessable();
        $this->assertDatabaseCount('approvals', 0);
        $this->assertNull($project->fresh()->reviewer_id);
    }

    public function test_assigned_reviewer_cannot_edit_project_context(): void
    {
        $owner = User::factory()->create();
        $reviewer = User::factory()->create();
        $reviewer->is_reviewer = true;
        $reviewer->save();

        $project = Project::factory()->create([
            'user_id' => $owner->id,
            'reviewer_id' => $reviewer->id,
            'revision' => 1,
        ]);

        $before = $project->only([
            'name', 'business_problem', 'objectives', 'target_users',
        ]);

        $this->actingAs($reviewer)
            ->put(route('projects.update', $project), [
                'revision' => (string) $project->revision,
                'name' => 'Unauthorized title',
                'business_problem' => 'Unauthorized change',
                'objectives' => 'Unauthorized objective',
                'target_users' => 'Unauthorized users',
            ])
            ->assertNotFound();

        $this->assertSame($before, $project->fresh()->only([
            'name', 'business_problem', 'objectives', 'target_users',
        ]));
    }

    public function test_context_edits_preserve_history_and_stale_forms_do_not_overwrite(): void
    {
        $owner = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $owner->id]);
        $data = ['revision' => '1', 'name' => 'New title', 'business_problem' => 'Updated problem', 'objectives' => 'Improved orders', 'target_users' => 'Customer'];
        $this->actingAs($owner)->put(route('projects.update', $project), $data)->assertRedirect();
        $project->refresh();
        $this->assertSame(2, $project->revision);
        $artifact = $project->artifacts()->firstOrFail();
        $this->assertSame('Manual ordering causes delays', $artifact->content['before']['business_problem']);
        $this->assertSame('Updated problem', $artifact->content['after']['business_problem']);
        $this->put(route('projects.update', $project), array_replace($data, ['name' => 'Stale update']))->assertConflict();
        $this->assertSame('New title', $project->fresh()->name);
    }

    public function test_login_checks_credentials_and_logout_ends_session(): void
    {
        $user = User::factory()->create();
        $this->post('/login', ['email' => $user->email, 'password' => 'wrong'])->assertSessionHasErrors('email');
        $this->post('/login', ['email' => $user->email, 'password' => 'password'])->assertRedirect(route('projects.index'));
        $this->assertAuthenticatedAs($user);
        $this->post(route('logout'))->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_original_whitespace_is_preserved_and_clarifications_require_a_reference(): void
    {
        $owner = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $owner->id]);
        $this->actingAs($owner)->post(route('sources.store', $project), ['kind' => 'text', 'original' => '  Original evidence  ', 'priority' => 'Should'])->assertRedirect();
        $this->assertDatabaseHas('sources', ['project_id' => $project->id, 'original' => '  Original evidence  ']);
        $this->post(route('sources.store', $project), ['kind' => 'clarification', 'original' => 'Confirmed roles', 'priority' => 'Should'])->assertSessionHasErrors('reference');
    }

    public function test_database_failures_do_not_render_or_log_confidential_sql(): void
    {
        $owner = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $owner->id]);
        Log::spy();
        $exception = new QueryException('sqlite', 'insert into sources values (?)', ['confidential-client-text'], new \PDOException('confidential-client-text'));
        $this->mock(WorkspaceRevision::class)->shouldReceive('advance')->once()->andThrow($exception);
        $this->actingAs($owner)->post(route('sources.store', $project), ['kind' => 'text', 'original' => 'confidential-client-text', 'priority' => 'Must'])->assertStatus(503)->assertSee('Workspace data operation failed')->assertDontSee('confidential-client-text');
        Log::shouldHaveReceived('error')->once()->with('Workspace database operation failed', ['sqlstate' => null]);
        $this->assertDatabaseCount('sources', 0);
    }

    public function test_changed_client_confirmed_content_requires_fresh_confirmation(): void
    {
        $reviewer = User::factory()->create();
        $reviewer->is_reviewer = true;
        $reviewer->save();
        $project = Project::factory()->create(['reviewer_id' => $reviewer->id]);
        $this->actingAs($reviewer);
        $this->post(route('sources.store', $project), ['kind' => 'text', 'original' => 'Reports', 'priority' => 'Should'])->assertRedirect();
        $this->post(route('analysis.store', $project))->assertRedirect();
        $project->refresh();
        $data = ['revision' => (string) $project->revision, 'module' => 'classification', 'index' => '0', 'title' => 'Reports', 'scope' => 'included', 'priority' => 'Should', 'notes' => 'Client reviewed', 'decision' => 'client_confirmed', 'evidence' => 'Client agrees to basic reports'];
        $this->post(route('reviews.store', $project), $data)->assertRedirect();
        $project->refresh();
        $this->post(route('reviews.store', $project), array_replace($data, ['revision' => (string) $project->revision, 'title' => 'Additional reports', 'decision' => 'edited']))->assertRedirect();
        $latest = $project->analyses()->latest('id')->firstOrFail();
        $this->assertSame('AI Inferred', $latest->results['classification']['items'][0]['provenance']);
        $this->assertSame('Client Confirmed', $project->artifacts()->latest('id')->firstOrFail()->content['before']['provenance']);
    }

    public function test_large_context_is_validated_and_screens_are_separated_by_role(): void
    {
        $owner = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $owner->id, 'business_problem' => str_repeat('x', 10000), 'objectives' => str_repeat('y', 10000), 'target_users' => 'Customer, Administrator']);
        $this->actingAs($owner)->post(route('sources.store', $project), ['kind' => 'text', 'original' => 'Customers order and administrators approve orders', 'priority' => 'Must'])->assertRedirect();
        $this->post(route('analysis.store', $project))->assertRedirect();
        $analysis = $project->analyses()->latest('id')->firstOrFail();
        $this->assertSame('complete', $analysis->status);
        $this->assertSame(['Customer', 'Administrator'], array_column($analysis->results['screens']['items'], 'role'));
        $this->assertSame(1000, mb_strlen($analysis->results['business_context']['items'][0]['title']));
    }

    public function test_privacy_feasibility_and_scope_change_cues_are_relevant(): void
    {
        $owner = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $owner->id]);
        $this->actingAs($owner);
        foreach (['Sensitive health records', 'Unlimited capacity by tomorrow at no cost', 'Also add optional payroll'] as $text) {
            $this->post(route('sources.store', $project), ['kind' => 'text', 'original' => $text, 'priority' => 'Future'])->assertRedirect();
        }
        $this->post(route('analysis.store', $project))->assertRedirect();
        $results = $project->analyses()->latest('id')->firstOrFail()->results;
        $this->assertStringContainsString('sensitive-data minimization', $results['security']['items'][0]['title']);
        $this->assertStringContainsString('Validate feasibility', $results['ambiguity_conflicts']['items'][1]['title']);
        $this->assertStringContainsString('Potential scope change', $results['ambiguity_conflicts']['items'][2]['title']);
    }
}
