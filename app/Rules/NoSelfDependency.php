<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoSelfDependency implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

     public function __construct(private int $taskId) {}

     public function validate(string $attribute, mixed $value, Closure $fail): void
     {
         if ((int) $value === $this->taskId) {
             $fail(__('validation.no_self_dependency'));
         }
     }

}
