<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->decimal('total', 10, 2);

            $table->foreignId('customer_id')->constrained('customers');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales');
    }
};
