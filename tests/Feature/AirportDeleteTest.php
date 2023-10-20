<?php

use Illuminate\Http\Response;
use Modules\V1\Airports\Models\Airport;

it('client can delete airport', function () {
    $airport = Airport::factory()->create();
    $response = $this->delete(route('airports.destroy', $airport->id));

    expect($response->status())->toBe(Response::HTTP_OK);
});
