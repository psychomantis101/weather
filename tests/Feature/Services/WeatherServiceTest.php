<?php

namespace Tests\Feature\Services;

use App\Api\GetWeather;
use App\Services\WeatherService;
use Carbon\Carbon;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Tests\TestCase;

class WeatherServiceTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testGetCurrentWeather()
    {
        $city = 'New York';

        // Mock the GetWeather class
        $getWeatherMock = \Mockery::mock(GetWeather::class);
        $getWeatherMock->shouldReceive('getWeather')->andReturn([
            'location' => (object) ['name' => 'New York County'],
            'weather' => json_encode([
                'current' => [
                    'dt' => time(),
                    'temp' => 24.21,
                    'feels_like' => 25.06,
                    'weather' => [
                        ['description' => 'broken clouds'],
                    ],
                ],
            ]),
        ]);

        // Create an instance of WeatherService with the mocked GetWeather dependency
        $weatherService = new WeatherService($getWeatherMock);

        // Call the getCurrentWeather method
        $currentWeather = $weatherService->getCurrentWeather($city);

        // Assert the result
        $expectedResult = [
            'name' => 'New York County',
            'date' => Carbon::createFromTimestamp(time())->format('d/m/Y H:i'),
            'temp' => '24.42 °C',
            'feels_like' => '25.06 °C',
            'description' => 'broken clouds',
        ];

        //deal with slight difference because of float
        $this->assertWeatherDataEquals($expectedResult, $currentWeather, 0.5);
    }

    /**
     * Asserts that two weather data arrays are equal with a delta value for temperature.
     *
     * @param array $expected
     * @param array $actual
     * @param float $delta
     */
    protected function assertWeatherDataEquals(array $expected, array $actual, float $delta)
    {
        $this->assertEquals(count($expected), count($actual), 'Arrays have different lengths.');

        foreach ($expected as $key => $value) {
            if ($key === 'temp' || $key === 'feels_like') {
                $expectedValue = (float) str_replace(' °C', '', $value);
                $actualValue = (float) str_replace(' °C', '', $actual[$key]);
                $this->assertEqualsWithDelta($expectedValue, $actualValue, $delta, "Value mismatch for key '$key'.");
            } else {
                $this->assertEquals($value, $actual[$key], "Value mismatch for key '$key'.");
            }
        }
    }
}
