<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Sale::factory()
        				->count(200)
        				->sequence(
        					['status' => 'Pending'],
        					['status' => 'Failed'],
        					['status' => 'Success']
        				)
        				->create();
    }
}
