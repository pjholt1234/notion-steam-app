<?php

namespace App\ApiRequests;


use App\Abstracts\AbstractApiRequest;

class SteamMarketApiRequest extends AbstractApiRequest
{
    protected string $apiKey;
    public function __construct(public bool $getImage = false){
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

    public function processData(array $response)
    {

        if($this->getImage){
            if(array_key_exists('image', $response)){
                return $response['image'];
            }
        }

        if(array_key_exists('median_avg_prices_15days', $response)){
            return $response['median_avg_prices_15days'][14][1];
        }

        $this->error('Missing valid key');

        return null;
    }
}
