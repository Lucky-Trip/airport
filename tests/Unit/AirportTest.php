<?php

use Modules\V1\Airports\Models\Airport;
use Modules\V1\Airports\Models\AirportDetail;

it('can create airport', function () {
    $airportDetail = AirportDetail::factory()->create();
    $airport = Airport::query()->first();

    expect($airportDetail)->toBeInstanceOf(AirportDetail::class);
    expect(Airport::count())->toBe(1);
    expect($airport->id)->toBe($airportDetail->airport_id);
});