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

test('test steam item relationship', function () {
    $steamItem = SteamItem::factory()->create([
        'market_hash_name' => $this->validMarketNames[0]
    ]);

    $steamPurchase = SteamPurchase::factory()->for($steamItem)->create();

    $this->assertEquals($steamItem->id, $steamPurchase->steamItem->id);
});

test('test stock item relationship', function () {
    $steamItem = SteamItem::factory()->create([
        'market_hash_name' => $this->validMarketNames[0]
    ]);

    $stockItem = $steamItem->stockItem;

    $steamPurchase = SteamPurchase::factory()->for($steamItem)->create();

    $this->assertEquals($stockItem->id, $steamPurchase->stockItem->id);
});
