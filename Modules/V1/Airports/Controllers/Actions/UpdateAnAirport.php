<?php

namespace Modules\V1\Airports\Controllers\Actions;

use Exception;
use App\Http\Actions\Action;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Responses\StatusCode;
use Illuminate\Support\Facades\Log;
use Modules\V1\Airports\Models\Airport;
use Modules\V1\Airports\Resources\AirportResource;

class UpdateAnAirport extends Action
{
    public function execute(): JsonResponse
    {
        $inputs = $this->validator->validated();
        $airportId = $this->request->route('airport');
        $language = app()->getLocale();

        /** @var ?Airport $airport */
        $airport = Airport::query()
                          ->with('airportDetails')
                          ->where('id', $airportId)
                          ->first();

        if ($airport == null) {
            return $this->clientErrorResponse(__('airports.not_found'), StatusCode::NOT_FOUND);
        }

        DB::beginTransaction();

        try {
            $airport->update([
                'airport_id' => $inputs['airport_id'],
                'latitude' => $inputs['latitude'],
                'longitude' => $inputs['longitude'],
                'iata_code' => $inputs['iata_code'],
            ]);

            $detail = $airport->airportDetails()->where('language', $language)->first();

            if ($detail !== null) {
                $detail->update([
                    'name' => $inputs['name'],
                    'description' => $inputs['description'],
                    'language' => $language,
                    'terms_and_conditions' => $inputs['terms_and_conditions'],
                ]);
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();

            Log::error(sprintf('Cannot update Airport due to: %s', $ex->getMessage()));
            return $this->clientErrorResponse(__('airports.update_airport_failed'), StatusCode::INTERNAL_SERVER_ERROR);
        }

        $airport->refresh();
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
                'unique:airports,id,' . $this->request->input('airport_id')
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
}
