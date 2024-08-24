<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;


class SaleFactory extends Factory
{

    public function definition()
    {
        return [
            'customer_id' => Customer::factory(),
            'total' => $this->faker->randomFloat(2, 1, 100)
        ];
    }
}
