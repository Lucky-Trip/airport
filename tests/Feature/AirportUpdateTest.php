<?php

use Illuminate\Http\Response;
use Modules\V1\Airports\Models\Airport;

it('client can update an airport', function () {
    $airport = Airport::factory()->create();
    $response = $this->patch(route('airports.update', $airport->id), [
        'airport_id' => $airport->airport_id,
        'name' => fake()->name,
        'latitude' => 83,
        'longitude' => 12,
        'iata_code' => fake()->shuffleString('csh'),
        'description' => fake()->text,
        'terms_and_conditions' => fake()->text
    ]);

    expect($response->status())->toBe(Response::HTTP_OK);
});
