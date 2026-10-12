<?php

namespace App;

use App\Models\Project;
use App\Models\User;

class Audit
{
    public function record(Project $project, User $user, string $action): void
    {
        $project->auditEvents()->create(['user_id' => $user->id, 'revision' => $project->revision, 'action' => $action]);
    }
}
