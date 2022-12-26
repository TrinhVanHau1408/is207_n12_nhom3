<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressReceiveFactory extends Factory
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
            'nameReceiver' => $this->faker->randomElement(["nguoi 1", "nguoi 2", "nguoi 3"]),
            'numberPhoneReceiver' => '001234343',
            'addressReceiver' => 'Địa chỉ demo',
            'numberApartment' => '1223',
            'defaultAddress' => 0,
        ];
    }
}
