<?php


namespace App\DataProviders;


use App\DTO\Location;

interface WeatherDataProviderInterface
{
    public function getWeather(Location $location);
}

