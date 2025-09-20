<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use App\Enums\TaskPriorityEnum;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $task = $this->route('task');

        return [
            'title'       => ['sometimes','required','string','max:255'],
            'description' => ['sometimes','nullable','string'],
            'due_date'    => ['sometimes','nullable','date','after_or_equal:today'],
            'assignee_id' => ['sometimes','nullable','integer', Rule::exists('users','id')],
            'priority'    => ['sometimes','nullable', new Enum(TaskPriorityEnum::class)],
        ];
    }
}
