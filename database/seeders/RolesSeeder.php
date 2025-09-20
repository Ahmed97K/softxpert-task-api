<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Enums\UserRolesEnum;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles only - no permissions needed
        Role::firstOrCreate(['name' => UserRolesEnum::ADMIN->value]);
        Role::firstOrCreate(['name' => UserRolesEnum::USER->value]);
    }
}
