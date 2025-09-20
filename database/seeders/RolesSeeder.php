<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Enums\UserRoles;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $manager = Role::firstOrCreate(['name' => UserRoles::ADMIN->value]);
        $user    = Role::firstOrCreate(['name' => UserRoles::USER->value]);

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
