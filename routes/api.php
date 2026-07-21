<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CountryApiController;
use App\Http\Controllers\Api\RiskApiController;
use App\Http\Controllers\Api\PortApiController;
use App\Http\Controllers\Api\NewsApiController;
use App\Http\Controllers\Api\CurrencyApiController;


Route::prefix('v1')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Countries
    |--------------------------------------------------------------------------
    */

    Route::get('/countries', [CountryApiController::class, 'index']);

    /*
    |--------------------------------------------------------------------------
    | Risk Scores
    |--------------------------------------------------------------------------
    */

    Route::get('/risk', [RiskApiController::class, 'index']);

    /*
    |--------------------------------------------------------------------------
    | Ports
    |--------------------------------------------------------------------------
    */

    Route::get('/ports', [PortApiController::class, 'index']);

    /*
    |--------------------------------------------------------------------------
    | News
    |--------------------------------------------------------------------------
    */

    Route::get('/news', [NewsApiController::class, 'index']);

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    */

    Route::get('/currency', [CurrencyApiController::class, 'index']);

});
