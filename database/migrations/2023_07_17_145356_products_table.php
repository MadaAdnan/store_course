<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('info')->nullable();
            $table->boolean('is_active')->default(true)->nullable();
            $table->double('quantity')->default(0)->nullable();
            $table->double('price');
            $table->boolean('is_discount')->nullable()->default(false);
            $table->double('discount')->nullable()->default(0);
            $table->string('qr')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
