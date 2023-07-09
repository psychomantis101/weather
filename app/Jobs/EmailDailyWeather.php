<?php

namespace App\Jobs;

use App\Mail\DailyWeather;
use App\Models\User;
use App\Services\WeatherService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EmailDailyWeather implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::where('email_opt_in', true)->with('locations')->get();

        $weatherService = new WeatherService();

        foreach ($users as $user) {
            $locations = [];
            foreach ($user->locations as $location) {
                $locations[] = $weatherService->getCurrentWeather($location->city);
                Mail::to($user->email)->send(new DailyWeather($locations));
            }
        }
    }
}
