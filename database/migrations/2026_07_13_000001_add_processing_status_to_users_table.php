<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Allow 'processing' as a valid id_verification_status value.
     *
     * The original migration created this as ENUM('unverified','pending','verified','rejected').
     * A later idempotent migration may have created it as VARCHAR. This migration handles both
     * cases safely: if it's an ENUM, we alter it to add 'processing'; if it's already a string/
     * VARCHAR, the ALTER is a no-op in terms of data, and we just confirm the column allows it.
     */
    public function up(): void
    {
        // Re-define column as a plain VARCHAR so 'processing' is always storable
        // regardless of whether the current column is ENUM or VARCHAR.
        // This is safe for MySQL/MariaDB on XAMPP — existing data is preserved.
        Schema::table('users', function (Blueprint $table) {
            $table->string('id_verification_status', 20)
                  ->default('unverified')
                  ->change();
        });

        // Ensure any existing ENUM constraint is lifted by running raw ALTER on MySQL
        // (Schema::change() on ENUM may not fully lift the constraint on older Laravel/Doctrine versions)
        try {
            $driver = DB::connection()->getDriverName();
            if ($driver === 'mysql') {
                DB::statement("
                    ALTER TABLE users
                    MODIFY COLUMN id_verification_status
                    VARCHAR(20) NOT NULL DEFAULT 'unverified'
                ");
            }
        } catch (\Throwable $e) {
            // Non-fatal — column already accepts the values we need
        }
    }

    public function down(): void
    {
        // Restore the original ENUM (without 'processing')
        try {
            $driver = DB::connection()->getDriverName();
            if ($driver === 'mysql') {
                DB::statement("
                    ALTER TABLE users
                    MODIFY COLUMN id_verification_status
                    ENUM('unverified','pending','verified','rejected') NOT NULL DEFAULT 'unverified'
                ");
            }
        } catch (\Throwable $e) {
            // Non-fatal if rows contain 'processing' — admin must resolve manually
        }
    }
};
