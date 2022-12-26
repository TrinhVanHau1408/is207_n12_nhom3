<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'userName' => $this->faker->userName(),
            'password' => $this->faker->password(),
            'imgUrl' => 'https://phunugioi.com/wp-content/uploads/2020/01/anh-avatar-supreme-dep-lam-dai-dien-facebook.jpg',
            'name' => $this->faker->name(),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'phoneNumber' => $this->faker->phoneNumber(),
            'email' => $this->faker->safeEmail(),
            'status' => $this->faker->randomElement(['Hoạt động', 'ngừng hoạt động']),
            'address'=> $this->faker->address(),
        ];
    }
}
