<?php

namespace App\Http\Livewire;

// RequestData.php

use App\Helpers\SteamItemUpdater;
use App\Interfaces\ProgressCallbackInterface;
use App\Models\SteamItem;
use App\Repositories\CurrencyConversionApiRepository;
use App\Repositories\SteamMarketApiRepository;
use App\Services\ItemPriceUpdateService;
use Livewire\Component;

class RequestData extends Component
{
    public string $message = '';

    public $progress = 0;

    private $itemPriceService;

    public $currentIndex = 0;

    public array $items = [];
    public $increment;

    public bool $active = false;

    protected $listeners = [
        'request' => 'request'
    ];

    public function render()
    {
        return view('livewire.request-data');
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
        $this->active = true;
        $this->message = 'Fetching data for item #'.$index+1;

        $item = SteamItem::find($this->items[$this->currentIndex]);

        $this->itemPriceService->updatePrice($item);

        $this->progress += $this->increment;

        $this->currentIndex++;

        if($this->currentIndex >= count($this->items)){
            $this->dispatchBrowserEvent('alert', [
                'success' => true,
                'message' => 'Item price data fetching complete'
            ]);

            $this->currentIndex = 0;
            $this->progress = 0;

            $this->active = false;

            return;
        }

        $this->emitSelf('request', $this->currentIndex);
    }
}

