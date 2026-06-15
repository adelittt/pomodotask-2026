<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('challenges', 'duration_value')) {
            Schema::table('challenges', function (Blueprint $table) {
                $table->integer('duration_value')->default(1)->after('target_hours');
                $table->enum('duration_unit', ['days', 'weeks', 'months'])->default('weeks')->after('duration_value');
            });
        }
    }

    public function down(): void
    {
        Schema::table('challenges', function (Blueprint $table) {
            $table->dropColumn(['duration_value', 'duration_unit']);
        });
    }
};