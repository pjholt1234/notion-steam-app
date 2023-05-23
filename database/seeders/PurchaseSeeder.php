<?php

namespace Database\Seeders;

use App\Models\SteamItem;
use App\Models\SteamPurchase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'market_hash_name' => 'Glove%20Case',
                'name' => 'Glove Case',
                'purchases' => [
                    [
                        'quantity' => 117,
                        'purchase_cost' => 65.84,
                    ]
                ]
            ],
            [
                'market_hash_name' => 'CS20%20Case',
                'name' => 'CS20 Case',
                'purchases' => [
                    [
                        'quantity' => 200,
                        'purchase_cost' => 20,
                    ]
                ]
            ],
            [
                'market_hash_name' => 'Antwerp%202022%20Challengers%20Sticker%20Capsule',
                'name' => 'Antwerp Challengers Capsule',
                'purchases' => [
                    [
                        'quantity' => 40,
                        'purchase_cost' => 10,
                    ]
                ]
            ],
            [
                'market_hash_name' => 'Antwerp%202022%20Legends%20Autograph%20Capsule',
                'name' => 'Antwerp Legends Autograph Capsule',
                'purchases' => [
                    [
                        'quantity' => 20,
                        'purchase_cost' => 4,
                    ]
                ]
            ],
            [
                'market_hash_name' => 'Antwerp%202022%20Legends%20Sticker%20Capsule',
                'name' => 'Antwerp Legends Capsule',
                'purchases' => [
                    [
                        'quantity' => 100,
                        'purchase_cost' => 20,
                    ]
                ]
            ],
            [
                'market_hash_name' => 'Operation%20Broken%20Fang%20Case',
                'name' => 'Broken Fang Case',
                'purchases' => [
                    [
                        'quantity' => 25,
                        'purchase_cost' => 1,
                    ]
                ]
            ],
            [
                'market_hash_name' => 'Clutch%20Case',
                'name' => 'Clutch Case',
                'purchases' => [
                    [
                        'quantity' => 205,
                        'purchase_cost' => 58,
                    ],
                    [
                        'quantity' => 100,
                        'purchase_cost' => 54,
                    ]
                ]
            ],
            [
                'market_hash_name' => '2020%20RMR%20Legends',
                'name' => 'RMR legends Capsule',
                'purchases' => [
                    [
                        'quantity' => 330,
                        'purchase_cost' => 76.50,
                    ]
                ]
            ],
            [
                'market_hash_name' => 'Sticker%20%7C%20Battle%20Scarred%20%28Holo%29',
                'name' => 'BattleScar Holo',
                'purchases' => [
                    [
                        'quantity' => 10,
                        'purchase_cost' => 35.40,
                    ]
                ]
            ],
        ];

        foreach($items as $item) {
            $steamItem = SteamItem::create([
                'market_hash_name' => $item['market_hash_name'],
                'name' => $item['name'],
            ]);

            foreach($item['purchases'] as $purchase){
                SteamPurchase::create([
                    'quantity' => $purchase['quantity'],
                    'purchase_cost' => $purchase['purchase_cost'],
                    'steam_item_id' => $steamItem->id
                ]);
            }

            $steamItem->stockItem->calculate();
        }
    }
}
