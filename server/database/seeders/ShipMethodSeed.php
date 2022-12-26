<?php

namespace Database\Seeders;

use App\Models\ShipMethod;
use Illuminate\Database\Seeder;

class ShipMethodSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShipMethod::factory()->count(3)->create();
    }
}
