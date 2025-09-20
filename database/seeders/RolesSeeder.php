<?php

namespace Database\Seeders;

use App\Enums\UserRolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles only - no permissions needed
        Role::firstOrCreate(['name' => UserRolesEnum::ADMIN->value]);
        Role::firstOrCreate(['name' => UserRolesEnum::USER->value]);
    }
}
