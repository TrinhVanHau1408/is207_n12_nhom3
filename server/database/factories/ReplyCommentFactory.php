<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReplyCommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'commentId' => Comment::inRandomOrder()->first()->id,
            'customerId' => Customer::inRandomOrder()->first()->id,
            'content' =>  $this->faker->paragraph(),
            'like' => 3,
            'dislike' => 2,
        ];
    }
}
