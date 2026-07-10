<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name')->nullable()->after('name');
            $table->string('middle_initial', 10)->nullable()->after('last_name');
            $table->enum('id_verification_status', ['unverified', 'pending', 'verified', 'rejected'])
                  ->default('unverified')->after('id_photo');
            $table->decimal('id_verification_score', 5, 2)->nullable()->after('id_verification_status');
            $table->text('id_verification_notes')->nullable()->after('id_verification_score');
            $table->timestamp('id_verified_at')->nullable()->after('id_verification_notes');
        });

        // Pre-verify admin and staff accounts so they can always log in freely
        DB::table('users')
            ->whereIn('role', ['admin', 'staff'])
            ->update([
                'id_verification_status' => 'verified',
                'id_verification_score'  => 100.00,
                'id_verified_at'         => now(),
            ]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'last_name',
                'middle_initial',
                'id_verification_status',
                'id_verification_score',
                'id_verification_notes',
                'id_verified_at',
            ]);
        });
    }
};
