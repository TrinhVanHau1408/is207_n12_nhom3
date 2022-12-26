<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(['1GB','2GB', '4GB', '5GB','6GB', '8GB']),
        ];
    }
}
