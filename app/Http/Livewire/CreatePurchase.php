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

    public $purchase;
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
        'steam-item-added' => 'initialise',
        'copyPurchase' => 'setPurchaseFields',
        'setPurchase' => 'setPurchase',
    ];

    public function mount()
    {
        $this->initialise();
    }

    public function setPurchaseFields(?SteamPurchase $purchase)
    {
        $this->fields = [
            'steam_item_id' => $purchase?->steam_item_id,
            'quantity' => $purchase?->quantity,
            'purchase_cost' => $purchase?->purchase_cost,
            'transaction_date' => $purchase?->transaction_date,
        ];

        if(isset($purchase)){
            $this->setImageUrl();
            return;
        }

        $this->initialise();
    }

    public function setPurchase(?SteamPurchase $purchase)
    {
        $this->purchase = $purchase;
        $this->setPurchaseFields($purchase);
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

        $message = 'Successfully created item purchase record';

        if(!isset($this->purchase)){
            SteamPurchase::create($this->fields);
        } else {
            $this->purchase->update($this->fields);
            $message = 'Successfully edited item purchase record';
        }


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
            'purchase-table',
            'setItem',
            $this->fields['steam_item_id']
        );
    }

    public function exitEditMode()
    {
        $this->setPurchase(null);
    }
}
