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

    $steamSale = SteamSale::factory()->for($steamItem)->create();

    $this->assertEquals($steamItem->id, $steamSale->steamItem->id);
});

test('test stock item relationship', function () {
    $steamItem = SteamItem::factory()->create([
        'market_hash_name' => $this->validMarketNames[0]
    ]);

    $stockItem = $steamItem->stockItem;

    $steamSale = SteamSale::factory()->for($steamItem)->create();

    $this->assertEquals($stockItem->id, $steamSale->stockItem->id);
});
