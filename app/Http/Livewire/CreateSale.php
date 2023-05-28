<?php

namespace App\Http\Livewire;

use App\Abstracts\FormAbstract;
use App\Models\SteamSale;
use App\Traits\SteamItemFormTrait;

class CreateSale extends FormAbstract
{
    use SteamItemFormTrait;

    public string $view = 'livewire.create-sale';

    public $sale;

    public array $rules = [
        'fields.steam_item_id' => 'required|exists:steam_items,id',
        'fields.quantity' => 'required|integer',
        'fields.sale_value' => 'required|decimal:0,2',
        'fields.transaction_date' => 'nullable|before:tomorrow'
    ];

    public array $fields = [
        'steam_item_id' => null,
        'quantity' => null,
        'sale_value' => null,
        'transaction_date' => null,
    ];

    protected $listeners = [
        'steam-item-added' => 'initialise',
        'copySale' => 'setSaleFields',
        'setSale' => 'setSale',
    ];

    public function mount()
    {
        $this->initialise();
    }

    public function openSearch()
    {
        $this->emit('updateModal', [
            'content' => 'create-steam-item',
            'title' => 'Create steam item',
        ]);
    }

    public function setSaleFields(?SteamSale $sale)
    {
        $this->fields = [
            'steam_item_id' => $sale?->steam_item_id,
            'quantity' => $sale?->quantity,
            'sale_value' => $sale?->sale_value,
            'transaction_date' => $sale?->transaction_date,
        ];

        if(isset($sale)){
            $this->setImageUrl();
            return;
        }

        $this->initialise();
    }

    public function setSale(?SteamSale $sale)
    {
        $this->sale = $sale;
        $this->setSaleFields($sale);
    }

    public function submit()
    {
        $this->validate($this->rules);
        $message = 'Successfully created item sale record';

        if(!isset($this->sale)){
            SteamSale::create($this->fields);
        } else {
            $this->sale->update($this->fields);
            $message = 'Successfully edited item sale record';
        }

        $this->exitEditMode();


        $this->dispatchBrowserEvent('alert', [
            'success' => true,
            'message' => $message
        ]);

        $this->emit('refreshDatatable');
    }

    public function updateSteamItem()
    {
        $this->setImageUrl();
        $this->emitTo(
            'sale-table',
            'setItem',
            $this->fields['steam_item_id']
        );
    }

    public function exitEditMode()
    {
        $this->setSale(null);
    }
}
