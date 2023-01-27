<?php

declare(strict_types=1);

namespace App\DataProviders;

use App\DTO\MarketingRequest;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Date;

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
        $apiKey = env('WHATAGRAPH_API_KEY');
        if ($apiKey === null) {
            throw new \InvalidArgumentException('WHATAGRAPH_API_KEY env parameter is empty. It will cause unexpected 500 error');
        }
        $client->request(
            'POST',
            self::PATH,
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '. $apiKey,
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
