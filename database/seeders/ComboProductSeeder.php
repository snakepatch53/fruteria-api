<?php

namespace Database\Seeders;

use App\Models\ComboProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComboProductSeeder extends Seeder
{

    public function run()
    {
        ComboProduct::factory()
            ->count(3)
            ->create();
    }
}
