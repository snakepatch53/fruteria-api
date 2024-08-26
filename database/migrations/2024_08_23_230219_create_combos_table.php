<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('combos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->boolean('active')->default(true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('combos');
    }
};
