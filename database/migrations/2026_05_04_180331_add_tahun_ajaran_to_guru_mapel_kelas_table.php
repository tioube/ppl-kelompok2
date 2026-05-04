<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guru_mapel_kelas', function (Blueprint $table) {
            $table->unsignedBigInteger('tahun_ajaran_id')->nullable()->after('kelas_id');
        });

        $activeTahunAjaran = DB::table('tahun_ajaran')->where('is_active', true)->first();

        if ($activeTahunAjaran) {
            DB::table('guru_mapel_kelas')
                ->whereNull('tahun_ajaran_id')
                ->update(['tahun_ajaran_id' => $activeTahunAjaran->id]);
        } else {
            $firstTahunAjaran = DB::table('tahun_ajaran')->first();
            if ($firstTahunAjaran) {
                DB::table('guru_mapel_kelas')
                    ->whereNull('tahun_ajaran_id')
                    ->update(['tahun_ajaran_id' => $firstTahunAjaran->id]);
            }
        }

        DB::table('guru_mapel_kelas')->whereNull('tahun_ajaran_id')->delete();

        Schema::table('guru_mapel_kelas', function (Blueprint $table) {
            $table->unsignedBigInteger('tahun_ajaran_id')->nullable(false)->change();

            $table->foreign('tahun_ajaran_id')
                ->references('id')
                ->on('tahun_ajaran')
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
