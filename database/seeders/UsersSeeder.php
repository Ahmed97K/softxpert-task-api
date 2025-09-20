<?php

namespace Database\Seeders;

use App\Enums\UserRolesEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $manager = User::factory()->create([
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'password' => 'password',
        ]);
        $manager->assignRole(UserRolesEnum::ADMIN->value);

        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => 'password',
        ]);
        $user->assignRole(UserRolesEnum::USER->value);

        $user2 = User::factory()->create([
            'name' => 'User 2',
            'email' => 'user2@example.com',
            'password' => 'password',
        ]);
        $user2->assignRole(UserRolesEnum::USER->value);

    }
}
