<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'price' => $this->faker->numberBetween(1,99999),
            'currency_id' => Currency::query()->inRandomOrder()->first(),
        ];
    }
}
