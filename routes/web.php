<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\EconomicController;
use App\Http\Controllers\NewsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get(

'/country/sync',

[
CountryController::class,
'sync'
]

);

Route::get(
    '/weather/sync/{country}',
    [WeatherController::class,'sync']
)->name('weather.sync');

Route::get(
    '/dashboard',
    [DashboardController::class,'index']
)->name('dashboard');

Route::get(

'/currency/sync',

[
CurrencyController::class,
'sync'
]

);

Route::get(

'/economic/sync',

[
EconomicController::class,
'sync'
]

);

Route::get(

'/news/sync',

[
NewsController::class,
'sync'
]

);

require __DIR__.'/auth.php';
