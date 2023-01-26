<?php

namespace App\Providers;

use App\DataProviders\GeocodingDataProvider;
use App\DataProviders\LocationDataProviderInterface;
use App\DataProviders\MarketingDataProviderInterface;
use App\DataProviders\OneCallDataProviderInterface;
use App\DataProviders\WeatherDataProviderInterface;
use App\DataProviders\WhatagraphDataProviderInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LocationDataProviderInterface::class, GeocodingDataProvider::class);
        $this->app->singleton(WeatherDataProviderInterface::class, OneCallDataProviderInterface::class);
        $this->app->singleton(MarketingDataProviderInterface::class, WhatagraphDataProviderInterface::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
