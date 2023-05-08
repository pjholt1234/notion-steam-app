<?php

namespace App\Services;

use App\Models\SteamItem;
use App\Repositories\CurrencyConversionApiRepository;
use App\Repositories\SteamMarketApiRepository;

class ItemPriceUpdateService
{
    private readonly CurrencyConversionApiRepository $conversionApiRepository;
    private readonly SteamMarketApiRepository $marketApiRepository;
    public function __construct(){
        $this->conversionApiRepository = new CurrencyConversionApiRepository();
        $this->marketApiRepository = new SteamMarketApiRepository();
    }

    public function updatePrice(SteamItem $item): void
    {
        $usdToPounds = $this->conversionApiRepository
            ->buildUrl('&currencies=GBP')
            ->makeRequest('get');

        if(!is_float($usdToPounds)){
            $usdToPounds = config('app.default_conversion_rate');
        }

        $url = '/market/item/730/'.$item->market_hash_name;
        $currentPrice = $this->marketApiRepository
            ->buildUrl($url)
            ->makeRequest('get');

        $item->current_price_per_unit = round($currentPrice * $usdToPounds, 2);
        $item->save();
    }
}
