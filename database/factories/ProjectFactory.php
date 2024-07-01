<?php

namespace Database\Factories;

use App\Models\Column;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'description' => $this->faker->text(),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
        ];
    }

    public function withDefaultColumns(?callable $callback = null): static
    {
        return $this->has(
            Column::factory()
                ->count(3)
                ->sequence(
                    ['name' => 'To do', 'position' => 60000],
                    ['name' => 'Doing', 'position' => 120000],
                    ['name' => 'Done', 'position' => 200000],
                )
                ->withTasks()
                ->when(is_callable($callback), $callback),
            'columns',
        );
    }
}
