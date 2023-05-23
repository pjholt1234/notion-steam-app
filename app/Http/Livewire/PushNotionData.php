<?php

namespace App\Http\Livewire;


use App\Abstracts\AbstractLivewireDataRequest;
use App\Models\SteamItem;
use App\Services\UpdateNotionPageService;

class PushNotionData extends AbstractLivewireDataRequest
{
    private UpdateNotionPageService $notionService;

    public string $view = 'livewire.push-notion-data';

    public string $statusMessage = 'Pushing data for item';

    public function booted()
    {
        $this->notionService = app(UpdateNotionPageService::class);
    }

    public function mount()
    {
        $this->items = SteamItem::all()->pluck('id')->toArray();
        $this->increment = 100 / count($this->items);
    }

    public function dataProcessing(): void
    {
        $item = SteamItem::find($this->items[$this->index]);
        $this->notionService->setSteamItem($item);
        $this->notionService->updateTable();
    }
}
