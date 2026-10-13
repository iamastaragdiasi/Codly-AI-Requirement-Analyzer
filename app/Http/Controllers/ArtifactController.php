<?php

namespace App\Http\Controllers;

use App\AnalysisPipeline;
use App\AnalysisValidator;
use App\Models\Project;
use App\WorkspaceRevision;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ArtifactController extends Controller
{
    public function store(Request $request, Project $project, WorkspaceRevision $revisions, AnalysisValidator $validator): RedirectResponse
    {
        Gate::authorize('review', $project);
        $data = $request->validate(['revision' => 'required|integer', 'module' => 'required|in:'.implode(',', AnalysisPipeline::MODULES), 'index' => 'required|integer|min:0', 'title' => 'required|string|max:1000', 'scope' => 'required|in:included,excluded,assumption,optional,unresolved', 'priority' => 'required|in:Must,Should,Could,Future', 'category' => 'nullable|in:Functional,Non-Functional,Technical,Business,Optional', 'notes' => 'required|string|max:2000', 'decision' => 'required|in:edited,client_confirmed,rejected,resolved', 'role' => 'nullable|string|max:5000', 'objective' => 'nullable|string|max:10000', 'feature' => 'nullable|string|max:500', 'dependencies' => 'nullable|string|max:2000', 'evidence' => 'required_if:decision,client_confirmed|nullable|string|max:2000']);
        DB::transaction(function () use ($request, $project, $revisions, $validator, $data): void {
            $locked = Project::whereKey($project->id)->lockForUpdate()->firstOrFail();
            Gate::authorize('review', $locked);
            abort_unless($locked->revision === (int) $data['revision'], 409, 'Revision changed; reload before reviewing.');
            $analysis = $locked->analyses()->where('revision', $locked->revision)->latest('id')->first();
            abort_unless($analysis && $analysis->status === 'complete', 422, 'Analyze current revision first.');
            $results = $analysis->results;
            $old = $results[$data['module']]['items'][$data['index']] ?? null;
            abort_unless($old, 422);
            $new = array_replace($old, array_intersect_key($data, array_flip(['title', 'scope', 'priority', 'category', 'notes', 'role', 'objective', 'feature'])));
            if (array_key_exists('dependencies', $data)) {
                $new['dependencies'] = array_values(array_filter(array_map('trim', explode(',', $data['dependencies'] ?? ''))));
            }
            if ($old['provenance'] === 'Client Confirmed' && $new !== $old) {
                $new['provenance'] = 'AI Inferred';
            }
            if ($data['decision'] === 'rejected') {
                $new['scope'] = 'excluded';
            }
            if ($data['decision'] === 'client_confirmed') {
                $source = $locked->sources()->create(['user_id' => $request->user()->id, 'kind' => 'confirmation', 'original' => $data['evidence'], 'metadata' => ['reference' => $data['module'].':'.$data['index'], 'client_confirmed' => true, 'priority' => $data['priority'], 'role' => $old['role'], 'feature' => $old['feature']]]);
                $new['provenance'] = 'Client Confirmed';
                $new['source_ids'][] = $source->id;
                $new['statements'][] = $source->original;
            }
            $results[$data['module']]['items'][$data['index']] = $new;
            $validator->validate($results[$data['module']], $locked->sources()->get()->toArray());
            $revisions->advance($locked, $request->user(), 'finding_reviewed');
            $locked->artifacts()->create(['user_id' => $request->user()->id, 'revision' => $locked->revision, 'kind' => 'review', 'content' => ['module' => $data['module'], 'index' => $data['index'], 'before' => $old, 'after' => $new, 'decision' => $data['decision'], 'evidence' => $data['evidence'] ?? null]]);
            $locked->analyses()->create(['revision' => $locked->revision, 'status' => 'complete', 'provider' => $analysis->provider, 'results' => $results, 'failures' => []]);
        });

        return redirect()->route('projects.show', $project);
    }
}
