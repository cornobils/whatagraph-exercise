<?php

namespace App\Providers;

use App\DataProviders\GeocodingDataProvider;
use App\DataProviders\LocationDataProviderInterface;
use App\DataProviders\MarketingDataProviderInterface;
use App\DataProviders\OneCallDataProvider;
use App\DataProviders\WeatherDataProviderInterface;
use App\DataProviders\WhatagraphDataProvider;
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
        $this->app->singleton(WeatherDataProviderInterface::class, OneCallDataProvider::class);
        $this->app->singleton(MarketingDataProviderInterface::class, WhatagraphDataProvider::class);
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
