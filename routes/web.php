<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/weather', [WeatherController::class, 'index'])->middleware(['auth', 'verified'])->name('weather.index');
Route::post('/save-favorite-location', [LocationController::class, 'saveFavoriteLocation'])->middleware(['auth', 'verified'])->name('location.saveFavoriteLocation');
Route::get('/email-opt-in', [EmailController::class, 'index'])->middleware(['auth', 'verified'])->name('emailOptIn.index');
Route::post('/optIn', [EmailController::class, 'optIn'])->middleware(['auth', 'verified'])->name('emailOptIn.optIn');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
