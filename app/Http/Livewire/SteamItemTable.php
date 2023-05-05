<?php

namespace App\Http\Livewire;

use App\Abstracts\TableAbstract;
use App\Helpers\Column;
use App\Models\SteamItem;
use Illuminate\Database\Eloquent\Builder;

class SteamItemTable extends TableAbstract
{
    public function builder(): Builder
    {
        return SteamItem::query();
    }

    public function columns(): array
    {
        return [
            Column::create('Name', 'name')
                ->format(function($value, $row){
                    $url = 'https://steamcommunity.com/market/listings/730/'.$row->market_hash_name;
                    return '<a href="'.$url.'">'.$value.'</a>';
                })
                ->sortable()
                ->html(),
            Column::create('Price per unit', 'current_price_per_unit')
                ->format(function($value){
                    if(isset($value)) {
                        return '£'.$value;
                    }

                    return $value;
                }),
        ];
    }
}
