<?php

use Illuminate\Support\Facades\Route;
use Modules\V1\Languages\Middlewares\LanguageMiddleware;

Route::group([
    'prefix' => 'airports',
    'middleware' => LanguageMiddleware::class,
    'namespace' => 'Airports\Controllers',
], static function () {
    Route::post('/', 'AirportsController@store')->name('airport.store');
});
