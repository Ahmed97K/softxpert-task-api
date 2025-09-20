<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Enums\UserRolesEnum;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $manager = Role::firstOrCreate(['name' => UserRolesEnum::ADMIN->value]);
        $user    = Role::firstOrCreate(['name' => UserRolesEnum::USER->value]);

        $manager->syncPermissions([
            'tasks.create',
            'tasks.update.any',
            'tasks.view.any',
            'tasks.dependencies.manage',
        ]);

        $user->syncPermissions([
            'tasks.view.own',
            'tasks.status.update.own',
        ]);
    }
}
