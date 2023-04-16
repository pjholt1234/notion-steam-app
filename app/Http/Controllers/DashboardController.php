<?php

namespace App\Http\Controllers;

use App\Models\SteamItem;
use App\Models\StockItem;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $items = StockItem::all()->map(function($item){
            return [
                'name' => $item->steamItem->name,
                'quantity' => $item->quantity,
                'total_cost' => $item->total_cost,
                'net_value' => $item->net_value,
            ];
        });
        return view('dashboard.dashboard', [
            'items' => $items,
        ]);
    }

    public function create()
    {

    }
}
