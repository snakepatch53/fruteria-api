<?php

namespace Database\Seeders;

use App\Models\ComboSale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComboSaleSeeder extends Seeder
{

    public function run()
    {
        ComboSale::factory()
            ->count(3)
            ->create();
    }
}
