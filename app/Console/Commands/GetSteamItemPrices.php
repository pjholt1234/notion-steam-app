<?php

namespace App\Console\Commands;

use App\Models\SteamItem;
use App\Repositories\SteamMarketApiRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetSteamItemPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'item:get-price {--itemId=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(SteamMarketApiRepository $steamMarketService): void
    {
        $options = $this->options();
        if (array_key_exists('itemId', $options) && isset($options['itemId'])) {
            $items = SteamItem::find($options['itemId']);
        } else {
            $items = SteamItem::all();
        }

        foreach($items as $item){
            $path = '/market/item/730/'.$item->market_hash_name;
            $currentPrice = $steamMarketService
                ->buildUrl($path)
                ->makeRequest('get');

            if(!is_float($currentPrice)){
                continue;
            }

            $item->current_price_per_unit = $currentPrice;
            $item->save();
        }

    }
}