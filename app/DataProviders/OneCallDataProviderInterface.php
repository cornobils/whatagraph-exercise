<?php

namespace App\DataProviders;

use App\DTO\Location;
use App\DTO\MarketingRequest;
use Illuminate\Support\Facades\Http;

final class OneCallDataProviderInterface implements WeatherDataProviderInterface
{
    public const BASE_URL = 'http://api.openweathermap.org/data/3.0/onecall';

    public function getWeather(Location $location): MarketingRequest
    {
        $url = $this->getUrl($location->getLat(), $location->getLon());
        $response = Http::get($url);
        $body = $response->json();

        return $this->createMarketingRequest($body, $location);
    }

    private function getUrl(float $lat, float $lon): string
    {
        $queryParams = http_build_query([
            'lat' => (string) $lat,
            'lon' => (string) $lon,
            'appid' => env('ONE_CALL_API_KEY'),
        ]);

        return self::BASE_URL . '?' . $queryParams;
    }

    private function createMarketingRequest(array $body, Location $location): MarketingRequest
    {
        $marketingRequest = new MarketingRequest();
        $marketingRequest->setTemp($body['current']['temp']);
        $marketingRequest->setLocation($location->getName());

        return $marketingRequest;
    }
}
