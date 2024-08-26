<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('combo_products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('quantity');
            $table->decimal('price', 10, 2);

            $table->foreignId('combo_id')->constrained('combos')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products');
        });
    }

    public function down()
    {
        Schema::dropIfExists('combo_products');
    }
};
