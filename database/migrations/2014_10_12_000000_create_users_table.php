<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
           $table->id();
           $table->string('name',100)->nullable();
           $table->string('email',100)->unique();
           $table->string('password',100);
           $table->dateTime('email_verified_at')->nullable();
           $table->rememberToken();
           $table->enum('status',['pending','active','inactive'])->nullable()->default('pending');
           $table->enum('level',['store','admin','user'])->default('user')->nullable();
           $table->string('store_name')->nullable();
           $table->string('phone')->nullable();
           $table->string('address')->nullable();
           $table->timestamps();

        });

        Schema::table('users',function(Blueprint $table){
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
