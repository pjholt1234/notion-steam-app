<?php

namespace App\Providers;

use App\Models\SteamItem;
use App\Models\SteamPurchase;
use App\Models\SteamSale;
use App\Observers\SteamItemObserver;
use App\Observers\SteamPurchaseObserver;
use App\Observers\SteamSaleObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Register Observers
        SteamItem::observe(SteamItemObserver::class);
        SteamPurchase::observe(SteamPurchaseObserver::class);
        SteamSale::observe(SteamSaleObserver::class);
    }
}
