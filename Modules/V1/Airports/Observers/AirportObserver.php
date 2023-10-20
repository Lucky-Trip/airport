<?php

namespace Modules\V1\Airports\Observers;

use Illuminate\Support\Facades\Cache;
use Modules\V1\Airports\Models\Airport;
use Modules\V1\Airports\Models\Constants\AirportCacheKeys;

class AirportObserver
{
    /**
     * Handle the Airport "created" event.
     *
     * @param Airport $airport
     *
     * @return void
     */
    public function created(Airport $airport): void
    {
        Cache::tags(AirportCacheKeys::AIRPORT_TAG)->flush();
    }

    /**
     * Handle the Airport "updated" event.
     *
     * @param Airport $airport
     *
     * @return void
     */
    public function updated(Airport $airport): void
    {
        Cache::tags(AirportCacheKeys::AIRPORT_TAG)->flush();
    }
}
