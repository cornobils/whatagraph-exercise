<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\DataProviders\LocationDataProviderInterface;
use App\DTO\Location;
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

    /**
     * @var LocationDataProviderInterface
     */
    private $locationDataProvider;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(LocationDataProviderInterface $locationDataProvider)
    {
        parent::__construct();
        $this->locationDataProvider = $locationDataProvider;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
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
        $selectedLocations = $this->resolveLocationsByIds($selectedLocationIds, $locations);

        return 0;
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
