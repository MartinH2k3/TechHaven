<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shopping_cart_products', function (Blueprint $table) {
            $table->uuid('shopping_cart_id');
            $table->uuid('product_id');
            $table->integer('product_count');

            $table->foreign('shopping_cart_id')->references('id')->on('shopping_carts');
            $table->foreign('product_id')->references('id')->on('products');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shopping_cart_products');
    }
};
