<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\TaskList;
use App\Models\User;
use Illuminate\Database\Seeder;

class DevelopmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(100)->create();
        Project::factory(10)
            ->has(TaskList::factory(3)
                ->sequence(
                    ['name' => 'To do', 'position' => 60000],
                    ['name' => 'Doing', 'position' => 120000],
                    ['name' => 'Done', 'position' => 180000]))
            ->create();
    }
}
