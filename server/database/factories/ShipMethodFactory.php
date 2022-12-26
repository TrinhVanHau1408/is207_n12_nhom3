<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShipMethodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->numerify('Ship-####'),
            'feePrice' => $this->faker->randomElement([5000, 10000, 15000]) ,
            'deliveryTime' => $this->faker->date(now()),
        ];
    }
}
