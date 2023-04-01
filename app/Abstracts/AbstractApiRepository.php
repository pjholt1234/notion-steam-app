<?php

namespace App\Abstracts;

use Carbon\Carbon;
use Error;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\RateLimiter\LimiterInterface;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\RateLimiter\Storage\InMemoryStorage;

abstract class AbstractApiRepository
{
    protected string $baseUrl;
    protected string $url;
    protected array $validMethods = ['get', 'post', 'put', 'patch', 'delete'];
    protected bool $rateLimited = false;
    protected Carbon $start_time;
    protected int $rate_limit;

    protected bool $processData = false;

    abstract function buildUrl(string $url): self;

    abstract function processData(array $response);

    public function __construct()
    {
        $this->start_time = Carbon::now();
        $this->setRateLimiter();
    }

    public function makeRequest(string $method)
    {
        $this->validateMethod($method);

        if(!isset($this->url)){
            $this->error('Invalid url');
            throw new Error('Invalid url');
        }

        if($this->rateLimited){
            $this->limiter->reserve()->wait();
        }

        Log::info('Requested started for: '.$this->url);
        $response = Http::{$method}($this->url);
        Log::info('Requested complete');

        if(!$response->ok()){
            $this->error(json_decode($response->body(),true));
            return [
                'status' => $response->status(),
                'error' => json_decode($response->body(),true),
            ];
        }

        if(! $this->processData || !$response->ok()){
            return $response->json();
        }

        return $this->processData($response->json());
    }

    protected function setRateLimiter(): void
    {
        if(!$this->rateLimited){
            return;
        }

        if(!isset($this->rate_limit)){
            $this->error('no rate limit set');
            throw new Error('no rate limit set');
        }

        $factory = new RateLimiterFactory([
            'id'        => $this->start_time,
            'policy'    => 'token_bucket',
            'limit'     => $this->rate_limit,
            'rate'      => ['interval' => '1 minutes', 'amount' => $this->rate_limit],
        ], new InMemoryStorage());

        $this->limiter = $factory->create();
    }

    protected function validateMethod(string $method): void
    {
        if(!in_array($method, $this->validMethods)){
            $this->error('Invalid Method');
            throw new \Error('Invalid Method');
        }
    }

    public function error($message): void
    {
        $class = get_class($this);
        Log::error($class.' '.$message);
    }
}
