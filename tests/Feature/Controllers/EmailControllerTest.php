<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class EmailControllerTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    public function testIndex()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $response = $this->get(route('emailOptIn.index'));

        $response->assertStatus(200);
        $response->assertViewIs('emailOptIn');
        $response->assertViewHas('optIn', $user->email_opt_in);
    }

    public function testOptIn()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $response = $this->post(route('emailOptIn.optIn'), ['optIn' => 1]);

        $response->assertRedirect();
        $response->assertSessionHas('message', 'Email Opt In Updated!');
        $this->assertEquals(1, $user->fresh()->email_opt_in);
    }
}
