<?php

namespace Database\Seeders;

use App\Models\AddressReceive;
use Illuminate\Database\Seeder;

class AddressReceiveSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AddressReceive::factory()->count(20)->create();
    }
}
