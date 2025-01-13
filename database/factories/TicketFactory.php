<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => random_int(1, 100),
            'price' => random_int(1000, 10000),
            'total_seat' => random_int(10, 100),
            'available_seat' => random_int(10, 100),
            'type' => 'Early bird',
            'type_copy' => fake()->paragraph(),
            'name' => 'Diamond',
            'access_type' => 'Purchase'
        ];
    }
}
