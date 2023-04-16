<?php

namespace App\Http\Controllers;

use App\Models\SteamItem;
use App\Models\StockItem;
use Illuminate\Http\Request;

class SteamItemController extends Controller
{
    public function index()
    {
        $items = StockItem::all()->map(function($item){
            return [
                'name' => $item->steamItem->name,
                'quantity' => $item->quantity,
                'total_cost' => $item->total_cost,
                'net_value' => $item->net_value,
            ];
        });
        return view('steam-item.index', [
            'items' => $items,
        ]);
    }

    public function create()
    {

    }
}
