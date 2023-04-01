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
    }
}
