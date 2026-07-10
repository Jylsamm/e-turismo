<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add each column only if it doesn't already exist
            if (!Schema::hasColumn('users', 'contact')) {
                $table->string('contact')->nullable()->after('role');
            }
            if (!Schema::hasColumn('users', 'last_name')) {
                $table->string('last_name')->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'middle_initial')) {
                $table->string('middle_initial', 10)->nullable()->after('last_name');
            }
            if (!Schema::hasColumn('users', 'dob')) {
                $table->date('dob')->nullable()->after('middle_initial');
            }
            if (!Schema::hasColumn('users', 'classification')) {
                $table->string('classification')->nullable()->after('contact');
            }
            if (!Schema::hasColumn('users', 'id_type')) {
                $table->string('id_type')->nullable();
            }
            if (!Schema::hasColumn('users', 'id_number')) {
                $table->string('id_number')->nullable();
            }
            if (!Schema::hasColumn('users', 'id_photo')) {
                $table->string('id_photo')->nullable();
            }
            if (!Schema::hasColumn('users', 'assigned_destination_id')) {
                $table->unsignedBigInteger('assigned_destination_id')->nullable();
            }
            if (!Schema::hasColumn('users', 'id_verification_status')) {
                $table->string('id_verification_status')->nullable()->default('unverified');
            }
            if (!Schema::hasColumn('users', 'id_verification_score')) {
                $table->decimal('id_verification_score', 5, 2)->nullable();
            }
            if (!Schema::hasColumn('users', 'id_verification_notes')) {
                $table->text('id_verification_notes')->nullable();
            }
            if (!Schema::hasColumn('users', 'id_verified_at')) {
                $table->timestamp('id_verified_at')->nullable();
            }
            if (!Schema::hasColumn('users', 'ready_to_complete_requirements')) {
                $table->boolean('ready_to_complete_requirements')->default(false);
            }
            if (!Schema::hasColumn('users', 'is_manually_verified')) {
                $table->boolean('is_manually_verified')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(array_filter([
                Schema::hasColumn('users', 'contact')                        ? 'contact' : null,
                Schema::hasColumn('users', 'last_name')                      ? 'last_name' : null,
                Schema::hasColumn('users', 'middle_initial')                 ? 'middle_initial' : null,
                Schema::hasColumn('users', 'dob')                            ? 'dob' : null,
                Schema::hasColumn('users', 'classification')                 ? 'classification' : null,
                Schema::hasColumn('users', 'id_type')                        ? 'id_type' : null,
                Schema::hasColumn('users', 'id_number')                      ? 'id_number' : null,
                Schema::hasColumn('users', 'id_photo')                       ? 'id_photo' : null,
                Schema::hasColumn('users', 'assigned_destination_id')        ? 'assigned_destination_id' : null,
                Schema::hasColumn('users', 'id_verification_status')         ? 'id_verification_status' : null,
                Schema::hasColumn('users', 'id_verification_score')          ? 'id_verification_score' : null,
                Schema::hasColumn('users', 'id_verification_notes')          ? 'id_verification_notes' : null,
                Schema::hasColumn('users', 'id_verified_at')                 ? 'id_verified_at' : null,
                Schema::hasColumn('users', 'ready_to_complete_requirements') ? 'ready_to_complete_requirements' : null,
                Schema::hasColumn('users', 'is_manually_verified')           ? 'is_manually_verified' : null,
            ]));
        });
    }
};
