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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('generated_by_admin_id');
            $table->unsignedBigInteger('destination_id')->nullable(); // null = all destinations
            $table->enum('type', ['daily', 'weekly', 'monthly'])->default('monthly');
            $table->date('date_from');
            $table->date('date_to');
            $table->unsignedInteger('total_visitors')->default(0);
            $table->unsignedInteger('total_bookings')->default(0);
            $table->unsignedInteger('confirmed_bookings')->default(0);
            $table->unsignedInteger('declined_bookings')->default(0);
            $table->timestamps();

            $table->foreign('generated_by_admin_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('destination_id')->references('id')->on('destinations')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
