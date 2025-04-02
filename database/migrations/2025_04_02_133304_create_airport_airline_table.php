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
        Schema::create('airport_airline', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('airport_id');
            $table->unsignedBigInteger('airline_id');
            $table->foreign('airport_id')->references('id')->on('airports')->onDelete('cascade');
            $table->foreign('airline_id')->references('id')->on('airlines')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airport_airline');
    }
};
