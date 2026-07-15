<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->ensureIndex('bookings', 'bookings_destination_visit_status_index', ['destination_id', 'visit_date', 'status']);
        $this->ensureIndex('bookings', 'bookings_status_visit_created_index', ['status', 'visit_date', 'created_at']);
        $this->ensureIndex('bookings', 'bookings_tourist_status_index', ['tourist_id', 'status']);

        $this->ensureIndex('users', 'users_role_assigned_destination_index', ['role', 'assigned_destination_id']);

        $checkInColumn = Schema::hasColumn('check_ins', 'arrival_time') ? 'arrival_time' : 'checked_in_at';
        $this->ensureIndex('check_ins', 'check_ins_booking_arrival_index', ['booking_id', $checkInColumn]);
        $this->ensureIndex('check_ins', 'check_ins_arrival_time_index', [$checkInColumn]);

        $walkInColumn = Schema::hasColumn('walk_ins', 'visit_date') ? 'visit_date' : 'created_at';
        $this->ensureIndex('walk_ins', 'walk_ins_destination_visit_date_index', ['destination_id', $walkInColumn]);
        $this->ensureIndex('walk_ins', 'walk_ins_staff_created_index', ['registered_by_staff_id', 'created_at']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex('bookings_destination_visit_status_index');
            $table->dropIndex('bookings_status_visit_created_index');
            $table->dropIndex('bookings_tourist_status_index');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_role_assigned_destination_index');
        });

        Schema::table('check_ins', function (Blueprint $table) {
            $table->dropIndex('check_ins_booking_arrival_index');
            $table->dropIndex('check_ins_arrival_time_index');
        });

        Schema::table('walk_ins', function (Blueprint $table) {
            $table->dropIndex('walk_ins_destination_visit_date_index');
            $table->dropIndex('walk_ins_staff_created_index');
        });
    }

    protected function ensureIndex(string $table, string $indexName, array $columns): void
    {
        $existingIndexes = collect(DB::select("SHOW INDEX FROM `{$table}`"))->pluck('Key_name')->toArray();

        if (in_array($indexName, $existingIndexes, true)) {
            return;
        }

        Schema::table($table, function (Blueprint $table) use ($columns, $indexName): void {
            $table->index($columns, $indexName);
        });
    }
};
