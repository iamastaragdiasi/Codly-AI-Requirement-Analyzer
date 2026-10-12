<?php

namespace Tests\Feature;

use App\AnalysisProvider;
use App\DeterministicAnalysisProvider;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RevisionWorkflowTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_complete_workflow_preserves_provenance_and_invalidates_approvals(): void
    {
        Http::preventStrayRequests();
        $owner = User::factory()->create();
        $reviewer = User::factory()->create();
        $reviewer->is_reviewer = true;
        $reviewer->save();
        $this->actingAs($owner)->post('/projects', ['name' => 'Order system', 'business_problem' => 'Manual ordering', 'objectives' => 'Reduce delays', 'target_users' => 'Customer, administrator', 'user_id' => $reviewer->id])->assertRedirect();
        $project = Project::firstOrFail();
        $this->assertSame($owner->id, $project->user_id);
        $this->post(route('projects.reviewer', $project), ['reviewer_id' => $reviewer->id])->assertRedirect();
        $this->post(route('sources.store', $project), ['kind' => 'structured', 'original' => 'Customers can pay for orders.', 'role' => 'Customer', 'feature' => 'Payments', 'priority' => 'Future'])->assertRedirect();
        $this->post(route('analysis.store', $project))->assertRedirect();
        $project->refresh();
        $revision = $project->revision;
        $analysis = $project->analyses()->latest('id')->firstOrFail();
        $this->assertSame('complete', $analysis->status);
        $this->assertSame('Future', $analysis->results['modules']['items'][0]['priority']);
        $this->actingAs($reviewer)->post(route('approvals.store', $project), ['revision' => (string) $revision, 'decision' => 'approved', 'notes' => 'Workflow reviewed; demo scope only.'])->assertRedirect();
        $this->assertTrue($project->isApproved());
        $this->assertSame('AI Inferred', $analysis->fresh()->results['extraction']['items'][0]['provenance']);
        $this->post(route('reviews.store', $project), ['revision' => (string) $revision, 'module' => 'classification', 'index' => 0, 'title' => 'Payment requirement', 'scope' => 'included', 'priority' => 'Future', 'notes' => 'Validated inclusion', 'decision' => 'edited'])->assertRedirect();
        $project->refresh();
        $this->assertFalse($project->isApproved());
        $this->post(route('approvals.store', $project), ['revision' => (string) $revision, 'decision' => 'approved', 'notes' => 'Stale approval'])->assertConflict();
        $this->post(route('approvals.store', $project), ['revision' => (string) $project->revision, 'decision' => 'approved', 'notes' => 'Revised scope reviewed'])->assertRedirect();
        $this->post(route('proposal.store', $project), ['revision' => (string) $project->revision, 'maintenance' => 'Pending agreement', 'third_party_costs' => 'Client approval required', 'client_responsibilities' => 'Supply acceptance criteria'])->assertRedirect();
        $project->refresh();
        $this->assertFalse($project->isApproved());
        $proposal = $project->artifacts()->where('kind', 'proposal')->firstOrFail();
        $this->assertSame('Not entered', $proposal->content['pricing']);
        $this->get(route('projects.show', $project))->assertOk()->assertSee('Proposal draft')->assertSee('deterministic-demo');
        Http::assertNothingSent();
        $this->assertDatabaseHas('approvals', ['project_id' => $project->id, 'user_id' => $reviewer->id, 'revision' => (string) $revision, 'decision' => 'approved']);
    }

    public function test_proposal_is_rejected_when_current_revision_is_not_approved(): void
    {
        $reviewer = User::factory()->create();
        $reviewer->is_reviewer = true;
        $reviewer->save();

        $project = Project::factory()->create([
            'reviewer_id' => $reviewer->id,
            'revision' => 1,
        ]);

        $this->actingAs($reviewer)
            ->post(route('proposal.store', $project), [
                'revision' => (string) $project->revision,
                'maintenance' => 'Pending agreement',
                'third_party_costs' => 'Client approval required',
                'client_responsibilities' => 'Supply acceptance criteria',
            ])
            ->assertUnprocessable();

        $this->assertDatabaseMissing('artifacts', [
            'project_id' => $project->id,
            'kind' => 'proposal',
        ]);
    }

    public function test_stale_proposal_submission_creates_no_artifact(): void
    {
        $reviewer = User::factory()->create();
        $reviewer->is_reviewer = true;
        $reviewer->save();

        $project = Project::factory()->create([
            'reviewer_id' => $reviewer->id,
            'revision' => 2,
        ]);

        $this->actingAs($reviewer)
            ->post(route('proposal.store', $project), [
                'revision' => '1',
                'maintenance' => 'Pending agreement',
                'third_party_costs' => 'Client approval required',
                'client_responsibilities' => 'Supply acceptance criteria',
            ])
            ->assertConflict();

        $this->assertDatabaseMissing('artifacts', [
            'project_id' => $project->id,
            'kind' => 'proposal',
        ]);
    }
    public function test_unauthorized_and_unassigned_reviewers_cannot_access_or_approve(): void
    {
        $project = Project::factory()->create();
        $stranger = User::factory()->create();
        $this->get(route('projects.show', $project))->assertRedirect(route('login'));
        $this->actingAs($stranger)->get(route('projects.show', $project))->assertNotFound();
        $this->post(route('analysis.store', $project))->assertNotFound();
        $this->post(route('approvals.store', $project), ['revision' => 1, 'decision' => 'approved', 'notes' => 'Unauthorized'])->assertForbidden();
        $this->assertDatabaseCount('approvals', 0);
    }

    public function test_empty_oversized_and_file_submissions_are_rejected(): void
    {
        $owner = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $owner->id]);
        $this->actingAs($owner)->post(route('sources.store', $project), ['kind' => 'text', 'original' => '   ', 'priority' => 'Must'])->assertSessionHasErrors('original');
        $this->post(route('sources.store', $project), ['kind' => 'text', 'original' => str_repeat('x', 50001), 'priority' => 'Must'])->assertSessionHasErrors('original');
        $this->post(route('sources.store', $project), ['kind' => 'text', 'original' => 'Valid text', 'priority' => 'Invalid', 'file' => 'document.pdf'])->assertSessionHasErrors(['priority', 'file']);
        $this->assertDatabaseCount('sources', 0);
    }

    public function test_explicit_client_confirmation_requires_evidence_and_retains_original(): void
    {
        $reviewer = User::factory()->create();
        $reviewer->is_reviewer = true;
        $reviewer->save();
        $project = Project::factory()->create(['reviewer_id' => $reviewer->id]);
        $this->actingAs($reviewer);
        $this->post(route('sources.store', $project), ['kind' => 'text', 'original' => 'Maybe add reports', 'priority' => 'Could'])->assertRedirect();
        $this->post(route('analysis.store', $project))->assertRedirect();
        $project->refresh();
        $data = ['revision' => (string) $project->revision, 'module' => 'classification', 'index' => 0, 'title' => 'Reports', 'scope' => 'included', 'priority' => 'Could', 'notes' => 'Client reviewed', 'decision' => 'client_confirmed'];
        $this->post(route('reviews.store', $project), $data)->assertSessionHasErrors('evidence');
        $this->post(route('reviews.store', $project), $data + ['evidence' => 'Client meeting: reports explicitly approved'])->assertRedirect();
        $analysis = $project->analyses()->latest('id')->firstOrFail();
        $this->assertSame('Client Confirmed', $analysis->results['classification']['items'][0]['provenance']);
        $this->assertDatabaseHas('sources', ['project_id' => $project->id, 'original' => 'Maybe add reports']);
    }

    public function test_confidential_content_is_escaped_and_not_in_audit_actions(): void
    {
        $owner = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $owner->id]);
        $text = '<script>alert(1)</script> confidential card data';
        $this->actingAs($owner)->post(route('sources.store', $project), ['kind' => 'text', 'original' => $text, 'priority' => 'Must'])->assertRedirect();
        $this->get(route('projects.show', $project))->assertOk()->assertSee($text)->assertDontSee($text, false);
        $this->assertSame('source_submitted', $project->auditEvents()->firstOrFail()->action);
    }

    public function test_malformed_provider_output_has_bounded_retry_and_blocks_approval(): void
    {
        $user = User::factory()->create();
        $user->is_reviewer = true;
        $user->save();
        $project = Project::factory()->create(['reviewer_id' => $user->id]);
        $this->actingAs($user)->post(route('sources.store', $project), ['kind' => 'text', 'original' => 'Create orders', 'priority' => 'Must'])->assertRedirect();
        $provider = new class implements AnalysisProvider
        {
            public int $calls = 0;

            public function run(string $module, array $input, int $attempt): array
            {
                $this->calls++;

                return ['items' => 'invalid'];
            }
        };
        $this->app->instance(AnalysisProvider::class, $provider);
        $this->post(route('analysis.store', $project))->assertRedirect();
        $project->refresh();
        $this->assertSame(24, $provider->calls);
        $this->assertSame('failed', $project->analyses()->latest('id')->firstOrFail()->status);
        $this->post(route('approvals.store', $project), ['revision' => (string) $project->revision, 'decision' => 'approved', 'notes' => 'Do not accept failed output'])->assertUnprocessable();
    }

    public function test_one_invalid_response_is_corrected_without_hiding_failures(): void
    {
        $owner = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $owner->id]);
        $this->actingAs($owner)->post(route('sources.store', $project), ['kind' => 'text', 'original' => 'Customer orders', 'priority' => 'Must'])->assertRedirect();
        $provider = new class implements AnalysisProvider
        {
            public int $calls = 0;

            public function run(string $module, array $input, int $attempt): array
            {
                $this->calls++;
                if ($module === 'extraction' && $attempt === 1) {
                    return ['items' => 'invalid'];
                }

                return (new DeterministicAnalysisProvider)->run($module, $input, $attempt);
            }
        };
        $this->app->instance(AnalysisProvider::class, $provider);
        $this->post(route('analysis.store', $project))->assertRedirect();
        $analysis = $project->analyses()->latest('id')->firstOrFail();
        $this->assertSame(13, $provider->calls);
        $this->assertSame('complete', $analysis->status);
        $this->assertSame([], $analysis->failures);
    }

    public function test_runtime_module_failure_is_explicit_and_does_not_store_exception_text(): void
    {
        $owner = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $owner->id]);
        $this->actingAs($owner)->post(route('sources.store', $project), ['kind' => 'text', 'original' => 'Customer orders', 'priority' => 'Must'])->assertRedirect();
        $provider = new class implements AnalysisProvider
        {
            public function run(string $module, array $input, int $attempt): array
            {
                if ($module === 'security') {
                    throw new \RuntimeException('confidential-provider-debug');
                }

                return (new DeterministicAnalysisProvider)->run($module, $input, $attempt);
            }
        };
        $this->app->instance(AnalysisProvider::class, $provider);
        $this->post(route('analysis.store', $project))->assertRedirect();
        $analysis = $project->analyses()->latest('id')->firstOrFail();
        $this->assertSame('failed', $analysis->status);
        $this->assertSame(['security' => 'Module failed. No confidential exception details stored.'], $analysis->failures);
        $this->assertArrayHasKey('extraction',$analysis->results);
    }
}
