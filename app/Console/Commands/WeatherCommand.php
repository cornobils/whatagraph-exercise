<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\DataProviders\LocationDataProviderInterface;
use App\DataProviders\MarketingDataProviderInterface;
use App\DataProviders\WeatherDataProviderInterface;
use App\DTO\Location;
use App\DTO\MarketingRequest;
use Illuminate\Console\Command;

class WeatherCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:weather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'receives weather data and submits to Whatagraph';

    private LocationDataProviderInterface $locationDataProvider;
    private WeatherDataProviderInterface $weatherDataProvider;
    private MarketingDataProviderInterface $marketingDataProvider;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        LocationDataProviderInterface $locationDataProvider,
        WeatherDataProviderInterface $weatherDataProvider,
        MarketingDataProviderInterface $marketingDataProvider
    ) {
        parent::__construct();
        $this->locationDataProvider = $locationDataProvider;
        $this->weatherDataProvider = $weatherDataProvider;
        $this->marketingDataProvider = $marketingDataProvider;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $locations = $this->getLocations();
        $marketingRequests = $this->getMarketingRequests($locations);
        $sentData = $this->marketingDataProvider->sendData($marketingRequests);

        $this->info('Data has been sent successfully');
        $this->info(json_encode($sentData));

        return 0;
    }

    /**
     * @return Location[]
     */
    private function getLocations(): array
    {
        $locationString = $this->ask('Location name:');
        $locations = $this->locationDataProvider->getLocation($locationString);
        $selectedLocationIds = $this->choice(
            'Select locations:',
            $this->createChoices($locations),
            0,
            null,
            true
        );

        return $this->resolveLocationsByIds($selectedLocationIds, $locations);
    }

    /**
     * @param Location[] $locations
     * @return MarketingRequest[]
     */
    private function getMarketingRequests(array $locations): array
    {
        return array_map(function (Location $location) {
            return $this->weatherDataProvider->getWeather($location);
        }, $locations);
    }

    private function createChoices(array $locations): array
    {
        return array_map(fn(Location $location) => $location->getId(), $locations);
    }

    /**
     * @param string[] $selectedLocationIds
     * @param Location[] $locations
     * @return Location[]
     */
    private function resolveLocationsByIds(array $selectedLocationIds, array $locations): array
    {
        $selectedLocations = [];
        foreach ($selectedLocationIds as $selectedLocationId) {
            foreach ($locations as $location) {
                if ($location->getId() === $selectedLocationId) {
                    $selectedLocations[] = $location;
                    break;
                }
            }
        }

        return $selectedLocations;
    }
}
