<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class StockItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'steam_item_id',
        'quantity',
        'net_value',
        'total_cost'
    ];

    public function steamItem(): belongsTo
    {
        return $this->belongsTo(SteamItem::class, 'steam_item_id', 'id');
    }

    public function steamPurchases(): hasManyThrough
    {
        return $this->hasManyThrough(SteamPurchase::class, SteamItem::class, 'id', 'steam_item_id');
    }

    public function steamSales(): hasManyThrough
    {
        return $this->hasManyThrough(SteamSale::class, SteamItem::class, 'id', 'steam_item_id');
    }

    public function calculateStock()
    {
        $purchases = $this->steamPurchases->sum('quantity');
        $sales = $this->steamSales->sum('quantity');

        $quantity = $purchases - $sales;

        if($quantity < 0){
            report('Warning stock item calculation has detected a negative stock quantity');
        } else {
            $this->quantity = $quantity;
            $this->save();
        }
    }

    public function calculateCost()
    {
        $this->total_cost = $this->steamPurchases->sum('purchase_cost');
        $this->save();
    }
}
