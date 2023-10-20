<?php

namespace Database\Factories\Modules\V1\Airports\Models;

use Illuminate\Support\Str;
use Modules\V1\Airports\Models\Airport;
use Modules\V1\Languages\Enums\LanguageEnum;
use Modules\V1\Airports\Models\AirportDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AirportDetail>
 */
class AirportDetailFactory extends Factory
{
    protected $model = AirportDetail::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'airport_id' => Airport::factory(),
            'language' => $this->faker->randomElement(LanguageEnum::list()),
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'terms_and_conditions' => $this->faker->paragraph,
        ];
    }
}
