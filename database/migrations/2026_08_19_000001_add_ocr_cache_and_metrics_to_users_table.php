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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'ocr_raw_text')) {
                $table->longText('ocr_raw_text')->nullable()->after('id_verification_notes');
            }
            if (!Schema::hasColumn('users', 'ocr_extracted_fields')) {
                $table->json('ocr_extracted_fields')->nullable()->after('ocr_raw_text');
            }
            if (!Schema::hasColumn('users', 'ocr_processing_ms')) {
                $table->integer('ocr_processing_ms')->nullable()->after('ocr_extracted_fields');
            }
            if (!Schema::hasColumn('users', 'ocr_image_hash')) {
                $table->string('ocr_image_hash', 64)->nullable()->index()->after('ocr_processing_ms');
            }
            if (!Schema::hasColumn('users', 'ocr_provider')) {
                $table->string('ocr_provider', 32)->nullable()->default('ocr.space')->after('ocr_image_hash');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'ocr_raw_text',
                'ocr_extracted_fields',
                'ocr_processing_ms',
                'ocr_image_hash',
                'ocr_provider',
            ]);
        });
    }
};
