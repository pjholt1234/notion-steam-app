<?php

namespace App\Http\Controllers;

use App\Models\SteamItem;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function create()
    {
        $steamItems = SteamItem::select('id', 'name')->get();
        return view('sales.create', [
            'steamItems' => $steamItems
        ]);
    }
}
