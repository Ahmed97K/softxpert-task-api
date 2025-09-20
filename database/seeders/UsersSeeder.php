<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Enums\UserRoles;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $manager = User::factory()->create([
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'password' => 'password',
        ]);
        $manager->assignRole(UserRoles::ADMIN->value);

        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => 'password',
        ]);
        $user->assignRole(UserRoles::USER->value);

        $user2 = User::factory()->create([
            'name' => 'User 2',
            'email' => 'user2@example.com',
            'password' => 'password',
        ]);
        $user2->assignRole(UserRoles::USER->value);

    }
}
