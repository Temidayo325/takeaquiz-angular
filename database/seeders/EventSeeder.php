<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Event::factory()
        				->count(200)
        				->sequence(
        					['name' => 'Dynamic alchemist'],
        					['name' => 'Track unveiling and listening'],
        					['name' => 'Netflix and chill with some awesomeness'],
        					['name' => 'Buju Phenomena gathering'],
                            ['state' => 'Lagos'],
                            ['status' => 'Draft'],
        					['status' => 'Published'],
        					['state' => 'Kwara'],
        					['state' => 'Abuja'],
        					['isPremium' => false],
                            ['tags' => json_encode(['Sexual', 'mature', 'milf', 'orgy'])],
                            ['tags' => json_encode(['Non-sexual', 'party', 'blockparty'])],
        					['tags' => 'retro, fun, dressup, chill'],
        				)
        				->create();
    }
}
