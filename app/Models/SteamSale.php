<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class SteamSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'steam_item_id',
        'quantity',
        'sale_value',
        'transaction_date',
        'updated_at',
        'created_at'

    ];

    public function steamItem(): BelongsTo
    {
        return $this->belongsTo(SteamItem::class, 'steam_item_id', 'id');
    }

    public function stockItem(): HasOneThrough
    {
        return $this->HasOneThrough(StockItem::class, SteamItem::class, 'id', 'steam_item_id');
    }
}
