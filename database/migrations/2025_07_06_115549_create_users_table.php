<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255); // تم تحديد الطول الأقصى للاسم
            $table->string('phone', 50)->unique(); // تم تحديد الطول الأقصى لرقم الهاتف
            $table->string('password'); // الطول الافتراضي كافٍ للباسورد المشفر (عادة 255)
            $table->enum('role', ['admin', 'customer'])->default('customer');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('users');
    }
};