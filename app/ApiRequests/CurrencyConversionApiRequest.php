<?php

namespace App\ApiRequests;


use App\Abstracts\AbstractApiRequest;

class CurrencyConversionApiRequest extends AbstractApiRequest
{
    protected string $apiKey;
    protected bool $processData = true;

    public function __construct(){
        parent::__construct();

        $this->apiKey = config('app.currency_conversion_api_key');
        $this->baseUrl = 'https://api.freecurrencyapi.com/v1/latest';
        $this->validMethods = ['get'];
    }

    public function buildUrl(string $url): self
    {
        $this->url = $this->baseUrl.'?apikey='.$this->apiKey.$url;
        return $this;
    }

    public function processData(array $response): ?float
    {
        if(array_key_exists('data', $response)){
            return $response['data']['GBP'];
        }

        $this->error('Missing data key');

        return null;
    }
}
