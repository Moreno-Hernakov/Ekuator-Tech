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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary()->nullable(false);
            $table->foreignUuid('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreignUuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('price');
            $table->integer('quantity');
            $table->integer('admin_fee');
            $table->integer('tax');
            $table->integer('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
