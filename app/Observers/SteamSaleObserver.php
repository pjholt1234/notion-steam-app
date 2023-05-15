<?php

namespace App\Observers;

use App\Models\SteamPurchase;
use App\Models\SteamSale;

class SteamSaleObserver
{
    public function saved(SteamSale $steamSale)
    {
        $steamSale->steamItem->stockItem->calculate();
    }

    public function deleted(SteamSale $steamSale)
    {
        $steamSale->steamItem->stockItem->calculate();
    }
}
