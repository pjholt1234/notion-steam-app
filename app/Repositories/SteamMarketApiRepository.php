<?php

namespace App\Repositories;


use App\Abstracts\AbstractApiRepository;

class SteamMarketApiRepository extends AbstractApiRepository
{
    public string $apiKey;

    public bool $processData = true;

    public function __construct(){
        parent::__construct();

        $this->apiKey = config('app.steam_api_key');
        $this->baseUrl = 'https://api.steamapis.com';
        $this->validMethods = ['get'];
    }

    public function buildUrl(string $url): self
    {
        $this->url = $this->baseUrl.$url.'?api_key='.$this->apiKey;
        return $this;
    }

    public function processData(array $response): ?float
    {
        if(array_key_exists('median_avg_prices_15days', $response)){
            return round($response['median_avg_prices_15days'][14][1],2);
        }

        $this->error('Missing median_avg_prices_15days key');

        return null;
    }
}
