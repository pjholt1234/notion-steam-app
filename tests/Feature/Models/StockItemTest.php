<?php

use App\Models\SteamItem;
use App\Models\SteamPurchase;
use App\Models\SteamSale;
use App\Models\StockItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->validMarketNames = [
        'Glove case',
    ];
});

test('test automatic generation based on steam item', function () {
    $steamItem = SteamItem::factory()->create([
        'market_hash_name' => $this->validMarketNames[0]
    ]);

    $this->assertNotNull($steamItem->stockItem);
});

test('test sales relationship', function () {
    $steamItem = SteamItem::factory()->create([
        'market_hash_name' => $this->validMarketNames[0]
    ]);

    $stockItem = $steamItem->stockItem;

    $steamSale = SteamSale::factory()->for($steamItem)->create();

    $this->assertEquals($stockItem->steamSales->first()->id, $steamSale->id);
});

test('test purchase relationship', function () {
    $steamItem = SteamItem::factory()->create([
        'market_hash_name' => $this->validMarketNames[0]
    ]);

    $stockItem = $steamItem->stockItem;

    $steamPurchase = SteamPurchase::factory()->for($steamItem)->create();

    $this->assertEquals($stockItem->steamPurchases->first()->id, $steamPurchase->id);
});

test('test automatic stock calculation', function () {
    $steamItem = SteamItem::factory()->create([
        'market_hash_name' => $this->validMarketNames[0]
    ]);

    $stockItem = $steamItem->stockItem;
    $this->assertNotNull($stockItem);
    $this->assertEquals(0, $stockItem->quantity);

    $numberOfPurchases = $this->faker->numberBetween(5,10);
    $purchaseQuantityTotal = 0;

    for($x = 0; $x < $numberOfPurchases; $x++){
        $quantity = $this->faker->numberBetween(5,10);

        SteamPurchase::factory()
            ->for($steamItem)
            ->create([
                'quantity' => $quantity
            ]);

        $purchaseQuantityTotal = $purchaseQuantityTotal + $quantity;
    }


    $numberOfSales = $this->faker->numberBetween(1,4);
    $saleQuantityTotal = 0;

    for($x = 0; $x < $numberOfSales; $x++){
        $quantity = $this->faker->numberBetween(1,4);

        SteamSale::factory()->for($steamItem)->create([
            'quantity' => $quantity
        ]);

        $saleQuantityTotal = $saleQuantityTotal + $quantity;
    }

    $stockItem->refresh();
    $this->assertEquals($numberOfPurchases, $stockItem->steamPurchases->count());
    $this->assertEquals($numberOfSales, $stockItem->steamSales->count());

    $predictedStock = $purchaseQuantityTotal - $saleQuantityTotal;

    $this->assertEquals($predictedStock, $stockItem->quantity);
});

test('test automatic cost calculation', function () {
    $steamItem = SteamItem::factory()->create([
        'market_hash_name' => $this->validMarketNames[0]
    ]);

    $stockItem = $steamItem->stockItem;
    $this->assertNotNull($stockItem);
    $this->assertEquals(0, $stockItem->total_cost);

    $numberOfPurchases = $this->faker->numberBetween(5,10);
    $purchaseCostTotal = 0;

    for($x = 0; $x < $numberOfPurchases; $x++){
        $cost = $this->faker->numberBetween(1,10);

        SteamPurchase::factory()
            ->for($steamItem)
            ->create([
                'purchase_cost' => $cost
            ]);

        $purchaseCostTotal = $purchaseCostTotal + $cost;
    }


    $stockItem->refresh();
    $this->assertEquals($numberOfPurchases, $stockItem->steamPurchases->count());
    $this->assertEquals($purchaseCostTotal, $stockItem->total_cost);
});
