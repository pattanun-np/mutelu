<?php

namespace Database\Seeders;

use App\Models\Sacredplace;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class SacredplaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some tags first
        $tags = $this->createTags();

        // Create a Faker instance
        $faker = Faker::create();

        // Sample sacred places data with image URLs as templates
        $templatePlaces = [
            [
                'name' => 'Angkor Wat',
                'description' => 'Angkor Wat is a temple complex in Cambodia and is the largest religious monument in the world. It was originally constructed as a Hindu temple dedicated to the god Vishnu for the Khmer Empire, gradually transforming into a Buddhist temple toward the end of the 12th century.',
                'latitude' => 13.4125,
                'longitude' => 103.8670,
                'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/44/Ankor_Wat_temple.jpg/1200px-Ankor_Wat_temple.jpg',
                'tags' => [1, 3, 5],
                'type' => 'temple'
            ],
            [
                'name' => 'Machu Picchu',
                'description' => 'Machu Picchu is an Incan citadel set high in the Andes Mountains in Peru, above the Urubamba River valley. Built in the 15th century and later abandoned, it\'s renowned for its sophisticated dry-stone walls that fuse huge blocks without the use of mortar, intriguing buildings that play on astronomical alignments and panoramic views.',
                'latitude' => -13.1631,
                'longitude' => -72.5450,
                'image_url' => 'https://lh3.googleusercontent.com/p/AF1QipO6Aq6NQrjRcaQo1fChp4XnHsCiqZb2UXWmYprZ=s1360-w1360-h1020',
                'tags' => [2, 3, 4],
                'type' => 'ruins'
            ],
            [
                'name' => 'Stonehenge',
                'description' => 'Stonehenge is a prehistoric monument on Salisbury Plain in Wiltshire, England. It consists of a ring of standing stones, each around 13 feet high, seven feet wide, and weighing around 25 tons. The stones are set within earthworks in the middle of the most dense complex of Neolithic and Bronze Age monuments in England.',
                'latitude' => 51.1789,
                'longitude' => -1.8262,
                'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3c/Stonehenge2007_07_30.jpg/1200px-Stonehenge2007_07_30.jpg',
                'tags' => [2, 5],
                'type' => 'monument'
            ],
            [
                'name' => 'Uluru (Ayers Rock)',
                'description' => 'Uluru, also known as Ayers Rock, is a large sandstone rock formation in the southern part of the Northern Territory in central Australia. It is sacred to the Aboriginal people of the area, known as the Anangu. The area around the formation is home to an abundance of springs, waterholes, rock caves, and ancient paintings.',
                'latitude' => -25.3444,
                'longitude' => 131.0369,
                'image_url' => 'https://cdn.britannica.com/49/20349-050-C5029C80/Uluru-Ayers-Rock-Uluru-Kata-Tjuta-National-Park-Australia.jpg',
                'tags' => [2, 3, 5],
                'type' => 'natural'
            ],
            [
                'name' => 'Borobudur',
                'description' => 'Borobudur is a 9th-century Mahayana Buddhist temple in Magelang Regency, not far from the town of Muntilan, in Central Java, Indonesia. It is the world\'s largest Buddhist temple. The temple consists of nine stacked platforms, six square and three circular, topped by a central dome.',
                'latitude' => -7.6079,
                'longitude' => 110.2038,
                'image_url' => 'https://lh3.googleusercontent.com/gps-cs-s/AB5caB9we7RCa0IsZEHl2ArM-mJHGGwxgLkP3iqs-uPpmrv_lu12hcNToGUG6ZUHLMT0OkV4kwd5R-crXdXBucJFYEzT3Wkseh4uBxAHRZebnrqHLqoBAoopK1cqriJ2q7Fthl5XAQKm=s1360-w1360-h1020',
                'tags' => [1, 3, 5],
                'type' => 'temple'
            ],
        ];

        // Additional image URLs for variety
        $additionalImageUrls = [
            'temple' => [
                'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b4/Golden_Temple%2C_Amritsar%2C_India.jpg/1200px-Golden_Temple%2C_Amritsar%2C_India.jpg',
                'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4c/Temple_of_Heaven%2C_Beijing%2C_China_-_panoramio.jpg/1200px-Temple_of_Heaven%2C_Beijing%2C_China_-_panoramio.jpg',
                'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9c/Wat_Arun_Bangkok_Thailand_01.jpg/1200px-Wat_Arun_Bangkok_Thailand_01.jpg',
            ],
            'ruins' => [
                'https://upload.wikimedia.org/wikipedia/commons/thumb/d/de/Colosseum_in_Rome-April_2007-1-_copie_2B.jpg/1200px-Colosseum_in_Rome-April_2007-1-_copie_2B.jpg',
                'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1e/Parthenon%2C_Athens%2C_Greece.jpg/1200px-Parthenon%2C_Athens%2C_Greece.jpg',
                'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5f/Chichen_Itza_3.jpg/1200px-Chichen_Itza_3.jpg',
            ],
            'monument' => [
                'https://upload.wikimedia.org/wikipedia/commons/thumb/d/df/Taj_Mahal_03.jpg/1200px-Taj_Mahal_03.jpg',
                'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e6/Eiffel_Tower_from_the_Tour_Montparnasse_1%2C_Paris_May_2014.jpg/1200px-Eiffel_Tower_from_the_Tour_Montparnasse_1%2C_Paris_May_2014.jpg',
                'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d6/Statue_of_Liberty%2C_NY.jpg/1200px-Statue_of_Liberty%2C_NY.jpg',
            ],
            'natural' => [
                'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f5/Grand_Canyon_Hopi_Point_with_rainbow_2013.jpg/1200px-Grand_Canyon_Hopi_Point_with_rainbow_2013.jpg',
                'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c5/Moraine_Lake_17092005.jpg/1200px-Moraine_Lake_17092005.jpg',
                'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1c/Iguazu_Falls_from_Brazil.jpg/1200px-Iguazu_Falls_from_Brazil.jpg',
            ],
        ];

        // Name prefixes and suffixes for generating variations
        $prefixes = [
            'temple' => ['Ancient', 'Sacred', 'Holy', 'Divine', 'Mystic', 'Celestial', 'Eternal', 'Blessed', 'Venerated', 'Hallowed'],
            'ruins' => ['Lost', 'Ancient', 'Forgotten', 'Hidden', 'Mysterious', 'Abandoned', 'Legendary', 'Mythical', 'Prehistoric', 'Primeval'],
            'monument' => ['Great', 'Majestic', 'Towering', 'Monumental', 'Colossal', 'Impressive', 'Historic', 'Iconic', 'Renowned', 'Famous'],
            'natural' => ['Sacred', 'Mystical', 'Enchanted', 'Magical', 'Pristine', 'Untouched', 'Primordial', 'Ancient', 'Spiritual', 'Divine'],
        ];

        $suffixes = [
            'temple' => ['Temple', 'Shrine', 'Sanctuary', 'Monastery', 'Pagoda', 'Cathedral', 'Chapel', 'Basilica', 'Altar', 'Tabernacle'],
            'ruins' => ['Ruins', 'Citadel', 'Fortress', 'City', 'Settlement', 'Civilization', 'Kingdom', 'Empire', 'Stronghold', 'Outpost'],
            'monument' => ['Monument', 'Memorial', 'Statue', 'Obelisk', 'Pillar', 'Column', 'Arch', 'Tower', 'Spire', 'Landmark'],
            'natural' => ['Mountain', 'Valley', 'Canyon', 'Waterfall', 'Lake', 'River', 'Forest', 'Cave', 'Spring', 'Island'],
        ];

        // Generate 200 sacred places
        $totalPlaces = 200;
        $placesCreated = 0;

        // First, create the original template places
        foreach ($templatePlaces as $placeData) {
            // Create the sacred place
            $place = Sacredplace::create([
                'name' => $placeData['name'],
                'description' => $placeData['description'],
                'latitude' => $placeData['latitude'],
                'longitude' => $placeData['longitude'],
                'image' => 'placeholder.png', // Add a default value for the image column
            ]);

            // Download and add the image
            $this->downloadAndAddImage($place, $placeData['image_url']);

            // Sync tags
            $place->syncTags($placeData['tags']);

            $this->command->info("Created sacred place: {$place->name}");
            $placesCreated++;
        }

        // Then generate variations until we reach 200
        while ($placesCreated < $totalPlaces) {
            // Pick a random template
            $template = $faker->randomElement($templatePlaces);
            $type = $template['type'];

            // Generate a new name
            $prefix = $faker->randomElement($prefixes[$type]);
            $suffix = $faker->randomElement($suffixes[$type]);
            $name = "{$prefix} {$suffix} of " . $faker->country;

            // Generate a new description
            $description = "The {$name} is a " . $faker->sentence(10) . " " . $faker->paragraph(3);

            // Generate new coordinates (slightly offset from the template)
            $latOffset = $faker->randomFloat(4, -2, 2);
            $longOffset = $faker->randomFloat(4, -2, 2);
            $latitude = $template['latitude'] + $latOffset;
            $longitude = $template['longitude'] + $longOffset;

            // Ensure latitude is within valid range (-90 to 90)
            $latitude = max(-90, min(90, $latitude));

            // Ensure longitude is within valid range (-180 to 180)
            $longitude = max(-180, min(180, $longitude));

            // Pick random tags (2-4 tags)
            $numTags = $faker->numberBetween(2, 4);
            $tagIds = $faker->randomElements(range(1, count($tags)), $numTags);

            // Pick an image URL based on the type
            $imageUrl = $faker->randomElement(
                array_merge(
                    [$template['image_url']],
                    $additionalImageUrls[$type]
                )
            );

            // Create the sacred place
            $place = Sacredplace::create([
                'name' => $name,
                'description' => $description,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'image' => 'placeholder.png', // Add a default value for the image column
            ]);

            // Download and add the image
            $this->downloadAndAddImage($place, $imageUrl);

            // Sync tags
            $place->syncTags($tagIds);

            $this->command->info("Created sacred place: {$place->name}");
            $placesCreated++;
        }

        $this->command->info("Total sacred places created: {$placesCreated}");
    }

    /**
     * Create tags for sacred places
     */
    private function createTags(): array
    {
        $tags = [
            ['name' => 'Temple', 'description' => 'A structure reserved for religious or spiritual rituals'],
            ['name' => 'Natural', 'description' => 'Sacred places formed by nature'],
            ['name' => 'Historical', 'description' => 'Places with significant historical importance'],
            ['name' => 'Mountain', 'description' => 'Sacred mountains and peaks'],
            ['name' => 'Ancient', 'description' => 'Places dating back to ancient times'],
            ['name' => 'Pilgrimage', 'description' => 'Sites visited by pilgrims for religious reasons'],
            ['name' => 'Meditation', 'description' => 'Places conducive to meditation and spiritual reflection'],
            ['name' => 'Healing', 'description' => 'Sites believed to have healing properties'],
            ['name' => 'Ceremonial', 'description' => 'Places used for religious ceremonies and rituals'],
            ['name' => 'Astronomical', 'description' => 'Sites with astronomical significance'],
        ];

        $tagIds = [];
        foreach ($tags as $index => $tagData) {
            $tag = Tag::firstOrCreate(
                ['name' => $tagData['name']],
                ['description' => $tagData['description']]
            );
            $tagIds[$index + 1] = $tag->id;
            $this->command->info("Created tag: {$tag->name}");
        }

        return $tagIds;
    }

    /**
     * Download an image from a URL and add it to a sacred place using Spatie Media Library
     */
    private function downloadAndAddImage(Sacredplace $place, string $imageUrl): void
    {
        try {
            // Generate a temporary file path
            $tempFile = tempnam(sys_get_temp_dir(), 'sacred_place_');

            // Download the image
            $response = Http::get($imageUrl);
            if ($response->successful()) {
                // Save the image to the temporary file
                file_put_contents($tempFile, $response->body());

                // Add the image to the sacred place using Spatie Media Library
                $media = $place->addMedia($tempFile)
                    ->usingFileName(basename($imageUrl))
                    ->toMediaCollection('images');

                // Update the image column with the URL from Spatie Media Library
                $place->update(['image' => $media->getUrl()]);

                $this->command->info("Added image for {$place->name}");
            } else {
                $this->command->error("Failed to download image for {$place->name}: {$response->status()}");
            }
        } catch (\Exception $e) {
            $this->command->error("Error adding image for {$place->name}: {$e->getMessage()}");
        } finally {
            // Clean up the temporary file if it exists
            if (isset($tempFile) && file_exists($tempFile)) {
                unlink($tempFile);
            }
        }
    }
}
