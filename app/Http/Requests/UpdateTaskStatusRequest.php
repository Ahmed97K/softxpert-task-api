<?php

namespace App\Http\Requests;

use App\Enums\TaskStatusEnum;
use App\Rules\StatusChangeAllowed;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateTaskStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', new Enum(TaskStatusEnum::class), new StatusChangeAllowed($this->route('task'))],
        ];
    }
}
