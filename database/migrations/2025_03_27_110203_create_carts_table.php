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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resturant_id')->references('id')->on('resturants')->cascadeOnDelete();
            $table->integer('user_id')->nullable();
            $table->string('session_id');
            $table->integer('product_id');
            $table->integer('qty');
            $table->decimal('price','8','2');
            $table->string('size')->nullable();
            $table->decimal('total_price','8','2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
