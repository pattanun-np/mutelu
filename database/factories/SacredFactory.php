<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Sacredplace;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SacredFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'name' => fake()->name(),
            'description' => fake()->sentence(),
            'image' => fake()->imageUrl(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => fake()->dateTimeBetween('-1 year', 'now'),
            //
        ];
    }

    public function run()
    {
        Sacredplace::factory()->count(10)->create();
    }
}
