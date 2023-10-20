<?php

use Illuminate\Support\Facades\Route;
use Modules\V1\Languages\Middlewares\LanguageMiddleware;

Route::group([
    'prefix' => 'airports',
    'middleware' => LanguageMiddleware::class,
    'namespace' => 'Airports\Controllers',
], static function () {
    Route::get('/', 'AirportsController@index')->name('airports.index');
    Route::get('/{airport}', 'AirportsController@show')->name('airports.show');
    Route::post('/', 'AirportsController@store')->name('airport.store');
    Route::patch('/{airport}', 'AirportsController@update')->name('airports.update');
});
