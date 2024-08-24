<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductSaleFactory extends Factory
{

    public function definition()
    {
        return [
            'quantity' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'product_id' => Product::factory(),
            'sale_id' => Sale::factory(),
        ];
    }
}
