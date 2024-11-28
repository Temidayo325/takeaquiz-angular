<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Game::factory()
        				->count(30)
        				->sequence(
        					['name' => 'Spin the bottle'],
        					['name' => 'Have you ever'],
        					['name' => 'Truth or Dare'],
        					['name' => '2 truths and a lie'],
        					
        				)
        				->create()
                        ->each(function ($game){
                            $tags = ['sexual', 'non-sexual', 'group', 'high-strung', 'no-stress', 'dangerous'];
                            $final_tags = [];
                            for ($i=0; $i < 3; $i++) { 
                                # code...
                                $random_int = random_int(0, 4);
                                array_push($final_tags, $tags[$random_int]);
                            }
                            $game->attachTags($final_tags);
                        });;
    }
}
