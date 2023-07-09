<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Models\Location;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    public function saveFavoriteLocation(LocationRequest $request): JsonResponse
    {
        $location = Location::firstOrCreate([
            'city' => $request->city,
        ]);

        auth()->user()->locations()->syncWithoutDetaching($location);

        return response()->json(['location' => $location->city]);
    }
}
