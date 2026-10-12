<?php

namespace App;

use App\Models\Project;
use App\Models\User;

class WorkspaceRevision
{
    public function advance(Project $project, User $user, string $action): void
    {
        $project->increment('revision');
        $project->auditEvents()->create(['user_id' => $user->id, 'revision' => $project->revision, 'action' => $action]);
    }
}
