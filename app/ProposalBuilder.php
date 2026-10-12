<?php

namespace App;

use App\Models\Project;

class ProposalBuilder
{
    /** @param array<string,mixed> $terms @return array<string,mixed> */
    public function draft(Project $project, array $terms): array
    {
        return ['status' => 'Draft — requires authorized technical/PM and commercial review', 'analysis_id' => $project->analyses()->where('revision', $project->revision)->latest('id')->value('id'), 'scope_revision' => $project->revision, 'scope_snapshot' => $project->analyses()->where('revision', $project->revision)->latest('id')->firstOrFail()->results, 'technical_approach' => 'Suggested Laravel and relational database design; developer validation required.', 'estimate' => ['status' => 'Provisional — requires authorized technical/PM review', 'effort_hours' => $terms['effort_hours'] ?? null, 'notes' => $terms['estimate_notes'] ?? 'Effort not entered; no delivery commitment.'], 'pricing' => $terms['price'] ?? 'Not entered', 'currency' => $terms['currency'] ?? 'Not entered', 'maintenance' => $terms['maintenance'], 'third_party_costs' => $terms['third_party_costs'], 'client_responsibilities' => $terms['client_responsibilities']];
    }
}
