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
        					['state' => 'Kwara'],
        					['state' => 'Abuja'],
        					['isPremium' => false],
                            ['tags' => 'Sexual', 'mature', 'milf', 'orgy'],
                            ['tags' => 'Non-sexual, party, blockparty'],
        					['tags' => 'retro, fun, dressup, chill'],
        				)
        				->create()
        				->each(function ($event){
        					// Attach an Hastag to the event
        					$hashtags = ['Dinner', 'Rave', 'House party', 'Pool party', 'Meet and Greet', 'Chill and vibes'];
        					$hashtag = $hashtags[random_int(0, 5)];
        					$event->attachTag($hashtag);
        				});
    }
}
