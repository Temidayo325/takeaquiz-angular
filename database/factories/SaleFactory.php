<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => random_int(1, 100),
            'event_id' => random_int(1, 50),
            'ticket_id' => random_int(1, 50),
            'amount_paid' => random_int(1000, 3000),
            'status' => 'Success'
        ];
    }
}
