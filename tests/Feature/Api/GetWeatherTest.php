<?php

namespace Tests\Feature\Api;

use App\Api\GetWeather;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GetWeatherTest extends TestCase
{
    private $apiKey = 'test-api-key';
    private $city = 'New York';

    protected function setUp(): void
    {
        parent::setUp();

        // Set up the mock HTTP client
        Http::fake([
            '*' => Http::response(['name' => 'New York', 'lat' => 40.7128, 'lon' => -74.0060], 200),
        ]);
    }

    /** @test */
    public function it_returns_weather_data_for_a_city()
    {
        $weather = (new GetWeather($this->city, $this->apiKey))->getWeather();

        $this->assertArrayHasKey('weather', $weather);
        $this->assertArrayHasKey('location', $weather);
    }

    /** @test */
    public function it_returns_false_if_location_cannot_be_found()
    {
        Http::fake([
            '*' => Http::response([], 404),
        ]);

        $weather = (new GetWeather('Non-existent city', $this->apiKey))->getWeather();

        $this->assertFalse($weather);
    }
}
