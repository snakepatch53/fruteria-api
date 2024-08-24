<?php

namespace Database\Factories;

use App\Models\Combo;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;


class ComboProductFactory extends Factory
{

    public function definition()
    {
        return [
            'price' => $this->faker->randomFloat(2, 1, 100),
            'quantity' => $this->faker->numberBetween(1, 5),
            'combo_id' => Combo::factory(),
            'product_id' => Product::factory(),
        ];
    }
}
