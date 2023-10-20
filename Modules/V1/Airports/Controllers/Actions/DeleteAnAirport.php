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

class DeleteAnAirport extends Action
{
    public function execute(): JsonResponse
    {
        $airportId = $this->request->route('airport');

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
            $airport->airportDetails()->delete();
            $airport->delete();

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();

            Log::error(sprintf('Cannot delete Airport due to: %s', $ex->getMessage()));
            return $this->clientErrorResponse(__('airports.delete_airport_failed'), StatusCode::INTERNAL_SERVER_ERROR);
        }

        return $this->messageResponse(__('airports.deleted_successfully'));
    }
}
