<?php

namespace App\Services;

use App\ApiRequests\CurrencyConversionApiRequest;
use Illuminate\Support\Facades\Cache;

class UsdToGbpConversionService
{
    private readonly CurrencyConversionApiRequest $conversionApiRepository;
    public function __construct(){
        $this->conversionApiRepository = new CurrencyConversionApiRequest();
    }
    public function getConversionFactor(): float
    {
        return Cache::remember('conversion-factor', 60 * 24, function () {
            return $this->fetchConversionFactor();
        });
    }

    private function fetchConversionFactor(): float
    {
        $usdToPounds = $this->conversionApiRepository
            ->buildUrl('&currencies=GBP')
            ->makeRequest('get');

        if(!is_float($usdToPounds)){
            $usdToPounds = config('app.default_conversion_rate');
        }

        return $usdToPounds;
    }
}
