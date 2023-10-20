<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Enumerable;

class PaginationResponse
{
    /**
     * The last available page.
     *
     * @var int
     */
    protected int $lastPage;

    /**
     * @param Enumerable<int, mixed>|array<string, mixed> $items
     * @param int                                         $total
     * @param int                                         $perPage
     * @param int                                         $currentPage
     * @param array<string, mixed>                        $meta
     * @param StatusCode                                  $statusCode
     */
    public function __construct(
        protected Enumerable|array $items,
        protected int $total,
        protected int $perPage,
        protected int $currentPage = 1,
        protected array $meta = [],
        protected StatusCode $statusCode = StatusCode::OK
    ) {
        $this->lastPage = max((int) ceil($total / $perPage), 1);
    }

    /**
     * if you use Model->pagination(), $withPagination must be true for handel pagination.
     *
     * @param bool $withPagination
     *
     * @return JsonResponse
     */
    public function toJsonResponse(bool $withPagination = false): JsonResponse
    {
        if ($withPagination || is_array($this->items)) {
            $data = $this->items;
        } else {
            $data = request()->has('page') ? array_values($this->items->toArray()) : $this->items->toArray();
        }

        return new JsonResponse([
            'data' => $data,
            'meta' => array_merge($this->meta, [
                'pagination' => [
                    'total_items' => $this->total,
                    'total_pages' => $this->lastPage,
                    'current_page' => $this->currentPage,
                    'per_page' => $this->perPage,
                ],
            ]),
        ], $this->statusCode->value);
    }
}
