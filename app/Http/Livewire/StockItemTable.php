<?php

namespace App\Http\Livewire;

use App\Abstracts\TableAbstract;
use App\Helpers\Column;
use App\Models\SteamItem;
use App\Models\StockItem;
use Illuminate\Database\Eloquent\Builder;

class StockItemTable extends TableAbstract
{
    public function builder(): Builder
    {
        return StockItem::query();
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
            Column::create('Total cost', 'total_cost')
                ->format(fn($value) => formatMoneyCell($value)),
            Column::create('Net value', 'net_value')
                ->format(fn($value) => formatMoneyCell($value)),
            Column::create('Profit', 'id')
                ->format(fn($value, $row) => $this->profitCell($row->total_cost, $row->net_value))
                ->html(),
        ];
    }

    public function profitCell($cost, $value): string
    {
        $profit = $value - $cost;
        $class = '!text-green-500';

        if($profit < 0){
            $class = '!text-red-500';
        }

        return '<span class=" '.$class.' ">£'.$profit.'</span>';
    }
}
