<?php

namespace App\Observers;

use App\Models\SteamSale;

class SteamSaleObserver
{
    public function saved(SteamSale $steamSale)
    {
        if($steamSale->isDirty('quantity')){
            $steamSale->steamItem->stockItem->calculateStock();
        }
    }
}
