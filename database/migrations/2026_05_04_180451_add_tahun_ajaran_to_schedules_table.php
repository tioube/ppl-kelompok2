<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->foreignId('tahun_ajaran_id')
                ->after('guru_id')
                ->constrained('tahun_ajaran')
                ->onDelete('cascade');

            $table->unique(
                ['kelas_id', 'time_slot_id', 'tahun_ajaran_id'],
                'unique_kelas_slot_tahun'
            );
        });
    }

    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropUnique('unique_kelas_slot_tahun');
            $table->dropForeign(['tahun_ajaran_id']);
            $table->dropColumn('tahun_ajaran_id');
        });
    }
};
