<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;
use Database\Seeders\TagSeeder;
use Database\Seeders\SacredplaceSeeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TagSeeder::class, // Tags are now created in SacredplaceSeeder
            SacredplaceSeeder::class,
            UserSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
