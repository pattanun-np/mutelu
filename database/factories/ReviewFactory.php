<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Review;
use App\Models\Sacredplace;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'body' => fake()->paragraph(),
            'rating' => fake()->numberBetween(1, 5),
            'sacredplace_id' => fake()->numberBetween(1, 10),
            'user_id' => fake()->numberBetween(1, 10),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => fake()->dateTimeBetween('-1 year', 'now'),

        ];
    }

    public function run()
    {
        Review::factory()->count(10)->create();
    }

    public function withSacredplace()
    {
        return $this->hasOne(Sacredplace::class);
    }

    public function withUser()
    {
        return $this->hasOne(User::class);
    }
}

