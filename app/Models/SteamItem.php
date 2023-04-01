<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SteamItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'market_hash_name',
        'current_price_per_unit',
        'updated_at',
        'created_at'
    ];

    public function steamSales(): HasMany
    {
        return $this->hasMany(SteamSale::class, 'steam_item_id', 'id');
    }

    public function steamPurchases(): HasMany
    {
        return $this->hasMany(SteamPurchase::class, 'steam_item_id', 'id');
    }

    public function stockItem(): HasOne
    {
        return $this->hasOne(StockItem::class, 'steam_item_id', 'id');
    }
}
