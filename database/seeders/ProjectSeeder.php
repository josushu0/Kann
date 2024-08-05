<?php

namespace Database\Seeders;

use App\Models\Column;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()->take(3)->each(function (User $user) {
            Project::factory(1)
                ->for($user->personalTeam())
                ->has(Column::factory()
                    ->sequence(fn (Sequence $sequence) => ['name' => 'To do', 'position' => ($sequence->index + 1) * 60000])
                    ->has(Task::factory()
                        ->sequence(fn (Sequence $sequence) => ['position' => ($sequence->index + 1) * 60000])
                        ->count(3)
                    )
                    ->count(3)
                )
                ->create();
        });
    }
}
