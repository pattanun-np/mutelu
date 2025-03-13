<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Sacredplace;

class SacredplaceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sacredplace::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        $latitude = $this->faker->latitude();
        $longitude = $this->faker->longitude();
        
        return [
            'name' => $this->faker->unique()->words(rand(2, 4), true),
            'description' => $this->faker->paragraph(rand(3, 6)),
            'image' => 'images/sacred-places/' . $this->faker->numberBetween(1, 10) . '.jpg',
            'latitude' => $latitude,
            'longitude' => $longitude,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];

      
    }
}
