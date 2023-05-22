<?php

namespace App\Http\Controllers;

use App\Models\StockItem;
use Illuminate\Support\Facades\Artisan;

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

    public function recalculate()
    {
        StockItem::all()->each(fn($stockItem) => $stockItem->calculate());

        session()->flash('alert', [
            'message' => 'Stock + profit successfully recalculated',
            'success' => true,
        ]);

        return redirect()->route('dashboard');
    }

    public function uploadToNotion()
    {
        Artisan::call('notion:update');

        session()->flash('alert', [
            'message' => 'Notion board successfully updated',
            'success' => true,
        ]);

        return redirect()->route('dashboard');
    }
}
