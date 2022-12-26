<?php

namespace Database\Seeders;

use App\Models\ReplyComment;
use Illuminate\Database\Seeder;

class ReplyCommentSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReplyComment::factory()->count(10)->create();
    }
}
