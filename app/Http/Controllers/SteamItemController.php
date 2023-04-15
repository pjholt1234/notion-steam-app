<?php

namespace App\Http\Controllers;

use App\Models\SteamItem;
use Illuminate\Http\Request;

class SteamItemController extends Controller
{
    public function index()
    {
        $steamItems = SteamItem::select('name')->get();;
        return view('steam-item.index', [
            'steamItems' => $steamItems,
        ]);
    }

    public function create()
    {

    }
}
