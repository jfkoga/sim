<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MCQ>
 */
class MCQFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phrase' => fake()->sentence(),
            'A' => fake()->word(),
            'B' => fake()->word(),
            'C' => fake()->word(),
            'D' => fake()->word(),
            'SOL' => fake()->randomElement(['A', 'B', 'C', 'D']),
            'level' => fake()->numberBetween(1, 4),
            'idType' => 0,
            'idItemType' => 0
        ];
    }
}
