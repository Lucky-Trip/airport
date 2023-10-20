<?php

namespace Modules\V1\Airports\Resources;

use Illuminate\Http\Request;
use Modules\V1\Airports\Models\Airport;
use Modules\V1\Airports\Models\AirportDetail;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin AirportDetail
 */
class AirportDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'language' => $this->language,
            'description' => $this->description,
            'terms_and_conditions' => $this->terms_and_conditions,
        ];
    }
}
