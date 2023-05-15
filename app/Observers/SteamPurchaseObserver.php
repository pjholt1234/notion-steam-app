<?php

namespace App\Observers;

use App\Models\SteamPurchase;

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

        $steamPurchase->steamItem->stockItem->calculateNetValue();
    }

    public function deleted(SteamPurchase $steamPurchase)
    {
        $stockItem = $steamPurchase->steamItem->stockItem;
        $stockItem->calculateStock();
        $stockItem->calculateCost();
        $stockItem->calculateNetValue();
    }
}
