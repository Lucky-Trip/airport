<?php

namespace Modules\V1\Airports\Controllers\Actions;

use Exception;
use Illuminate\Support\Str;
use App\Http\Actions\Action;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Responses\StatusCode;
use Illuminate\Support\Facades\Log;
use Modules\V1\Airports\Models\Airport;
use Modules\V1\Airports\Resources\AirportResource;

class CreateAnAirport extends Action
{
    public function execute(): JsonResponse
    {
        $inputs = $this->validator->validated();
        $language = app()->getLocale();

        DB::beginTransaction();
        try {
            /** @var ?Airport $airport */
            $airport = $this->getAirportIfAlreadyRegistered($inputs['airport_id']);
            if ($airport == null) {
                $airport = Airport::create([
                    'id' => Str::uuid()->toString(),
                    'airport_id' => $inputs['airport_id'],
                    'latitude' => $inputs['latitude'],
                    'longitude' => $inputs['longitude'],
                    'iata_code' => $inputs['iata_code'],
                ]);
            }

            $details = $airport->airportDetails()->where('language', $language)->first();

            if ($details == null) {
                $airport->airportDetails()->create([
                    'name' => $inputs['name'],
                    'description' => $inputs['description'],
                    'language' => $language,
                    'terms_and_conditions' => $inputs['terms_and_conditions'],
                ]);
            }
            DB::commit();
        } catch (Exception $ex) {
            dd($ex->getMessage());
            DB::rollBack();

            Log::error(sprintf('Cannot create Airport due to: %s', $ex->getMessage()));
            return $this->clientErrorResponse(__('airports.create_airport_failed'), StatusCode::INTERNAL_SERVER_ERROR);
        }

        $airport->load(['airportDetails' => function ($query) use ($airport, $language) {
            return $query->where('airport_id', $airport->id)->where('language', $language);
        }]);

        return $this->resourceResponse(new AirportResource($airport));
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'airport_id' => [
                'required',
                'integer',
            ],
            'name' => [
                'required',
                'string',
                'min:3',
                'max:60',
            ],
            'latitude' => [
                'required',
                'integer',
                'between:-90,90',
            ],
            'longitude' => [
                'required',
                'integer',
                'between:-180,180',
            ],
            'iata_code' => [
                'required',
                'string',
                'min:3',
                'max:3',
            ],
            'description' => [
                'required',
                'string',
                'max:500',
            ],
            'terms_and_conditions' => [
                'sometimes',
                'string',
                'max:500',
            ],
        ];
    }

    /**
     * @param int $airportId
     *
     * @return Airport|null
     */
    private function getAirportIfAlreadyRegistered(int $airportId): ?Airport
    {
        return Airport::query()->where('airport_id', $airportId)->first();
    }
}
