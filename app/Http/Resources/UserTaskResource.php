<?php

namespace App\Http\Resources;

use App\Http\Resources\UserSummaryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserTaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,
            'created_by' => UserSummaryResource::make($this->whenLoaded('creator')),
            'due_date' => $this->when($this->due_date, fn() => $this->due_date->frontEndFormat()),
            'created_at' => $this->created_at->frontEndFormat(),
            'updated_at' => $this->updated_at->frontEndFormat(),
        ];
    }
}
