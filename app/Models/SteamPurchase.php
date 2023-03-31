<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SteamPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'steam_item_id',
        'quantity',
        'purchase_cost',
        'transaction_date',
        'updated_at',
        'created_at'
    ];

    public function steamItem(): BelongsTo
    {
        return $this->belongsTo(SteamItem::class, 'steam_item_id', 'id');
    }
}
