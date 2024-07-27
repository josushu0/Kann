<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if ($this->command->confirm('Seed development data?', false)) {
            $this->call([
                UserSeeder::class,
                ProjectSeeder::class,
            ]);
        } else {
            $this->call([
                ProductionSeeder::class,
            ]);
        }
    }
}
