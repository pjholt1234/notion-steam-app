<?php

namespace App\Observers;

use App\Models\SteamPurchase;

class SteamPurchaseObserver
{
    public function saved(SteamPurchase $steamPurchase)
    {
        $steamPurchase->steamItem->stockItem->calculate();
    }

    public function deleted(SteamPurchase $steamPurchase)
    {
        $steamPurchase->steamItem->stockItem->calculate();
    }
}
