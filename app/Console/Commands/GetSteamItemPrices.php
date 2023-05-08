<?php

namespace App\Console\Commands;

use App\Helpers\SteamItemUpdater;
use App\Models\SteamItem;
use App\Repositories\CurrencyConversionApiRepository;
use App\Repositories\SteamMarketApiRepository;
use App\Services\ItemPriceUpdateService;
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
    public function handle(): int
    {
       $itemPriceService = app(ItemPriceUpdateService::class);
        $options = $this->options();
        if (array_key_exists('itemId', $options) && isset($options['itemId'])) {
            $item = SteamItem::find($options['itemId']);
            $items = [$item];
        } else {
            $items = SteamItem::all();
        }

        foreach($items as $item)
        {
            $itemPriceService->updatePrice($item);
        }

        return self::SUCCESS;
    }
}
