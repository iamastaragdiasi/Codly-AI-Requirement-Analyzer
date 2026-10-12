<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Models\Project;
use App\Models\User;
use App\WorkspaceRevision;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $projects = Project::where('user_id', $request->user()->id)->orWhere('reviewer_id', $request->user()->id)->latest('id')->paginate(20);

        return view('projects', compact('projects'));
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $project = DB::transaction(function () use ($request): Project {
            $created = Project::create($request->validated() + ['user_id' => $request->user()->id]);
            $created->refresh();
            $created->auditEvents()->create(['user_id' => $request->user()->id, 'revision' => $created->revision, 'action' => 'project_created']);
            $created->artifacts()->create(['user_id' => $request->user()->id, 'revision' => $created->revision, 'kind' => 'project_context', 'content' => ['after' => $created->only(['name', 'business_problem', 'objectives', 'target_users'])]]);

            return $created;
        });

        return redirect()->route('projects.show', $project);
    }

    public function show(Project $project): View
    {
        Gate::authorize('view', $project);
        $project->load(['sources', 'analyses', 'artifacts', 'approvals', 'auditEvents']);
        $analysis = $project->analyses->sortByDesc('id')->first();
        $reviewers = User::where('is_reviewer', true)->get(['id', 'name']);

        return view('workspace', compact('project', 'analysis', 'reviewers'));
    }

    public function update(StoreProjectRequest $request, Project $project, WorkspaceRevision $revisions): RedirectResponse
    {
        Gate::authorize('update', $project);
        DB::transaction(function () use ($project, $request, $revisions): void {
            $locked = Project::whereKey($project->id)->lockForUpdate()->firstOrFail();
            Gate::authorize('update', $locked);
            abort_unless($locked->revision === $request->integer('revision'), 409, 'Revision changed; reload before saving.');
            $before = $locked->only(['name', 'business_problem', 'objectives', 'target_users']);
            $locked->update($request->safe()->except('revision'));
            $revisions->advance($locked, $request->user(), 'project_updated');
            $locked->artifacts()->create(['user_id' => $request->user()->id, 'revision' => $locked->revision, 'kind' => 'project_context', 'content' => ['before' => $before, 'after' => $locked->only(['name', 'business_problem', 'objectives', 'target_users'])]]);
        });

        return redirect()->route('projects.show', $project);
    }

    public function assign(Request $request, Project $project, WorkspaceRevision $revisions): RedirectResponse
    {
        Gate::authorize('view', $project);

        $data = $request->validate([
            'reviewer_id' => 'required|integer',
            'revision' => 'sometimes|required|integer',
        ]);

        DB::transaction(function () use ($project, $request, $data, $revisions): void {
            $locked = Project::whereKey($project->id)->lockForUpdate()->firstOrFail();

            abort_unless((int) $locked->user_id === (int) $request->user()->id, 403);

            if (array_key_exists('revision', $data)) {
                abort_unless(
                    $locked->revision === (int) $data['revision'],
                    409,
                    'Revision changed; reload before assigning a reviewer.'
                );
            }

            abort_unless(
                User::whereKey($data['reviewer_id'])->where('is_reviewer', true)->exists(),
                422,
                'Selected user is not an eligible reviewer.'
            );

            $locked->update(['reviewer_id' => $data['reviewer_id']]);

            $revisions->advance($locked, $request->user(), 'reviewer_assigned');

            $locked->auditEvents()->create([
                'user_id' => $request->user()->id,
                'revision' => $locked->revision,
                'action' => 'reviewer_assigned',
            ]);
        });

        return redirect()->route('projects.show', $project);
    }
}
