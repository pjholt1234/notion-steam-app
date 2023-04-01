<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SteamItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'current_price_per_unit' => $this->faker->numberBetween(1,10),
        ];
    }
}
