<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\DataProviders\LocationDataProviderInterface;
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

        return 0;
    }
}
