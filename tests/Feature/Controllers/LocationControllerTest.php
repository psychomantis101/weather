<?php

namespace Tests\Feature\Controllers;

use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class LocationControllerTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    public function testSaveFavoriteLocation()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $city = $this->faker->city;

        $response = $this->postJson(route('location.saveFavoriteLocation'), ['city' => $city]);

        $response->assertStatus(JsonResponse::HTTP_OK);
        $response->assertJson(['location' => $city]);

        $this->assertDatabaseHas('locations', ['city' => $city]);
        $this->assertDatabaseHas('location_user', [
            'user_id' => $user->id,
            'location_id' => Location::where('city', $city)->first()->id,
        ]);
    }
}
