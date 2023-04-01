<?php

namespace App\Observers;

use App\Models\SteamPurchase;
use App\Models\StockItem;
use Illuminate\Database\Eloquent\Collection;

class SteamPurchaseObserver
{
    public function saved(SteamPurchase $steamPurchase)
    {
        if($steamPurchase->isDirty('quantity')){
            $steamPurchase->steamItem->stockItem->calculateStock();
        }

        if($steamPurchase->isDirty('purchase_cost')){
            $steamPurchase->steamItem->stockItem->calculateCost();
        }
    }
}
