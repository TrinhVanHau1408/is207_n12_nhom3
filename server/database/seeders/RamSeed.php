<?php

namespace Database\Seeders;

use App\Models\Ram;
use Illuminate\Database\Seeder;

class RamSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ram::factory()->count(4)->create();
    }
}
