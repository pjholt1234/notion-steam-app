<?php

namespace App\Observers;

use App\Models\SteamItem;

class SteamItemObserver
{
    public function saved(SteamItem $steamItem)
    {
        //Update stock item net value
        if($steamItem->isDirty('current_price_per_unit')){
            $stockItem = $steamItem->stockItem;
            $stockItem->net_value = round($stockItem->quantity * $steamItem->current_price_per_unit, 2);
            $stockItem->save();
        }
    }

    public function created(SteamItem $steamItem)
    {
        //Create new stock item
        $steamItem->stockItem()->create();
    }
}
