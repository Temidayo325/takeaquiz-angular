<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Services\Paystack;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cursor = null;

        do {
            $data = Paystack::GetBanks($cursor);
            $banks = collect($data->data)->map(function ($bank) {
                return [
                    'name' => $bank->name ?? null,
                    'slug' => $bank->slug ?? null,
                    'code' => $bank->code ?? null,
                ];
            })
            ->filter(fn ($bank) => $bank['name'] && $bank['slug'] && $bank['code'])
            ->unique('name')
            ->reject(function ($bank) {
                return DB::table('banks')->where('name', $bank['name'])->exists();
            })
            ->toArray();

            // Insert into database
            DB::table('banks')->insert($banks);
            $cursor = $data->meta->next;

        } while ($cursor != null); // Keep requesting if full results returned
    }
}
