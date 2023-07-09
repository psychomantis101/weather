<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Services\WeatherService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WeatherControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use DatabaseMigrations, WithFaker;

    public function testIndexWithCity()
    {
        $user = User::factory()->create();
        $city = 'New York';

        // Create a mock instance of WeatherService
        $weatherServiceMock = \Mockery::mock(WeatherService::class);
        $weatherServiceMock->shouldReceive('getCurrentWeather')
            ->with($city)
            ->andReturn([
                'name' => 'New York',
                'date' => Carbon::now()->format('d/m/Y H:i'),
                'temp' => '25 °C',
                'feels_like' => '28 °C',
                'description' => 'Cloudy',
            ]);

        // Replace the actual WeatherService instance with the mocked version
        $this->app->instance(WeatherService::class, $weatherServiceMock);

        // Act
        $response = $this->actingAs($user)
            ->get(route('weather.index', ['city' => $city]));

        // Assert
        $response->assertStatus(200);
        $response->assertViewHas('favoriteLocations');
        $response->assertViewHas('currentWeather');

        $currentWeather = $response->viewData('currentWeather');

        $this->assertEquals('New York', $currentWeather['name']);
        $this->assertEquals(Carbon::now()->format('d/m/Y H:i'), $currentWeather['date']);
        $this->assertEquals('25 °C', $currentWeather['temp']);
        $this->assertEquals('28 °C', $currentWeather['feels_like']);
        $this->assertEquals('Cloudy', $currentWeather['description']);
    }
}
