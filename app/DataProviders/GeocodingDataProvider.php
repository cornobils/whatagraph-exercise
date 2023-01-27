<?php

declare(strict_types=1);

namespace App\DataProviders;

use App\DTO\Location;
use Illuminate\Support\Facades\Http;

final class GeocodingDataProvider implements LocationDataProviderInterface
{
    public const BASE_URL = 'http://api.openweathermap.org/geo/1.0/direct';

    public function getLocation(string $location): array
    {
        $url = $this->getUrl($location);
        $response = Http::get($url);
        $response->throw();
        $body = $response->json();
        $result = [];
        if (count($body) === 0) {
            throw new \InvalidArgumentException('No locations found.');
        }
        foreach ($body as $key => $locationResponse) {
            $result[] = $this->createLocation($locationResponse, $key);
        }

        return $result;
    }

    private function getUrl(string $location): string
    {
        $queryParams = http_build_query([
            'q' => $location,
            'limit' => 10,
            'appid' => env('GEOCODING_API_KEY'),
        ]);

        return self::BASE_URL . '?' . $queryParams;
    }

    private function createLocation(array $locationResponse, $key): Location
    {
        $location = new Location($key, $locationResponse['name'], $locationResponse['country']);
        $location->setLat($locationResponse['lat']);
        $location->setLon($locationResponse['lon']);

        return $location;
    }
}
