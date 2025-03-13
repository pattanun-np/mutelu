<?php

namespace App\Console\Commands;

use Database\Seeders\SacredplaceSeeder;
use Illuminate\Console\Command;

class SeedSacredPlaces extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:sacred-places';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with sacred places including downloading images from URLs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to seed sacred places...');

        // Run the seeder
        $seeder = new SacredplaceSeeder();
        $seeder->setCommand($this);
        $seeder->run();

        $this->info('Sacred places seeded successfully!');

        return Command::SUCCESS;
    }
}
