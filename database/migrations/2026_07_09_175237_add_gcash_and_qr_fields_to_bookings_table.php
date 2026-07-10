<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('gcash_reference_number')->nullable();
            $table->string('payment_screenshot_path')->nullable();
            $table->string('payment_status')->nullable(); // pending_verification, approved, rejected
            $table->text('rejection_reason')->nullable();
            $table->timestamp('payment_submitted_at')->nullable();
            $table->timestamp('payment_reviewed_at')->nullable();
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->string('qr_token')->unique()->nullable()->index();
            $table->timestamp('qr_generated_at')->nullable();
            $table->timestamp('checked_in_at')->nullable();
            $table->unsignedBigInteger('checked_in_by')->nullable();

            $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('checked_in_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['reviewed_by']);
            $table->dropForeign(['checked_in_by']);
            
            $table->dropColumn([
                'gcash_reference_number',
                'payment_screenshot_path',
                'payment_status',
                'rejection_reason',
                'payment_submitted_at',
                'payment_reviewed_at',
                'reviewed_by',
                'qr_token',
                'qr_generated_at',
                'checked_in_at',
                'checked_in_by'
            ]);
        });
    }
};
