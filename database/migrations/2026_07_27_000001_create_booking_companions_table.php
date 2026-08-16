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
        Schema::create('booking_companions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->string('name');
            $table->integer('age');
            $table->string('gender');
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->string('classification');
            $table->integer('duration_days');
            $table->timestamps();

            // Foreign key referencing bookings table
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_companions');
    }
};
