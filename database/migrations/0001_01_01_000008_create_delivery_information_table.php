<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('delivery_information', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first_name', 64);
            $table->string('last_name', 64);
            $table->string('street_address', 100);
            $table->string('street_number', 15);
            $table->string('postal_code', 15);
            $table->string('city', 40);
            $table->string('phone_number', 15);
            $table->string('email', 320);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('delivery_information');
    }
};
