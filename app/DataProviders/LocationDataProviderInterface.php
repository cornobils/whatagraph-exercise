<?php

declare(strict_types=1);

namespace App\DataProviders;

use App\DTO\Location;

interface LocationDataProviderInterface
{
    /**
     * @return Location[]
     */
    public function getLocation(string $location): array;
}
