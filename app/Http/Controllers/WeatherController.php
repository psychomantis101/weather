<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function __construct(
       private WeatherService $weatherService
    ) {}

    public function index(Request $request): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $currentWeather =  $request->city ? $this->weatherService->getCurrentWeather($request->city) : null;

        $favoriteLocations = auth()->user()->locations()->get();

        $request->flash();

        return view('weather', compact('favoriteLocations', 'currentWeather'));
    }
}
