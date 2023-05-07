<?php

namespace App\Traits;

use App\Models\SteamItem;

trait SteamItemFormTrait
{
    public $steamItems;
    public $setItem;

    public ?string $itemImageUrl = null;

    public function initialise()
    {
        if(!array_key_exists('steam_item_id', $this->fields)){
            throw new \Error('Missing steam_item_id key');
        }

        $this->steamItems = SteamItem::select('id', 'name')->get();
        $this->fields['steam_item_id'] = $this->steamItems->first()->id;

        $this->setImageUrl();
    }

    public function setImageUrl(): void
    {
        $this->setItem = SteamItem::find($this->fields['steam_item_id']);
        $this->itemImageUrl = $this->setItem->getImageUrl();
    }
}
