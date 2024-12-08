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
        				->count(10)
        				->sequence(
        					['name' => 'Have you ever'],
        					['name' => 'Truth or Dare'],
                            ['name' => 'Never Have I Ever'],
                            ['name' => 'Dance Battle'],
                            ['name' => 'Whisper Challenge'],
                            ['name' => 'Flip Cup Relay'],
                            ['name' => 'Scavenger Hunt'],
                            ['name' => 'Heads Up'],
                            ['name' => 'Karaoke Roulette'],
        					['name' => 'Charades: Vibes Edition'],
        					
        				)
        				->create()
                        ->each(function ($game){
                            $tags = ['Chill', 'Vibe', 'group', 'high-strung', 'no-stress', 'dangerous', 'sexual', 'non-sexual', 'playful', 'running', 'football'];
                            $final_tags = [];
                            for ($i=0; $i < 4; $i++) { 
                                # code...
                                $random_int = random_int(0, 4);
                                array_push($final_tags, $tags[$random_int]);
                            }
                            $game->tags = json_encode($final_tags);
                            $game->save();
                        });
    }
}
