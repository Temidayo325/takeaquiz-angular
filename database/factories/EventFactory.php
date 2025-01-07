<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'House party',
            'user_id' => random_int(1, 50),
            'event_date' => fake()->dateTimeBetween('now', '+2 months'),
            'starting_time' => fake()->time(), 
            'location' => fake()->address(),
            'flier' => '/fliers/gelgas.jpg',
            'tags' => 'Ish, Consesual, Multiple, Fun, Dressparty',
            'state' => 'Lagos',
            'status' => 'Draft',
            'coordinate' => fake()->longitude($min = -180, $max = 180) . " : " .fake()->latitude($min = -90, $max = 90),
            'promotional_copy' => fake()->paragraph(),
            'isPremium' => false,
            'duration' => '2 hours',
            'audience' => 'adults',
            'dress_code' => 'all white party',
            'contact_information' => '+23490898978'
        ];
    }
}
