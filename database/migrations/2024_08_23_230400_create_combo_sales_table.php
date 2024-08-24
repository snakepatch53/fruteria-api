<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('combo_sales', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('quantity');
            $table->decimal('price', 10, 2);

            $table->foreignId('combo_id')->constrained('combos');
            $table->foreignId('sale_id')->constrained('sales');
        });
    }

    public function down()
    {
        Schema::dropIfExists('combo_sales');
    }
};
