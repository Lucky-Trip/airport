<?php

namespace App\Http\Controllers;

use App\Http\Actions\Action;
use App\Http\Responses\StatusCode;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    protected function handleAction(Action $action): JsonResponse
    {
        if (!$action->validate()) {
            return new JsonResponse(
                array_filter([
                    'errors' => $action->getValidationErrors(),
                ]),
                StatusCode::UNPROCESSABLE_ENTITY->value
            );
        }

        return $action->execute();
    }
}
