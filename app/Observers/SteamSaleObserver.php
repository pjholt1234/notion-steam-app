<?php

namespace App\Observers;

use App\Models\SteamPurchase;
use App\Models\SteamSale;

class SteamSaleObserver
{
    public function saved(SteamSale $steamSale)
    {
        if($steamSale->isDirty('quantity')){
            $steamSale->steamItem->stockItem->calculateStock();
        }

        $steamSale->steamItem->stockItem->calculateNetValue();
    }

    public function deleted(SteamSale $steamSale)
    {
        $stockItem = $steamSale->steamItem->stockItem;
        $stockItem->calculateStock();
        $stockItem->calculateCost();
        $stockItem->calculateNetValue();
    }
}
