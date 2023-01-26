<?php

declare(strict_types=1);

namespace App\DTO;

final class Location
{
    private string $id;
    private string $name;
    private string $country;
    private float $lat;
    private float $lon;

    public function __construct(int $key, string $name, string $country)
    {
        $this->setName($name);
        $this->setCountry($country);
        $this->setId(sprintf("%s %s (%s)", $key, $this->getName(), $this->getCountry()));
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getLat(): float
    {
        return $this->lat;
    }

    /**
     * @param float $lat
     */
    public function setLat(float $lat): void
    {
        $this->lat = $lat;
    }

    /**
     * @return float
     */
    public function getLon(): float
    {
        return $this->lon;
    }

    /**
     * @param float $lon
     */
    public function setLon(float $lon): void
    {
        $this->lon = $lon;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }
}
