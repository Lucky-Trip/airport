<?php

namespace Modules\V1\Airports\Controllers\Actions;

use App\Http\Actions\Action;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Modules\V1\Airports\Models\Airport;
use Modules\V1\Airports\Resources\AirportResource;
use Modules\V1\Airports\Models\Constants\AirportCacheKeys;
use Modules\V1\Airports\Models\Constants\DistanceConstants;

class GetAirport extends Action
{
    public function execute(): JsonResponse
    {
        $airportId = $this->request->route('airport');
        $language = app()->getLocale();

        $airport = Cache::tags(AirportCacheKeys::AIRPORT_TAG)->remember(
            sprintf(AirportCacheKeys::SINGLE_AIRPORT_CACHE_KEY . "_id_%s_lang_%s", $airportId, $language),
            AirportCacheKeys::AIRPORT_CACHE_TTL,
            function () use ($airportId, $language) {
                return Airport::query()->with([
                    'airportDetails' => function ($details) use ($language) {
                        return $details->where('language', $language)->first();
                    }
                ])->where('id', $airportId)->first();
            }
        );

        if ($airport == null || $airport->airportDetails->count() == 0) {
            return $this->dataResponse([], __('airports.not_found'));
        }

        return $this->resourceResponse(new AirportResource($airport));
    }
}
