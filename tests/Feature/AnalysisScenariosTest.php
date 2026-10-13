<?php

namespace Tests\Feature;

use App\AnalysisPipeline;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AnalysisScenariosTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @return array<string,array{string,string}> */
    public static function scenarios(): array
    {
        return [
            'complete' => ['Customers place orders, administrators approve orders, reports show order totals.', 'Must'],
            'short' => ['Help', 'Should'],
            'large' => [str_repeat('Users need order reports. ', 1900), 'Should'],
            'incomplete' => ['Build an application. Details to follow.', 'Could'],
            'contradictory' => ['Users must pay online. Users must not pay online.', 'Must'],
            'poorly written' => ['pls app fast thing users all stuff maybe?', 'Could'],
            'technical' => ['REST API with OAuth, PostgreSQL, 200ms latency and audit logs.', 'Must'],
            'business' => ['Reduce manual reconciliation and improve daily sales reporting.', 'Should'],
            'multi role' => ['Customers order; managers approve; administrators configure permissions.', 'Must'],
            'payment' => ['Card payments, refunds and recurring billing.', 'Must'],
            'sensitive' => ['Health records and employee personal data require restricted access.', 'Must'],
            'unrealistic' => ['Unlimited users, 100% uptime, no cost, deliver everything tomorrow.', 'Must'],
            'scope creep' => ['Also add optional payroll and inventory after original order scope.', 'Future'],
        ];
    }

    #[DataProvider('scenarios')]
    public function test_demo_preserves_evidence_and_produces_reviewable_structure(string $text, string $priority): void
    {
        Http::preventStrayRequests();
        $owner = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $owner->id]);
        $this->actingAs($owner)->post(route('sources.store', $project), ['kind' => 'text', 'original' => $text, 'priority' => $priority])->assertRedirect();
        $this->post(route('analysis.store', $project))->assertRedirect();
        $analysis = $project->analyses()->latest('id')->firstOrFail();
        $this->assertSame('complete', $analysis->status);
        $this->assertSame('deterministic-demo', $analysis->provider);
        $this->assertSame(AnalysisPipeline::MODULES, array_keys($analysis->results));
        $this->assertSame([$text], $analysis->results['extraction']['items'][0]['statements']);
        $this->assertSame($priority, $analysis->results['tasks']['items'][0]['priority']);
        $this->assertSame('AI Suggested', $analysis->results['architecture']['items'][0]['provenance']);
        $this->assertSame('Missing', $analysis->results['missing_information']['items'][0]['provenance']);
        $this->assertFalse($project->refresh()->isApproved());
        $this->assertDatabaseHas('sources', ['project_id' => $project->id, 'original' => $text]);
    }

    public function test_conflicts_keep_both_sources_and_optional_scope_stays_separate(): void
    {
        $owner = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $owner->id]);
        $this->actingAs($owner);
        foreach (['Customers must pay online', 'Customers must not pay online', 'Optional reports'] as $text) {
            $this->post(route('sources.store', $project), ['kind' => 'text', 'original' => $text, 'priority' => 'Future'])->assertRedirect();
        }
        $this->post(route('analysis.store', $project))->assertRedirect();
        $results = $project->analyses()->latest('id')->firstOrFail()->results;
        $conflict = $results['ambiguity_conflicts']['items'][3];
        $this->assertSame(['Customers must pay online', 'Customers must not pay online'], $conflict['statements']);
        $this->assertCount(2, $conflict['source_ids']);
        $this->assertSame('optional', $results['classification']['items'][2]['scope']);
        $this->assertStringContainsString('payment provider', $results['security']['items'][0]['title']);
    }

    /** @return array<string, array{string, string}> */
    public static function categories(): array
    {
        return [
            'functional' => ['Customers view order status.', 'Functional'],
            'non-functional' => ['Dashboard response time must be measurable.', 'Non-Functional'],
            'technical' => ['Provide a REST API with OAuth.', 'Technical'],
            'business' => ['Reduce manual reconciliation.', 'Business'],
            'optional' => ['Optional reports may be added later.', 'Optional'],
        ];
    }

    #[DataProvider('categories')]
    public function test_demo_category_is_explicit_and_does_not_confirm_the_client(string $text, string $category): void
    {
        config(['ai_analysis.driver' => 'demo']);
        Http::preventStrayRequests();
        $owner = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $owner->id]);
        $this->actingAs($owner)->post(route('sources.store', $project), [
            'kind' => 'text', 'original' => $text, 'priority' => 'Should',
        ])->assertRedirect();

        $this->post(route('analysis.store', $project))->assertRedirect();

        $finding = $project->analyses()->latest('id')->firstOrFail()->results['classification']['items'][0];
        $this->assertSame($category, $finding['category']);
        $this->assertSame('AI Inferred', $finding['provenance']);
        $this->assertSame([$text], $finding['statements']);
        $this->assertFalse($project->refresh()->isApproved());
        Http::assertNothingSent();
    }
}
