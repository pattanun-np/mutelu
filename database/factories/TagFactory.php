<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tag;
use App\Models\Sacredplace;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
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
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function run()
    {
        Tag::factory()->count(10)->create();
        $tags = Tag::all();
        $sacredplaces = Sacredplace::all();

        foreach ($sacredplaces as $sacredplace) {
            $sacredplace->tags()->attach($tags->random(3));
        }
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
