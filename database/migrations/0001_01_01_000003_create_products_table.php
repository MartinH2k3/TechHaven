<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('image_id_long'); // Adjust this as needed for your image storage strategy
            $table->string('product_name', 62);
            $table->text('product_description');
            $table->string('operating_system', 40);
            $table->string('category', 40);
            $table->integer('ram');
            $table->integer('display_size');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
