<?php


namespace App\DataProviders;


use App\DTO\Location;
use App\DTO\MarketingRequest;

interface WeatherDataProviderInterface
{
    public function getWeather(Location $location): MarketingRequest;
}

