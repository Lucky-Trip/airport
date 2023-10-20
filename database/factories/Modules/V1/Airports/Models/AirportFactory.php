<?php

namespace Database\Factories\Modules\V1\Airports\Models;

use Illuminate\Support\Str;
use Modules\V1\Airports\Models\Airport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Airport>
 */
class AirportFactory extends Factory
{
    protected $model = Airport::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'airport_id' => $this->faker->unique()->numberBetween(1, 1000),
            'iata_code' => $this->faker->unique()->regexify('[A-Z]{3}'),
            'latitude' => $this->faker->randomFloat(6, -90, 90),
            'longitude' => $this->faker->randomFloat(6, -180, 180),
        ];
    }
}
