<?php

use Illuminate\Http\Response;
use Modules\V1\Airports\Models\Airport;


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

it('client can create airport', function () {
    $response = $this->post(route('airport.store'), [
        'airport_id' => 100,
        'name' => fake()->name,
        'latitude' => 80,
        'longitude' => 10,
        'iata_code' => fake()->shuffleString('abc'),
        'description' => fake()->text,
        'terms_and_conditions' => fake()->text
    ]);

    expect($response->status())->toBe(Response::HTTP_OK);
});

it('client cannot create airport without name', function () {
    $response = $this->post(route('airport.store'), [
        'airport_id' => 100,
        'latitude' => 80,
        'longitude' => 10,
        'iata_code' => fake()->shuffleString('abc'),
        'description' => fake()->text,
        'terms_and_conditions' => fake()->text
    ]);

    expect($response->status())->toBe(Response::HTTP_UNPROCESSABLE_ENTITY);
});