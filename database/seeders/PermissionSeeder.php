<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public static $permissions = [
        'users',
        'users.view',
        'users.edit',
        'users.update',
        'users.destroy',
        'roles',
        'roles.view',
        'roles.edit',
        'roles.update',
        'roles.destroy',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (self::$permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
