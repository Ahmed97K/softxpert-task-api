<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowTaskResource extends JsonResource
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
            'task_dependencies' => TaskDependencyResource::collection($this->whenLoaded('dependencies')),
            'assigned_user' => UserSummaryResource::make($this->whenLoaded('assignedUser')),
            'created_by' => UserSummaryResource::make($this->whenLoaded('creator')),
            'due_date' => $this->due_date->frontEndFormat(),
            'created_at' => $this->created_at->frontEndFormat(),
        ];
    }
}
