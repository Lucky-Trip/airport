<?php

namespace Modules\V1\Airports\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\V1\Airports\Controllers\Actions\GetAirportList;
use Modules\V1\Airports\Controllers\Actions\CreateAnAirport;

class AirportsController extends Controller
{
    /**
     * @param GetAirportList $action
     *
     * @return JsonResponse
     */
    public function index(GetAirportList $action): JsonResponse
    {
        return $this->handleAction($action);
    }
    /**
     * @param CreateAnAirport $action
     *
     * @return JsonResponse
     */
    public function store(CreateAnAirport $action): JsonResponse
    {
        return $this->handleAction($action);
    }
}
