<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->boolean('isShow')->default(true);
            $table->string('image');
            $table->json('colors')->nullable();
            $table->json('sizes')->nullable();
            $table->boolean('isOffred')->default(false);
            $table->decimal('offredPrice', 10, 2)->nullable();
            $table->date('startOffreDay')->nullable();
            $table->date('endOffreDay')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('products');
    }
};
