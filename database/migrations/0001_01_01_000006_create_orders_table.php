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
            $table->text('delivery_information'); // Consider a JSON column or a related table
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
