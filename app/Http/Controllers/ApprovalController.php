<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ApprovalController extends Controller
{
    public function store(Request $request, Project $project): RedirectResponse
    {
        Gate::authorize('review', $project);
        $data = $request->validate(['revision' => 'required|integer', 'decision' => 'required|in:approved,rejected,changes_requested', 'notes' => 'required|string|max:2000']);
        DB::transaction(function () use ($request, $project, $data): void {
            $locked = Project::whereKey($project->id)->lockForUpdate()->firstOrFail();
            Gate::authorize('review', $locked);
            abort_unless($locked->revision === (int) $data['revision'], 409, 'Revision changed; approval refused.');
            abort_unless($locked->analyses()->where('revision', $locked->revision)->where('status', 'complete')->exists(), 422, 'Complete analysis of current revision required.');
            $locked->approvals()->create($data + ['user_id' => $request->user()->id]);
            $locked->auditEvents()->create(['user_id' => $request->user()->id, 'revision' => $locked->revision, 'action' => 'review_'.$data['decision']]);
        });

        return redirect()->route('projects.show', $project);
    }
}
