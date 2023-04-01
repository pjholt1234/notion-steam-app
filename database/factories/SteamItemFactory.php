<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SteamItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'market_hash_name' => 'AK-47 | Redline (Field-Tested)',
            'current_price_per_unit' => 0.50,
        ];
    }
}
