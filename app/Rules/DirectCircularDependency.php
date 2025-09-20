<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class DirectCircularDependency implements ValidationRule
{
    public function __construct(private int $taskId) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = DB::table('task_dependencies')
            ->where('task_id', (int) $value)
            ->where('depends_on_task_id', $this->taskId)
            ->exists();

        if ($exists) {
            $fail(__('validation.direct_circular_dependency'));
        }
    }
}
