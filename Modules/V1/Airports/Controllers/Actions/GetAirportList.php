<?php

namespace Modules\V1\Airports\Controllers\Actions;

use App\Http\Actions\Action;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Modules\V1\Airports\Models\Airport;
use Modules\V1\Airports\Resources\AirportResource;
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

        $baseQuery = Airport::query();

        if ($airportName !== null) {
            $baseQuery->whereHas('airportDetails', function ($query) use ($airportName) {
                $query->whereFullText(['name'], $airportName);
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

        $airports = $baseQuery->limit(self::LIMIT)->get();

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
}
