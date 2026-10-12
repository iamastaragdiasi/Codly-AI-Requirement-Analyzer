<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\ProposalBuilder;
use App\WorkspaceRevision;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ProposalController extends Controller
{
    public function store(Request $request, Project $project, ProposalBuilder $builder, WorkspaceRevision $revisions): RedirectResponse
    {
        Gate::authorize('review', $project);
        $data = $request->validate(['revision' => 'required|integer', 'effort_hours' => 'nullable|numeric|min:0|max:1000000', 'estimate_notes' => 'nullable|string|max:2000', 'price' => 'nullable|numeric|min:0|max:999999999', 'currency' => 'required_with:price|nullable|in:INR,USD,EUR,GBP', 'maintenance' => 'required|string|max:5000', 'third_party_costs' => 'required|string|max:5000', 'client_responsibilities' => 'required|string|max:5000']);
        DB::transaction(function () use ($request, $project, $builder, $revisions, $data): void {
            $locked = Project::whereKey($project->id)->lockForUpdate()->firstOrFail();
            Gate::authorize('review', $locked);
            abort_unless($locked->revision === (int) $data['revision'], 409);
            abort_unless($locked->isApproved(), 422, 'Approve current scope before drafting proposal.');
            $analysis = $locked->analyses()->where('revision', $locked->revision)->latest('id')->firstOrFail();
            $content = $builder->draft($locked, $data);
            $revisions->advance($locked, $request->user(), 'proposal_drafted');
            $locked->artifacts()->create(['user_id' => $request->user()->id, 'revision' => $locked->revision, 'kind' => 'proposal', 'content' => $content]);
            $locked->analyses()->create(['revision' => $locked->revision, 'status' => 'complete', 'provider' => $analysis->provider, 'results' => $analysis->results, 'failures' => []]);
        });

        return redirect()->route('projects.show', $project);
    }
}
