<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\ApiTestController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\EconomicController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PortController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\DataVisualizationController;
use App\Http\Controllers\RiskController;

// Admin
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PortDatasetController;
use App\Http\Controllers\Admin\ArticleController;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','user'])->group(function () {

    Route::get('/dashboard', [DashboardController::class,'index'])
        ->name('dashboard');

    Route::get('/profile',[ProfileController::class,'edit'])
        ->name('profile.edit');

    Route::patch('/profile',[ProfileController::class,'update'])
        ->name('profile.update');

    Route::delete('/profile',[ProfileController::class,'destroy'])
        ->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Active Country
|--------------------------------------------------------------------------
*/

Route::post('/active-country',[CountryController::class,'setActiveCountry'])
    ->name('country.active');

/*
|--------------------------------------------------------------------------
| Country
|--------------------------------------------------------------------------
*/

Route::get('/countries/sync',[CountryController::class,'sync'])
    ->name('countries.sync');

/*
|--------------------------------------------------------------------------
| Weather
|--------------------------------------------------------------------------
*/

Route::get('/weather',[WeatherController::class,'index'])
    ->name('weather');

Route::get('/weather/sync-all',[WeatherController::class,'syncAll'])
    ->name('weather.sync.all');

/*
|--------------------------------------------------------------------------
| Currency
|--------------------------------------------------------------------------
*/

Route::get('/currency',[CurrencyController::class,'index'])
    ->name('currency');

Route::get('/currency/sync-all',[CurrencyController::class,'syncAll'])
    ->name('currency.sync.all');

/*
|--------------------------------------------------------------------------
| Economic
|--------------------------------------------------------------------------
*/

Route::get('/economic/sync',[EconomicController::class,'sync'])
    ->name('economic.sync');

Route::get('/economic/sync-all',[EconomicController::class,'syncAll'])
    ->name('economic.sync.all');

/*
|--------------------------------------------------------------------------
| News
|--------------------------------------------------------------------------
*/

Route::get('/news',[NewsController::class,'index'])
    ->name('news');

Route::get('/news/sync',[NewsController::class,'sync'])
    ->name('news.sync');

/*
|--------------------------------------------------------------------------
| Port
|--------------------------------------------------------------------------
*/

Route::get('/ports',[PortController::class,'index'])
    ->name('ports');

Route::get('/ports/import',[PortController::class,'import'])
    ->name('ports.import');

/*
|--------------------------------------------------------------------------
| Compare
|--------------------------------------------------------------------------
*/

Route::get('/compare',[CompareController::class,'index'])
    ->name('compare');

/*
|--------------------------------------------------------------------------
| Watchlist
|--------------------------------------------------------------------------
*/

Route::get('/watchlist',[WatchlistController::class,'index'])
    ->name('watchlist');

Route::post('/watchlist/{country}',[WatchlistController::class,'store'])
    ->name('watchlist.store');

Route::delete('/watchlist/{country}',[WatchlistController::class,'destroy'])
    ->name('watchlist.destroy');

/*
|--------------------------------------------------------------------------
| Visualization
|--------------------------------------------------------------------------
*/

Route::get('/visualization',[DataVisualizationController::class,'index'])
    ->name('visualization');

/*
|--------------------------------------------------------------------------
| Risk
|--------------------------------------------------------------------------
*/

Route::get('/risk',[RiskController::class,'index'])
    ->name('risk');

Route::get('/risk/calculate-all',[RiskController::class,'calculateAll'])
    ->name('risk.calculate');

/*
|--------------------------------------------------------------------------
| API Test
|--------------------------------------------------------------------------
*/

Route::get('/api-test',[ApiTestController::class,'index']);

Route::get('/api-test/countries',[ApiTestController::class,'countries']);

Route::get('/api-test/weather',[ApiTestController::class,'weather']);

Route::get('/api-test/economic',[ApiTestController::class,'economic']);

Route::get('/api-test/currency',[ApiTestController::class,'currency']);

Route::get('/api-test/news',[ApiTestController::class,'news']);

Route::get('/api-test/ports',[ApiTestController::class,'ports']);

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','admin'])
    ->prefix('admin')
    ->group(function(){

        Route::get('/',
            [AdminDashboardController::class,'index'])
            ->name('admin.dashboard');

        Route::resource('users',UserController::class);

        Route::resource('ports',PortDatasetController::class);

        Route::post(
            '/ports/import',
            [PortDatasetController::class,'import']
        )->name('ports.import');

        Route::resource('articles',ArticleController::class);

});


Route::get('/dashboard/country/{country}', [DashboardController::class, 'countryData'])
    ->name('dashboard.country');

Route::get('/dashboard/live-data', [DashboardController::class, 'liveData'])
    ->name('dashboard.live-data');

Route::post('/dashboard/active-country', [DashboardController::class, 'setActiveCountry'])
    ->name('dashboard.active-country');

/*
|--------------------------------------------------------------------------
| Breeze Auth
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
