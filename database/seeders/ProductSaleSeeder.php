<?php

namespace Database\Seeders;

use App\Models\ProductSale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSaleSeeder extends Seeder
{

    public function run()
    {
        ProductSale::factory()
            ->count(3)
            ->create();
    }
}
