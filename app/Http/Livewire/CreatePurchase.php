<?php

namespace App\Http\Livewire;

use App\Abstracts\FormAbstract;
use App\Models\SteamItem;
use App\Models\SteamPurchase;
use App\Traits\SteamItemFormTrait;

class CreatePurchase extends FormAbstract
{
    use SteamItemFormTrait;

    public string $view = 'livewire.create-purchase';

    public array $rules = [
        'fields.steam_item_id' => 'required|exists:steam_items,id',
        'fields.quantity' => 'required|integer',
        'fields.purchase_cost' => 'required|decimal:0,2',
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
        $this->emit('updateModal', [
            'content' => 'create-steam-item',
            'title' => 'Create steam item',
        ]);
    }

    public function submit()
    {
        $this->validate($this->rules);
        SteamPurchase::create($this->fields);

        $this->dispatchBrowserEvent('alert', [
            'success' => true,
            'message' => 'Successfully created item purchase record'
        ]);

        $this->emit('refreshDatatable');
    }

    public function updateSteamItem()
    {
        $this->setImageUrl();
        $this->emitTo(
            'purchase-table',
            'setItem',
            $this->fields['steam_item_id']
        );
    }
}
