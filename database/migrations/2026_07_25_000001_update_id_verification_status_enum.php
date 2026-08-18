<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Update any existing unverified, processing, or rejected user records to 'pending'
        DB::table('users')
            ->whereIn('id_verification_status', ['unverified', 'processing', 'rejected'])
            ->orWhereNull('id_verification_status')
            ->update(['id_verification_status' => 'pending']);

        // 2. Modify column definition to strictly allow 'pending' and 'verified'
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE users MODIFY COLUMN id_verification_status ENUM('pending', 'verified') NOT NULL DEFAULT 'pending'");
        }
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN id_verification_status ENUM('unverified', 'pending', 'verified', 'rejected', 'processing') NOT NULL DEFAULT 'unverified'");
    }
};
