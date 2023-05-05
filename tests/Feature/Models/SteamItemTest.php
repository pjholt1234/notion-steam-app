<?php

use App\Models\SteamItem;
use App\Models\SteamPurchase;
use App\Models\SteamSale;
use App\Models\StockItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function() {
    $this->validMarketNames = [
        'Glove case',
    ];
});

test('test sales relationship', function () {
    $steamItem = SteamItem::factory()->create([
        'market_hash_name' => $this->validMarketNames[0]
    ]);

    $steamSale = SteamSale::factory()->for($steamItem)->create();
    $steamItem->refresh();


    $this->assertEquals($steamSale->id, $steamItem->steamSales->first()->id);
});

test('test purchase relationship', function () {
    $steamItem = SteamItem::factory()->create([
        'market_hash_name' => $this->validMarketNames[0]
    ]);

    $steamPurchase = SteamPurchase::factory()->for($steamItem)->create();
    $steamItem->refresh();


    $this->assertEquals($steamPurchase->id, $steamItem->steamPurchases->first()->id);
});

test('test stock item generation and relationship', function () {
    $steamItem = SteamItem::factory()->create([
        'market_hash_name' => $this->validMarketNames[0]
    ]);

    $steamItem->refresh();

    $this->assertNotNull($steamItem->stockItem);
});
