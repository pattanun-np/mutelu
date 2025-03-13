<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Sacredplace;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users and sacred places
        $users = User::all();
        $sacredPlaces = Sacredplace::all();

        // Create reviews ensuring no duplicates
        foreach ($users as $user) {
            // Randomly select some sacred places for this user
            $randomSacredPlaces = $sacredPlaces->random(rand(1, 3));

            foreach ($randomSacredPlaces as $sacredPlace) {
                Review::factory()->create(
                    [
                        'user_id' => $user->id,
                        'sacredplace_id' => $sacredPlace->id,
                    ]
                );
            }
        }
    }
}
