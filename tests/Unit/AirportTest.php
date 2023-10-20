<?php

use Modules\V1\Airports\Models\Airport;
use Modules\V1\Airports\Models\AirportDetail;

it('can create airport', function () {
    $airportDetail = AirportDetail::factory()->create();
    /** @var Airport $airport */
    $airport = Airport::query()->first();

    expect($airportDetail)->toBeInstanceOf(AirportDetail::class)
                          ->and(Airport::count())->toBe(1)
                          ->and($airport->id)->toBe($airportDetail->airport_id);
});
