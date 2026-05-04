<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('silabus', function (Blueprint $table) {
            $table->foreignId('tahun_ajaran_id')
                ->after('mata_pelajaran_id')
                ->constrained('tahun_ajaran')
                ->onDelete('cascade');

            $table->index(
                ['mata_pelajaran_id', 'tahun_ajaran_id', 'status', 'approval_status'],
                'idx_silabus_mapel_tahun_status'
            );
        });
    }

    public function down(): void
    {
        Schema::table('silabus', function (Blueprint $table) {
            $table->dropIndex('idx_silabus_mapel_tahun_status');
            $table->dropForeign(['tahun_ajaran_id']);
            $table->dropColumn('tahun_ajaran_id');
        });
    }
};
