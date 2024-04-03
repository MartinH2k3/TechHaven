<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('owner_id')->nullable();
            $table->enum('status', ['pending', 'paid', 'complete', 'canceled']);
            $table->integer('total_price');
            $table->enum('delivery_method', ['SPS', 'DPD']);
            $table->uuid('delivery_information_id'); // Consider a JSON column or a related table
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users');
            $table->foreign('delivery_information_id')->references('id')->on('delivery_information');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
