<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\EconomicController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PortController;
use App\Http\Controllers\NewsPageController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\AdminController;

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
'/dashboard',
[
DashboardController::class,
'index'
]
)
->name('dashboard');

Route::get('/weather',
[
    WeatherController::class,
    'index'
])
->name('weather');

Route::get('/currency',
[
    CurrencyController::class,
    'index'
])
->name('currency');



Route::get('/ports',
[
    PortController::class,
    'index'
])
->name('ports');



Route::get('/news',
[
    NewsPageController::class,
    'index'
])
->name('news');



Route::get('/compare',
[
    CompareController::class,
    'index'
])
->name('compare');



Route::get('/watchlist',
[
    WatchlistController::class,
    'index'
])
->name('watchlist');



Route::get('/admin',
[
    AdminController::class,
    'index'
])
->name('admin');
