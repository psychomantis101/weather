<?php

namespace App\Api;
use Illuminate\Support\Facades\Cache;

class GetWeather
{
    private $apiKey;

    public function __construct(
        private $city
    ) {
        $this->apiKey = config('services.open_weather_map.key');
    }

    public function getWeather()
    {
        $location = $this->getLocation();

        if (!$location) {
            return false;
        }

        //remember the weather for 5 minutes, help with heavy traffic
        $weatherApiUrl = Cache::remember("weather-{$location->lat}-{$location->lon}", 300, function () use ($location) {
            return "https://api.openweathermap.org/data/2.5/onecall?lat={$location->lat}&lon={$location->lon}&exclude=minutely,hourly&units=metric&appid={$this->apiKey}";
        });

        return ['weather' => file_get_contents($weatherApiUrl), 'location' => $location];
    }

    private function getLocation()
    {
        //remember the location for 10 days, considered doing it forever, but new cities might get built be previously miss-spelt names :)
        $locationApiUrl = Cache::remember("city-{$this->city}",864000, function () {
            return "http://api.openweathermap.org/geo/1.0/direct?q={$this->city}&limit=1&appid={$this->apiKey}";
        });

        $locationJson = json_decode(file_get_contents($locationApiUrl));

        if (count($locationJson) === 0) {
            return false;
        }

        return $locationJson[0];
    }
}
