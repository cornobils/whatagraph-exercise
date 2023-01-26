<?php

namespace App\DataProviders;

use App\DTO\MarketingRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Http;

final class WhatagraphDataProvider implements MarketingDataProviderInterface
{
    public const HOST = 'https://api.whatagraph.com';
    public const PATH = '/v1/integration-source-data/';

    public function sendData(array $marketingRequests)
    {
        $client = new Client([
                'verify' => false,
                'base_uri' => self::HOST,
            ]
        );
        $weatherData = $this->createWeatherData($marketingRequests);
        $client->request(
            'POST',
            self::PATH,
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.env('WHATAGRAPH_API_KEY'),
                ],
                'json' => [
                    'data' => $weatherData,
                ],
            ]
        );

        return $weatherData;
    }

    private function createWeatherData(array $marketingRequests): array
    {
        return array_map(function(MarketingRequest $marketingRequest) {
            return [
                'temperature' => $marketingRequest->getTemp(),
                'location' => $marketingRequest->getLocation(),
                'date' => Date::now()->format('Y-m-d'),
            ];
        }, $marketingRequests);
    }
}
