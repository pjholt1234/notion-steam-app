<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SteamSaleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'quantity' => $this->faker->numberBetween(0,10),
            'sale_value' => $this->faker->numberBetween(1,10),
            'transaction_date' => now(),
        ];
    }
}
