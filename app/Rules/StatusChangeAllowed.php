<?php

namespace App\Rules;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StatusChangeAllowed implements ValidationRule
{
    public function __construct(private Task $task) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $newStatus = $value instanceof TaskStatusEnum ? $value : TaskStatusEnum::from($value);

        if (! $this->task->canChangeStatusTo($newStatus)) {
            $incompleteDependencies = $this->task->getIncompleteDependencies();
            $dependencyTitles = $incompleteDependencies->pluck('title')->implode(', ');

            $fail(__('validation.cannot_complete_with_dependencies', [
                'dependencies' => $dependencyTitles,
            ]));
        }
    }
}
