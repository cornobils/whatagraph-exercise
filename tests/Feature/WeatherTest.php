<?php
declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

final class WeatherTest extends TestCase
{
    public function test_locationNotFound()
    {
        $this->expectExceptionMessage('No locations found.');
        $this->artisan('app:weather')
            ->expectsQuestion('Location name:', 'zootopia')
            ->doesntExpectOutput('Data has been sent successfully')
            ->assertExitCode(1)
        ;
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_successfulOne()
    {
        $this->artisan('app:weather')
            ->expectsQuestion('Location name:', 'Turmantas')
            ->expectsQuestion('Select locations:', ['0 Turmantas (LT)'])
            ->expectsOutput('Data has been sent successfully')
            ->assertExitCode(0)
        ;
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_successfulMultiple()
    {
        $this->artisan('app:weather')
            ->expectsQuestion('Location name:', 'riga')
            ->expectsQuestion('Select locations:', ['0 Riga (LV)', 'Town of Riga (US)'])
            ->expectsOutput('Data has been sent successfully')
            ->assertExitCode(0)
        ;
    }
}
