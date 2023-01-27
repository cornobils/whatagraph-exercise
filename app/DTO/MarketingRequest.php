<?php

namespace App\DTO;

final class MarketingRequest
{
    private float $temp;
    private string $location;

    /**
     * @return float
     */
    public function getTemp(): float
    {
        return $this->temp;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param float $temp
     * @return MarketingRequest
     */
    public function setTemp(float $temp): MarketingRequest
    {
        $this->temp = $temp;

        return $this;
    }

    /**
     * @param string $location
     * @return MarketingRequest
     */
    public function setLocation(string $location): MarketingRequest
    {
        $this->location = $location;

        return $this;
    }
}
