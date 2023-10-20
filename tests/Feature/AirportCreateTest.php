<?php

use Illuminate\Http\Response;

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