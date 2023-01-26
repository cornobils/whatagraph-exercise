<?php

namespace App\DataProviders;

use App\DTO\MarketingRequest;

interface MarketingDataProviderInterface
{
    /**
     * @param MarketingRequest[] $marketingRequests
     */
    public function sendData(array $marketingRequests);
}
