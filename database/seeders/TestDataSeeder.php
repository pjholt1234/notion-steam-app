<?php

namespace Database\Seeders;

use App\Models\SteamItem;
use App\Models\SteamPurchase;
use App\Models\SteamSale;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;
class TestDataSeeder extends Seeder
{
    protected $faker;
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }

    public function run(): void
    {
        $validSteamItems = [
            [
                'name' => 'Glove Case',
                'hash' => 'Glove%20Case',
            ],
            [
                'name' => 'CS20 Case',
                'hash' => 'CS20%20Case',
            ],
            [
                'name' => 'Clutch Case',
                'hash' => 'Clutch%20Case',
            ],
            [
                'name' => 'Antwerp 2020 Challengers Sticker Capsule',
                'hash' => 'Antwerp%202022%20Challengers%20Sticker%20Capsule',
            ],
            [
                'name' => 'Antwerp 2020 Legends Autograph Sticker Capsule',
                'hash' => 'Antwerp%202022%20Legends%20Autograph%20Capsule',
            ],
            [
                'name' => 'Antwerp 2020 Legends Sticker Capsule',
                'hash' => 'Antwerp%202022%20Legends%20Sticker%20Capsule',
            ],
            [
                'name' => 'Broken Fang Case',
                'hash' => 'Operation%20Broken%20Fang%20Case',
            ],
            [
                'name' => 'Battlescar Holo Sticker',
                'hash' => 'Sticker%20%7C%20Battle%20Scarred%20%28Holo%29',
            ],
        ];


        foreach($validSteamItems as $validSteamItem){
            $steamItem = SteamItem::factory()->create([
                'name'              => $validSteamItem['name'],
                'market_hash_name'  => $validSteamItem['hash'],
            ]);

            SteamPurchase::factory()
                ->for($steamItem)
                ->create([
                    'quantity' => $this->faker->numberBetween(51,100),
                ]);

            SteamSale::factory()
                ->for($steamItem)
                ->create([
                    'quantity' => $this->faker->numberBetween(1,50),
                ]);
        }
    }
}
