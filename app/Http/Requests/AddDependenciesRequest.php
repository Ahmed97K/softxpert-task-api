<?php

namespace App\Http\Requests;

use App\Rules\DependencyNotExists;
use App\Rules\DirectCircularDependency;
use App\Rules\NoSelfDependency;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddDependenciesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $task = $this->route('task');

        return [
            'dependencies' => ['required', 'array', 'min:1'],
            'dependencies.*' => [
                'integer', 'distinct', Rule::exists('tasks', 'id'),
                new NoSelfDependency($task->id),
                new DirectCircularDependency($task->id),
                new DependencyNotExists($task),
            ],
        ];
    }
}
