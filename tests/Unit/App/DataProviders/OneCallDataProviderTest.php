<?php

declare(strict_types=1);

namespace Tests\Unit\App\DataProviders;

use App\DataProviders\OneCallDataProvider;
use App\DTO\Location;
use App\DTO\MarketingRequest;
use Tests\TestCase;

final class OneCallDataProviderTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_successful()
    {
        $location = new Location(0, 'Zarasai', 'LT');
        $location->setLon(26.2471471);
        $location->setLat(55.7304035);

        $service = new OneCallDataProvider();
        $marketingRequest = $service->getWeather($location);
        $this->assertInstanceOf(MarketingRequest::class, $marketingRequest);
        $this->assertEquals('Zarasai', $marketingRequest->getLocation());
        $this->assertIsFloat($marketingRequest->getTemp());
    }
}
