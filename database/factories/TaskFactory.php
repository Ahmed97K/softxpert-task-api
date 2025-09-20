<?php

namespace Database\Factories;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Enums\UserRoles;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;
use App\Models\User;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {

        return [
            'title'       => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'status'      => fake()->randomElement(TaskStatus::cases()),
            'priority'    => fake()->randomElement(TaskPriority::cases()),
            'due_date'    => fake()->dateTimeBetween('now', '+1 month'),
            'assignee_id' => UserFactory::new()->user()->create()->id,
            'created_by_id'  => UserFactory::new()->admin()->create()->id,
        ];
    }

}
