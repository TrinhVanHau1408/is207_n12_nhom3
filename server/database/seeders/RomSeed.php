<?php

namespace Database\Seeders;

use App\Models\Rom;
use Illuminate\Database\Seeder;

class RomSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rom::factory()->count(4)->create();
    }
}
