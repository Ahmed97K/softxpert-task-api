<?php

namespace App\Http\Requests\User;

use App\Enums\TaskStatusEnum;
use App\Rules\StatusChangeAllowed;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Enum;

class UpdateUserTaskStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('updateStatus', $this->route('task'));
    }

    public function rules(): array
    {
        return [
            'status' => [
                'required',
                new Enum(TaskStatusEnum::class),
                new StatusChangeAllowed($this->route('task')),
            ],
        ];
    }
}
