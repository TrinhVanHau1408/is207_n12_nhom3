<?php

namespace Database\Factories;

use App\Models\AddressReceive;
use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\ShipMethod;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
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
            'orderCode' => $this->faker->unique()->numerify('MK-####'),
            'paymentId' => PaymentMethod::inRandomOrder()->first()->id,
            'shipId' => ShipMethod::inRandomOrder()->first()->id,
            'addressReceiveId' => AddressReceive::inRandomOrder()->first()->id,
            'statusId' => Status::inRandomOrder()->first()->id,
            'noteMess' => $this->faker->paragraph() ,
        ];
    }
}
