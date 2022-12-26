<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(['4GB', '6GB', '8GB', '10GB', '12GB']),
        ];
    }
}
