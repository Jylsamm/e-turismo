<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add precise check-in coordinates to the destinations (spots) table.
     *
     * decimal(10, 6) gives 6 decimal places (~0.1 m accuracy) and fits the
     * full lat/lng range: ±90 for latitude, ±180 for longitude.
     */
    public function up(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->decimal('checkin_latitude',  10, 6)->nullable()->after('availability_status');
            $table->decimal('checkin_longitude', 10, 6)->nullable()->after('checkin_latitude');
        });
    }

    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn(['checkin_latitude', 'checkin_longitude']);
        });
    }
};
