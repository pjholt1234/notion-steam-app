<?php

namespace App\Http\Livewire;

// RequestData.php
use App\Models\SteamItem;
use App\Services\ItemPriceUpdateService;
use Livewire\Component;

class RequestSteamItemDataButton extends Component
{
    private $itemPriceService;

    public int $progress = 0;

    public $currentIndex = 0;

    public array $items = [];
    public $increment;


    protected $listeners = [
        'request' => 'request'
    ];

    public function render()
    {
        return view('livewire.request-steam-item-data-button');
    }


    public function booted()
    {
        $this->itemPriceService = app(ItemPriceUpdateService::class);
    }

    public function mount()
    {
        $this->items = SteamItem::all()->pluck('id')->toArray();
        $this->currentIndex = 0;
        $this->increment = 100 / count($this->items);
    }


    public function request($index)
    {
        $item = SteamItem::find($this->items[$this->currentIndex]);

        $this->itemPriceService->updatePrice($item);
        $this->progress = $this->increment + $this->progress;

        $message = 'Fetching data for item #'.$index+1;

        $this->emit('updateProgress', $message, $this->progress);

        $this->currentIndex++;

        if($this->currentIndex >= count($this->items)){
            $this->dispatchBrowserEvent('alert', [
                'success' => true,
                'message' => 'Item price data fetching complete'
            ]);

            $this->emit('setProgressBarState', false);
            $this->currentIndex = 0;
            $this->progress = 0;
            return;
        }

        $this->emitSelf('request', $this->currentIndex);
    }
}

