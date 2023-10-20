<?php

namespace Modules\V1\Airports\Resources;

use Illuminate\Http\Request;
use Modules\V1\Airports\Models\Airport;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Airport
 */
class AirportResource extends JsonResource
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
            'airport_id' => $this->airport_id,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'iata' => $this->iata_code,
            'details' => new AirportDetailsResource($this->airportDetails->first())
        ];
    }
}
