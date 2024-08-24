<?php

namespace Database\Factories;

use App\Models\Combo;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;


class ComboSaleFactory extends Factory
{

    public function definition()
    {
        return [
            'quantity' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'combo_id' => Combo::factory(),
            'sale_id' => Sale::factory(),
        ];
    }
}
