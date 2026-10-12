<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSourceRequest;
use App\Models\Project;
use App\WorkspaceRevision;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class SourceController extends Controller
{
    public function store(StoreSourceRequest $request, Project $project, WorkspaceRevision $revisions): RedirectResponse
    {
        $data = $request->validated();
        DB::transaction(function () use ($request, $project, $revisions, $data): void {
            $locked = Project::whereKey($project->id)->lockForUpdate()->firstOrFail();
            Gate::authorize('contribute', $locked);
            abort_if($locked->sources()->count() >= 100, 422, 'MVP limit: 100 sources per project.');
            $total = $locked->sources()->pluck('original')->sum(fn (string $text): int => mb_strlen($text));
            abort_if($total + mb_strlen($data['original']) > 200000, 422, 'MVP limit: 200,000 total source characters per project.');
            $locked->sources()->create(['user_id' => $request->user()->id, 'kind' => $data['kind'], 'original' => $data['original'], 'metadata' => ['priority' => $data['priority'], 'role' => $data['role'] ?? null, 'feature' => $data['feature'] ?? null, 'reference' => $data['reference'] ?? null, 'client_confirmed' => false]]);
            $revisions->advance($locked, $request->user(), 'source_submitted');
        });

        return redirect()->route('projects.show', $project);
    }
}
