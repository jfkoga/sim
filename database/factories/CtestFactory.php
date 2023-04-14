<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ctest>
 */
class CtestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ctest' => fake()->sentence(),
            'title' => fake()->word(),
            'idLanguage' => fake()->numberBetween(1, 3),
            'idPool' => fake()->unique()->numberBetween(1, 99),
            'answers' => fake()->sentence(),
            'created_at' => fake()->dateTimeBetween('-1 month', 'now', 'Europe/Madrid'),
            'updated_at' => Carbon::now()
        ];
    }
}
