<?php

namespace Database\Seeders;

use Modules\V1\Airports\Models\AirportDetail;
use Illuminate\Database\Seeder;

class AirportDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AirportDetail::factory(50)->create();
    }
}
