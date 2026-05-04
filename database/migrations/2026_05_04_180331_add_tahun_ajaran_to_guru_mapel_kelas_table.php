<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guru_mapel_kelas', function (Blueprint $table) {
            $table->foreignId('tahun_ajaran_id')
                ->after('kelas_id')
                ->constrained('tahun_ajaran')
                ->onDelete('cascade');

            $table->unique(
                ['guru_id', 'mata_pelajaran_id', 'kelas_id', 'tahun_ajaran_id'],
                'unique_guru_mapel_kelas_tahun'
            );
        });
    }

    public function down(): void
    {
        Schema::table('guru_mapel_kelas', function (Blueprint $table) {
            $table->dropUnique('unique_guru_mapel_kelas_tahun');
            $table->dropForeign(['tahun_ajaran_id']);
            $table->dropColumn('tahun_ajaran_id');
        });
    }
};
