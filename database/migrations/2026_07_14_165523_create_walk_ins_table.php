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
        Schema::create('walk_ins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('destination_id');
            $table->string('name');
            $table->integer('age');
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->string('classification'); // Local, Domestic Tourist, International Tourist
            $table->unsignedBigInteger('registered_by_staff_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('destination_id')->references('id')->on('destinations')->onDelete('cascade');
            $table->foreign('registered_by_staff_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('walk_ins');
    }
};
