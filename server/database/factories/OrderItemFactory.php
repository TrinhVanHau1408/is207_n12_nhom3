<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\PhoneDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'orderId' => Order::inRandomOrder()->first()->id,
            'phoneName' => 'Chưa có biết làm sao tự động hiện ra',
            'imgUrl' => 'https://cdn.tgdd.vn/Products/Images/42/213031/iphone-12-den-1-1-org.jpg',
            'phoneDetailId'=> PhoneDetail::inRandomOrder()->first()->id,
            'quantity' => $this->faker->randomElement([2, 3, 5]),
            'priceSale' => $this->faker->randomElement([2000000, 30000000, 50000000]),
            'totalMoney' => $this->faker->randomElement([2000000, 30000000, 50000000]) ,
        ];
    }
}
