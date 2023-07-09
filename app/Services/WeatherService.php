<?php
namespace App\Services;

use App\Api\GetWeather;
use Carbon\Carbon;
class WeatherService
{
    public function getCurrentWeather($city)
    {
        $getWeather = new GetWeather($city);

        $weatherApi = $getWeather->getWeather();

        if (!$weatherApi) {
            return false;
        }

        $location = $weatherApi['location'];

        $weatherJson = json_decode($weatherApi['weather']);

        $currentWeather = [
            'name' => $location->name,
            'date' => Carbon::createFromTimestamp($weatherJson->current->dt)->format('d/m/Y' . ' ' . 'H:i'),
            'temp' => $weatherJson->current->temp . ' °C',
            'feels_like' => $weatherJson->current->feels_like . ' °C',
            'description' => $weatherJson->current->weather[0]->description,
        ];

        return $currentWeather;
    }

    //if you wanted more than just the current weather, you could add a function here to get future forecasts
}
