<?php

namespace App\Http\Livewire;

// RequestData.php
use App\Abstracts\AbstractLivewireDataRequest;
use App\Models\SteamItem;
use App\Services\ItemPriceUpdateService;

class RequestSteamItemData extends AbstractLivewireDataRequest
{
    private ItemPriceUpdateService $itemPriceService;

    public array $items = [];

    public string $view = 'livewire.request-steam-item-data';

    public string $statusMessage = 'Fetching data for item';

    public string $initialMessage = 'Started pushing to notion...';

    public function booted()
    {
        $this->itemPriceService = app(ItemPriceUpdateService::class);
    }

    public function mount()
    {
        $this->items = SteamItem::all()->pluck('id')->toArray();
        $this->increment = 100 / count($this->items);
    }

    public function dataProcessing(): void
    {
        $item = SteamItem::find($this->items[$this->index]);
        $this->itemPriceService->updatePrice($item);
    }
}

