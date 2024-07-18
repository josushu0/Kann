<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);

        if ($this->command->confirm('Seed development data?', false)) {
            $this->call([
                DevelopmentSeeder::class,
            ]);
        }
    }
}
