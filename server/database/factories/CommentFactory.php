<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Phone;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customerId' => Customer::inRandomOrder()->first()->id,
            'phoneId' => Phone::inRandomOrder()->first()->id ,
            'content' => $this->faker->paragraph(),
            'like' => 2,
            'dislike' => 1,
        ];
    }
}
