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

class GetAirportList extends Action
{
    private const LIMIT = 5;
    public function execute(): JsonResponse
    {
        $airportName = $this->request->query('airport_name');

        $latitude = $this->request->query('latitude');
        $longitude = $this->request->query('longitude');
        $sort = $this->request->query('sort', 'asc');

        $cacheKey = $this->generateCacheKey($airportName, $latitude, $longitude, $sort);

        $airports = Cache::tags([AirportCacheKeys::AIRPORT_TAG])->remember(
            $cacheKey,
            AirportCacheKeys::AIRPORT_CACHE_TTL,
            function () use ($airportName, $latitude, $longitude, $sort) {
                $baseQuery = Airport::query();

                if ($airportName !== null) {
                    $baseQuery->whereHas('airportDetails', function ($query) use ($airportName) {
                        $query->where('name', 'like',"%$airportName%");
                    });
                }

                if ($latitude !== null && $longitude !== null) {
                    $baseQuery->whereRaw(
                        "
            (POW(latitude - ?, 2) + POW(longitude - ?, 2)) <= POW(?, 2)",
                        [$latitude, $longitude, DistanceConstants::MAXIMUM_RADIUS_IN_KM]
                    );
                }

                $baseQuery->orderByRaw(
                    "
        POW(latitude - ?, 2) + POW(longitude - ?, 2) $sort",
                    [$latitude, $longitude]
                );

                return $baseQuery->limit(self::LIMIT)->get();
            }
        );

        return $this->resourceCollectionResponse(AirportResource::collection($airports));
    }

    protected function rules(): array
    {
        return [
            'latitude' => [
                'sometimes',
                'integer',
                'between:-90,90',
            ],
            'longitude' => [
                'required_with:latitude',
                'integer',
                'between:-180,180',
            ],
            'sort'  => [
                'sometimes',
                Rule::in(['desc', 'asc']),
            ],
        ];
    }

    /**
     * @param string|null $airportName
     * @param string|null $latitude
     * @param string|null $longitude
     * @param string|null $sort
     *
     * @return string
     */
    private function generateCacheKey(
        ?string $airportName,
        ?string $latitude,
        ?string $longitude,
        ?string $sort
    ): string {
        $keys = [
            AirportCacheKeys::SINGLE_AIRPORT_CACHE_KEY
        ];

        if ($airportName !== null) {
            $keys[] = $airportName;
        }

        if ($latitude !== null) {
            $keys[] = $latitude;
        }

        if ($longitude !== null) {
            $keys[] = $longitude;
        }

        if ($sort !== null) {
            $keys[] = $sort;
        }

        return implode('_', $keys);
    }
}
