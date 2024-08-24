<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{

    public function definition()
    {
        return [
            'cedula' => $this->faker->unique()->numberBetween(1000000000, 9999999999),
            "name" => $this->faker->name()
        ];
    }
}
