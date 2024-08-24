<?php

namespace Database\Seeders;

use App\Models\Combo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComboSeeder extends Seeder
{

    public function run()
    {
        Combo::factory()
            ->count(3)
            ->create();
    }
}
