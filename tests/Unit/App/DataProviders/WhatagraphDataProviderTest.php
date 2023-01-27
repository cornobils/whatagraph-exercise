<?php

namespace Tests\Unit\App\DataProviders;

use App\DataProviders\WhatagraphDataProvider;
use App\DTO\MarketingRequest;
use Tests\TestCase;

class WhatagraphDataProviderTest extends TestCase
{
    /**
     * @dataProvider getDataProvider
     *
     * @return void
     */
    public function test_successful($marketingRequests, $expecteds)
    {
        $service = new WhatagraphDataProvider();
        $response = $service->sendData($marketingRequests);
        for ($i = 0; $i < count($marketingRequests); $i++) {
            $this->assertEquals($expecteds[$i]['temperature'], $response[$i]['temperature']);
            $this->assertEquals($expecteds[$i]['location'], $response[$i]['location']);
        }

    }

    public function getDataProvider()
    {
        $firstObj = (new MarketingRequest())
            ->setLocation('Demene')
            ->setTemp(270.1);
        $firstExpected = [
            'temperature' => 270.1,
            'location' => 'Demene',
        ];

        $secondObj = (new MarketingRequest())
            ->setLocation('Visaginas')
            ->setTemp(260);
        $secondExpected = [
            'temperature' => 260,
            'location' => 'Visaginas',
        ];

        return [
            [[$firstObj], [$firstExpected]],
            [[$firstObj, $secondObj], [$firstExpected, $secondExpected]]
        ];
    }
}
