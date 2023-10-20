<?php

namespace App\Http\Actions;

use App\Http\Responses\PaginationResponse;
use App\Http\Responses\StatusCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidatorObject;

abstract class Action
{
    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var array<string, mixed>
     */
    protected array $validationErrors = [];

    /**
     * @var ValidatorObject
     */
    protected ValidatorObject $validator;

    /**
     * @var int
     */
    protected int $per_page;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->per_page = $request->per_page ?? 15;
    }

    final public function validate(): bool
    {
        $route = $this->request->route();
        if (null !== $route) {
            $this->request->merge($route->parameters());
        }

        $this->validator = Validator::make(
            $this->request->all(),
            $this->rules()
        );

        $paginationValidator = Validator::make(
            $this->request->all(),
            [
                'paginated' => 'boolean',
                'per_page' => 'integer|min:1',
            ]
        );

        if ($this->validator->passes() && $paginationValidator->passes()) {
            return true;
        }

        $this->validationErrors = array_merge(
            $this->validator->getMessageBag()->messages(),
            $paginationValidator->getMessageBag()->messages()
        );

        return false;
    }

    /**
     * @return JsonResponse
     */
    abstract public function execute(): JsonResponse;

    /**
     * @return array<string, string[]>
     */
    protected function rules(): array
    {
        return [];
    }

    /**
     * @return array<string, string[]>
     */
    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }

    /**
     * @param string     $message
     * @param StatusCode $statusCode
     *
     * @return JsonResponse
     */
    protected function messageResponse(string $message, StatusCode $statusCode = StatusCode::OK): JsonResponse
    {
        return new JsonResponse(
            [
                'message' => $message,
            ],
            $statusCode->value
        );
    }

    /**
     * @param string     $message
     * @param StatusCode $statusCode
     *
     * @return JsonResponse
     */
    protected function clientErrorResponse(
        string $message,
        StatusCode $statusCode = StatusCode::BAD_REQUEST
    ): JsonResponse {
        return new JsonResponse(
            [
                'message' => $message,
            ],
            $statusCode->value
        );
    }

    /**
     * @param JsonResource          $resource
     * @param ?string               $message
     * @param ?array<string, mixed> $meta
     * @param StatusCode            $statusCode
     *
     * @return JsonResponse
     */
    protected function resourceResponse(
        JsonResource $resource,
        string $message = null,
        ?array $meta = [],
        StatusCode $statusCode = StatusCode::OK
    ): JsonResponse {
        return new JsonResponse(
            array_filter([
                'message' => $message,
                'data' => $resource,
                'meta' => array_filter((array) $meta),
            ]),
            $statusCode->value
        );
    }

    /**
     * @param AnonymousResourceCollection $collection
     * @param ?array<string, mixed>       $meta
     * @param StatusCode                  $statusCode
     * @param bool                        $paginated
     * @param ?int                        $page
     * @param ?int                        $perPage
     *
     * @return JsonResponse
     */
    protected function resourceCollectionResponse(
        AnonymousResourceCollection $collection,
        ?array $meta = [],
        StatusCode $statusCode = StatusCode::OK,
        bool $paginated = false,
        int $page = null,
        int $perPage = null,
    ): JsonResponse {
        $page = $page ?? $this->request->input('page', 1);
        $perPage = $perPage ?? $this->request->input('per_page', 15);

        if ($paginated || $this->request->input('paginated', false)) {
            return (new PaginationResponse(
                $collection->collection->forPage($page, $perPage),
                $collection->count(),
                $perPage,
                $page,
                (array) $meta,
                $statusCode
            ))->toJsonResponse();
        }

        return new JsonResponse(
            array_filter([
                'data' => $collection,
                'meta' => array_filter((array) $meta),
            ]),
            $statusCode->value,
        );
    }
}
