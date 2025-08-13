<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // إضافة حقول تحقق تسجيل الدخول
            $table->string('login_verification_code')->nullable()->after('verification_code_expires_at');
            $table->timestamp('login_code_expires_at')->nullable()->after('login_verification_code');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['login_verification_code', 'login_code_expires_at']);
        });
    }
};