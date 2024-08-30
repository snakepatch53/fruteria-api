<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->string('image');
            $table->enum('category', Product::$_CATEGORY);
            $table->enum('sale_type', Product::$_SALE_TYPE);
            $table->boolean('offer');
            $table->boolean('active');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
