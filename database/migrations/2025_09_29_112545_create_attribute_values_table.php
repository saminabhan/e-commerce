<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_id')->constrained('product_attributes')->onDelete('cascade');
            $table->string('value'); // Red, 128GB, XL
            $table->string('color_code')->nullable(); // #FF0000 (للألوان فقط)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('attribute_values');
    }
};
