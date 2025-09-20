<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{

    public function view(User $user, Task $task): bool
    {
        return $task->assignee_id === $user->id;
    }

    public function updateStatus(User $user, Task $task): bool
    {
        return $task->assignee_id === $user->id;
    }

}
