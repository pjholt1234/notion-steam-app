<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSteamPurchaseRequest;
use App\Models\SteamItem;
use App\Models\SteamPurchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function create()
    {
        $steamItems = SteamItem::select('id', 'name')->get();
        return view('purchases.create', [
            'steamItems' => $steamItems
        ]);
    }

    public function store(StoreSteamPurchaseRequest $request)
    {
        SteamPurchase::create($request->all());

        return redirect()->route('dashboard');
    }

    public function edit()
    {
        //todo
    }
    public function update()
    {
        //todo
    }

    public function delete(SteamPurchase $steamPurchase)
    {
        //todo
    }
}
