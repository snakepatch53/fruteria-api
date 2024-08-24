<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CustomerSeeder::class,
            SaleSeeder::class,
            ProductSeeder::class,
            ProductSaleSeeder::class,
            ComboSeeder::class,
            ComboProductSeeder::class,
            ComboSaleSeeder::class,
        ]);
    }
}
