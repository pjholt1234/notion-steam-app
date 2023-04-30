<?php

namespace App\Http\Livewire;

use App\Models\SteamItem;
use App\Models\SteamPurchase;
use Carbon\Carbon;
use Livewire\Component;

class CreatePurchase extends Component
{
    public $steamItems;

    public $itemId;

    public ?string $itemImageUrl = null;

    public $rules = [
        'fields.steam_item_id' => 'required|exists:steam_items,id',
        'fields.quantity' => 'required|integer',
        'fields.purchase_cost' => 'required|decimal:0,2',
        'fields.transaction_date' => 'nullable|before:tomorrow'
    ];
    
    public $fields = [
        'steam_item_id' => null,
        'quantity' => null,
        'purchase_cost' => null,
        'transaction_date' => null,
    ];

    public function mount()
    {
        $this->steamItems = SteamItem::select('id', 'name')->get();
        $this->fields['steam_item_id'] = $this->steamItems->first()->id;
        $this->setImageUrl();
    }

    public function render()
    {
        return view('livewire.create-purchase');
    }

    public function setImageUrl()
    {
        $item = SteamItem::find($this->fields['steam_item_id']);
        $this->itemImageUrl = $item->getImageUrl();
    }

    public function submit()
    {
        $this->validate($this->rules);
        SteamPurchase::create($this->fields);

        $this->dispatchBrowserEvent('alert', [
            'success' => true,
            'message' => 'Successfully created item purchase record'
        ]);
    }
}
