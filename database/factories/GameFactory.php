<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Spin the bottle', 
            'summary' => fake()->paragraph(4), 
            'stepByStep' => fake()->paragraph(3), 
            'minimum_player' => random_int(1, 6), 
            'maximum_player' => random_int(6, 20),
            'tags' => 'retro, non-sexual, chill',
            'image' => '/images/games/talk.jpg',
            'video' => '/videos/games/talk.jpg'
        ];
    }
}
