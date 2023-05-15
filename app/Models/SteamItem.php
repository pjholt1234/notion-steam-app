<?php

namespace App\Models;

use App\ApiRequests\SteamMarketApiRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SteamItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'market_hash_name',
        'current_price_per_unit',
        'updated_at',
        'created_at',
        'image_url'
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

    public function getImageUrl(): ?string
    {
        if(isset($this->image_url)){
            return $this->image_url;
        }

        $url = '/market/item/730/'.$this->market_hash_name;

        $marketApiRepository = new SteamMarketApiRequest(true);

        $response = $marketApiRepository
            ->buildUrl($url)
            ->makeRequest('get');

        if(is_array($response)){
            return null;
        }

        $this->image_url = $response;
        $this->save();

        return $response;
    }
}
