<?php

use Modules\V1\Airports\Models\Airport;
use Illuminate\Http\Response;

it('client can get all airports', function () {
    Airport::factory(50)->create();
    $response = $this->get(route('airports.index'));

    expect($response->status())->toBe(Response::HTTP_OK)
                               ->and(Airport::query()->count())
                               ->toBe(50);
});

it('client can get all airports with latitude and longitude', function () {
    Airport::factory(50)->create();
    $response = $this->get(route('airports.index', [
        'latitude' => 50,
        'longitude' => 120
    ]));

    expect($response->status())->toBe(Response::HTTP_OK);
});

it('client can get an airport', function () {
    $airport = Airport::factory(1)->create();
    $response = $this->get(route('airports.show', $airport->first()->id));

    expect($response->status())->toBe(Response::HTTP_OK);
});