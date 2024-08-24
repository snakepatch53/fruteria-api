<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class ComboFactory extends Factory
{

    public function definition()
    {
        return [
            "name" => $this->faker->name(),
            "price" => $this->faker->randomFloat(2, 1, 100),
        ];
    }
}
