<?php

namespace App\Services;

use App\Models\SteamItem;
use App\ApiRequests\CurrencyConversionApiRequest;
use App\ApiRequests\SteamMarketApiRequest;

class ItemPriceUpdateService
{
    private readonly UsdToGbpConversionService $conversionService;
    private readonly SteamMarketApiRequest $marketApiRepository;
    public function __construct(){
        $this->conversionService = app(UsdToGbpConversionService::class);
        $this->marketApiRepository = new SteamMarketApiRequest();
    }

    public function updatePrice(SteamItem $item): void
    {
        $usdToPounds = $this->conversionService->getConversionFactor();

        $url = '/market/item/730/'.$item->market_hash_name;
        $currentPrice = $this->marketApiRepository
            ->buildUrl($url)
            ->makeRequest('get');

        $item->current_price_per_unit = round($currentPrice * $usdToPounds, 2);
        $item->save();
    }
}
