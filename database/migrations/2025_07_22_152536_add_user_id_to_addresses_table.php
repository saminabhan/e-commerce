<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('addresses', function (Blueprint $table) {
        $table->unsignedBigInteger('user_id')->after('id')->nullable()->index();
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('addresses', function (Blueprint $table) {
        $table->dropColumn('user_id');
    });
}
};
