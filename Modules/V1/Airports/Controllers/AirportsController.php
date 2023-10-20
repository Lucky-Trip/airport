<?php

namespace Modules\V1\Airports\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\V1\Airports\Controllers\Actions\GetAirport;
use Modules\V1\Airports\Controllers\Actions\GetAirportList;
use Modules\V1\Airports\Controllers\Actions\CreateAnAirport;
use Modules\V1\Airports\Controllers\Actions\UpdateAnAirport;
use Modules\V1\Airports\Controllers\Actions\DeleteAnAirport;

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
     * @param GetAirport $action
     *
     * @return JsonResponse
     */
    public function show(GetAirport $action): JsonResponse
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

    /**
     * @param UpdateAnAirport $action
     *
     * @return JsonResponse
     */
    public function update(UpdateAnAirport $action): JsonResponse
    {
        return $this->handleAction($action);
    }

    /**
     * @param DeleteAnAirport $action
     *
     * @return JsonResponse
     */
    public function destroy(DeleteAnAirport $action): JsonResponse
    {
        return $this->handleAction($action);
    }
}
