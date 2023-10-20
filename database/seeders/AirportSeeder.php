<?php

namespace Database\Seeders;

use Modules\V1\Airports\Models\Airport;
use Illuminate\Database\Seeder;

class AirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Airport::factory(50)->create();
    }
}
