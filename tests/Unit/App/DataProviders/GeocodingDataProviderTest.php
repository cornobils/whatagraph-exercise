<?php

declare(strict_types=1);

namespace Tests\Unit\App\DataProviders;

use App\DataProviders\GeocodingDataProvider;
use App\DTO\Location;
use Tests\TestCase;

class GeocodingDataProviderTest extends TestCase
{
    /**
     * @return void
     */
    public function test_successful()
    {
        $service = new GeocodingDataProvider();
        /** @var Location $response */
        $response = $service->getLocation("zarasai")[0];
        $this->assertInstanceOf(Location::class, $response);
        $this->assertEquals('0 Zarasai (LT)', $response->getId());
        $this->assertEquals('Zarasai', $response->getName());
        $this->assertEquals(55.7304035, $response->getLat());
        $this->assertEquals(26.2471471, $response->getLon());
    }
}
