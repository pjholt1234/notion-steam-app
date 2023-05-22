<?php

namespace App\Http\Livewire;

use App\Abstracts\FormAbstract;
use App\Models\SteamPurchase;
use App\Models\SteamSale;
use App\Traits\SteamItemFormTrait;

class CreateSale extends FormAbstract
{
    use SteamItemFormTrait;

    public string $view = 'livewire.create-sale';

    public array $rules = [
        'fields.steam_item_id' => 'required|exists:steam_items,id',
        'fields.quantity' => 'required|integer',
        'fields.sale_value' => 'required|decimal:0,2',
        'fields.transaction_date' => 'nullable|before:tomorrow'
    ];

    public array $fields = [
        'steam_item_id' => null,
        'quantity' => null,
        'purchase_cost' => null,
        'transaction_date' => null,
    ];

    protected $listeners = [
        'steam-item-added' => 'reInitialise'
    ];

    public function mount()
    {
        $this->initialise();
    }

    public function reInitialise(){
        $this->initialise();
    }

    public function openSearch()
    {
        $this->dispatchBrowserEvent('add-item-modal-toggle');
    }

    public function submit()
    {
        $this->validate($this->rules);
        SteamSale::create($this->fields);

        $this->dispatchBrowserEvent('alert', [
            'success' => true,
            'message' => 'Successfully created item sale record'
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
}
