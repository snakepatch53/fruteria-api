<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_sales', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('quantity');
            $table->decimal('price', 10, 2);

            $table->foreignId('product_id')->constrained('products');
            $table->foreignId('sale_id')->constrained('sales');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_sales');
    }
};
