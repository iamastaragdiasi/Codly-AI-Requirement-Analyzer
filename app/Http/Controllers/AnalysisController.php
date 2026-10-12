<?php

namespace App\Http\Controllers;

use App\AnalysisPipeline;
use App\Models\Project;
use App\WorkspaceRevision;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AnalysisController extends Controller
{
    public function store(Request $request, Project $project, AnalysisPipeline $pipeline, WorkspaceRevision $revisions): RedirectResponse
    {
        Gate::authorize('contribute', $project);
        DB::transaction(function () use ($project, $pipeline, $revisions, $request): void {
            $locked = Project::whereKey($project->id)->lockForUpdate()->firstOrFail();
            Gate::authorize('contribute', $locked);
            abort_unless($locked->sources()->exists(), 422, 'Submit at least one requirement.');
            $revisions->advance($locked, $request->user(), 'analysis_generated');
            $pipeline->analyze($locked);
        });

        return redirect()->route('projects.show', $project);
    }
}
