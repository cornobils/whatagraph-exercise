<?php

namespace App\Providers;

use App\DataProviders\GeocodingDataProvider;
use App\DataProviders\LocationDataProviderInterface;
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
