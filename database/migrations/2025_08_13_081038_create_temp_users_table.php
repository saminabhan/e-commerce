<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('temp_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('mobile');
            $table->string('password');
            $table->string('verification_code');
            $table->timestamp('verification_code_expires_at');
            $table->timestamps();
            
            $table->unique('email');
            $table->unique('mobile');
        });
    }

    public function down()
    {
        Schema::dropIfExists('temp_users');
    }
};