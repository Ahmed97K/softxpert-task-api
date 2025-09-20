<?php

namespace Database\Factories;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {

        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(TaskStatusEnum::cases()),
            'priority' => fake()->randomElement(TaskPriorityEnum::cases()),
            'due_date' => fake()->dateTimeBetween('now', '+1 month'),
            'assignee_id' => UserFactory::new()->user()->create()->id,
            'created_by_id' => UserFactory::new()->admin()->create()->id,
        ];
    }
}
