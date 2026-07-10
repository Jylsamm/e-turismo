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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tourist_id');
            $table->unsignedBigInteger('destination_id');
            $table->date('visit_date');
            $table->string('status')->default('pending'); // pending, confirmed, declined, completed
            $table->text('decline_reason')->nullable();
            $table->unsignedBigInteger('decided_by_staff_id')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('tourist_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('destination_id')->references('id')->on('destinations')->onDelete('cascade');
            $table->foreign('decided_by_staff_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
