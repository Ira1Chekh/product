<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    protected const CURRENCIES = [
        'USD',
        'UAH'
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::CURRENCIES as $item) {
            Currency::query()->firstOrCreate([
                'name' => $item,
            ]);
        }
    }
}
