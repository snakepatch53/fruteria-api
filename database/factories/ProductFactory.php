<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'description' => $this->faker->text(30),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'image' => $this->faker->randomElement(['1.png', '2.png', '3.png', '4.png', '5.png', '6.png', '7.png', '8.png', '9.png', '10.png']),
            'category' => Product::$_CATEGORY[array_rand(Product::$_CATEGORY)],
            'sale_type' => Product::$_SALE_TYPE[array_rand(Product::$_SALE_TYPE)],
            'offer' => $this->faker->boolean,
            'active' => $this->faker->boolean
        ];
    }
}
