<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    public function view(User $user, Project $project): Response
    {
        return in_array($user->id, [$project->user_id, $project->reviewer_id], true) ? Response::allow() : Response::denyAsNotFound();
    }

    public function update(User $user, Project $project): Response
    {
        return $user->id === $project->user_id
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function contribute(User $user, Project $project): Response
    {
        $isOwner = (int) $user->id === (int) $project->user_id;
        $isAssignedReviewer = (bool) $user->is_reviewer
            && $project->reviewer_id !== null
            && (int) $project->reviewer_id === (int) $user->id;

        return ($isOwner || $isAssignedReviewer)
            ? Response::allow()
            : Response::denyAsNotFound();
    }
    public function review(User $user, Project $project): bool
    {
        return $user->is_reviewer && $project->reviewer_id === $user->id;
    }
}
