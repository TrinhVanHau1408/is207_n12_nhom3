<?php

namespace Database\Seeders;

use App\Models\PhoneDetail;
use Illuminate\Database\Seeder;

class PhoneDetailSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PhoneDetail::factory()->count(20)->create();
    }
}
