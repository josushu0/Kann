<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Column>
 */
class ColumnFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
        ];
    }

    public function withTasks(?callable $callback = null): static
    {
        return $this->has(
            Task::factory()
                ->count(3)
                ->sequence(
                    ['position' => 60000],
                    ['position' => 120000],
                    ['position' => 200000]
                )
                ->when(is_callable($callback), $callback),
            'tasks'
        );
    }
}
