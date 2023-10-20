<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Modules\V1\Airports\Models\Airport;
use Modules\V1\Languages\Enums\LanguageEnum;
use Modules\V1\Airports\Models\AirportDetail;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Airport::factory(1000)->create()
            ->each(function ($airport) {
                AirportDetail::create([
                    'id' => Str::uuid()->toString(),
                    'airport_id' => $airport->id,
                    'language' => fake()->randomElement(LanguageEnum::list()),
                    'name' => fake()->word,
                    'description' => fake()->paragraph,
                    'terms_and_conditions' => fake()->paragraph,
                ]);
            });
    }
}
