<?php

namespace App;

use App\Models\Project;

class ProposalBuilder
{
    /**
     * @param array<string, mixed> $terms
     * @return array<string, mixed>
     */
    public function draft(Project $project, array $terms): array
    {
        $analysis = $project->analyses()->where('revision', $project->revision)->latest('id')->firstOrFail();
        $scopeItems = $analysis->results['classification']['items'] ?? [];
        $scopeGroups = [];
        foreach (['included', 'excluded', 'assumption', 'optional', 'unresolved'] as $scope) {
            $scopeGroups[$scope] = array_values(array_filter($scopeItems, fn (array $item): bool => $item['scope'] === $scope));
        }

        return [
            'status' => 'Draft — requires authorized technical/PM and commercial review',
            'analysis_id' => $analysis->id,
            'scope_revision' => $project->revision,
            'scope_snapshot' => $analysis->results,
            'scope_groups' => $scopeGroups,
            'deliverables' => $scopeGroups['included'],
            'exclusions' => $scopeGroups['excluded'],
            'technical_approach' => 'Suggested Laravel and relational database design; developer validation required.',
            'estimate' => [
                'status' => 'Provisional — requires authorized technical/PM review',
                'effort_hours' => $terms['effort_hours'] ?? null,
                'notes' => $terms['estimate_notes'] ?? 'Effort not entered; no delivery commitment.',
            ],
            'pricing' => $terms['price'] ?? 'Not entered',
            'currency' => $terms['currency'] ?? 'Not entered',
            'payment_structure' => $terms['payment_structure'] ?? 'Not agreed; authorized commercial review required.',
            'maintenance' => $terms['maintenance'],
            'support' => $terms['support'] ?? 'Not agreed; scope, response targets and duration require human agreement.',
            'third_party_costs' => $terms['third_party_costs'],
            'client_responsibilities' => $terms['client_responsibilities'],
            'commitment_notice' => 'Nonbinding draft. Scope review is separate from client confirmation and commercial authorization. No final price, delivery date or contract is approved by generation.',
        ];
    }
}
