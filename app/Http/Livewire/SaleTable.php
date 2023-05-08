<?php

namespace App\Http\Livewire;

use App\Abstracts\TableAbstract;
use App\Helpers\Column;
use App\Models\SteamItem;
use App\Models\SteamSale;
use App\Models\StockItem;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class SaleTable extends TableAbstract
{
    public ?int $itemId = null;

    protected $listeners = [
        'setItem' => 'setItem',
        'refreshDatatable' => '$refresh',
    ];

    public function builder(): Builder
    {
        if(!isset($this->itemId)){
            return SteamSale::query();
        }

        return SteamSale::where('steam_item_id', $this->itemId);
    }

    public function columns(): array
    {
        return [
            Column::create('Name', 'id')
                ->format(function($value, $row){
                    $url = 'https://steamcommunity.com/market/listings/730/'.$row->steamItem->market_hash_name;
                    return '<a href="'.$url.'">'.$row->steamItem->name.'</a>';
                })
                ->html(),
            Column::create('Quantity', 'quantity'),
            Column::create('Sale value', 'sale_value')
                ->format(fn($value) => formatMoneyCell($value)),
            Column::create('Transaction date', 'transaction_date'),
            Column::create('Actions', 'id')
                ->format(fn($value) => $this->createActionButtons($value))
                ->html(),
        ];
    }

    public function setItem(int $itemId): void
    {
        $this->itemId = $itemId;
    }

    public function delete($id)
    {
        $sale = SteamSale::find($id);
        $sale->delete();

        $this->dispatchBrowserEvent('alert', [
            'success' => true,
            'message' => 'Sale successfully deleted'
        ]);
    }

    public function copy($id)
    {
        $sale = SteamSale::find($id);
        $newSale = $sale->replicate();
        $newSale->created_at = Carbon::now();
        $newSale->save();

        $this->dispatchBrowserEvent('alert', [
            'success' => true,
            'message' => 'Sale successfully duplicated'
        ]);
    }

    public function createActionButtons($id): string
    {
        return '<div class="flex">
                    <x-button class="rounded p-1 text-sm border border-red-500 hover:bg-red-500 hover:text-white mr-1" wire:click="delete('.$id.')">
                        <i class="fa-solid fa-trash-can"></i>
                    </x-button>
                    <x-button class="rounded p-1 text-sm border border-green-500 hover:bg-green-500 hover:text-white" wire:click="copy('.$id.')">
                        <i class="fa-solid fa-copy"></i>
                    </x-button>
                </div>';

    }
}
