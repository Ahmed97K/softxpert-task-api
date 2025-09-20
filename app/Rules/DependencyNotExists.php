<?php

namespace App\Rules;

use App\Models\Task;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DependencyNotExists implements ValidationRule
{
    public function __construct(private Task $task) {}

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Single query: Check if dependency exists AND get the task title
        $dependencyTask = $this->task->dependencies()
            ->where('depends_on_task_id', (int) $value)
            ->first();

        if ($dependencyTask) {
            $fail(__('validation.dependency_already_exists', [
                'task' => $dependencyTask->title,
            ]));
        }
    }
}
