<?php

namespace App\Abstracts;

use App\Models\SteamItem;
use App\Services\ItemPriceUpdateService;
use Carbon\Carbon;
use Error;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Symfony\Component\RateLimiter\LimiterInterface;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\RateLimiter\Storage\InMemoryStorage;

abstract class AbstractLivewireDataRequest extends Component
{
    public int $progress = 0;

    public int $index = 0;

    public int $increment;

    public string $view;

    public string $statusMessage;

    public string $initialMessage;

    protected $listeners = [
        'request' => 'request'
    ];

    abstract public function dataProcessing(): void;

    public function request()
    {
        if($this->index == 0 && isset($this->initialMessage)){
            $this->emit('updateProgress', $this->initialMessage, 0);
        }

        try {
            $this->dataProcessing();
        } catch (\Exception $exception){
            report($exception);

            $this->resetProgress();

            $this->dispatchBrowserEvent('alert', [
                'success' => false,
                'message' => 'Sorry an error has occurred please try again later.'
            ]);

            return;
        }

        $this->progress = $this->increment + $this->progress;

        $message = $this->statusMessage.' #'.$this->index+1;

        $this->emit('updateProgress', $message, $this->progress);

        $this->index++;

        if($this->index >= count($this->items)){
            $this->dispatchBrowserEvent('alert', [
                'success' => true,
                'message' => 'Item price data fetching complete'
            ]);

            $this->resetProgress();

            return;
        }

        $this->emitSelf('request', $this->index);
    }

    public function resetProgress()
    {
        $this->emit('setProgressBarState', false);
        $this->index = 0;
        $this->progress = 0;
    }

    public function render()
    {
        return view($this->view);
    }
}
