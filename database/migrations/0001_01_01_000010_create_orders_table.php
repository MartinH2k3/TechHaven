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
            $table->string('first_name', 64);
            $table->string('last_name', 64);
            $table->string('street_address', 100);
            $table->string('street_number', 15);
            $table->string('postal_code', 15);
            $table->string('city', 40);
            $table->string('phone_number', 15);
            $table->string('email', 320);
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
