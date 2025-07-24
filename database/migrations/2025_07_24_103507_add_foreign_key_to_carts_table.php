<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            // إضافة foreign key constraint
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade'); // (اختياري) حذف تلقائي إذا تم حذف المنتج
        });
    }

    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            // حذف foreign key constraint عند التراجع (rollback)
            $table->dropForeign(['product_id']);
        });
    }
};
