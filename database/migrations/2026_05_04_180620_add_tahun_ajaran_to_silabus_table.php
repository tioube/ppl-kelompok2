<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('silabus', function (Blueprint $table) {
            $table->unsignedBigInteger('tahun_ajaran_id')->nullable()->after('mata_pelajaran_id');
        });

        $activeTahunAjaran = DB::table('tahun_ajaran')->where('is_active', true)->first();

        if ($activeTahunAjaran) {
            DB::table('silabus')
                ->whereNull('tahun_ajaran_id')
                ->update(['tahun_ajaran_id' => $activeTahunAjaran->id]);
        } else {
            $firstTahunAjaran = DB::table('tahun_ajaran')->first();
            if ($firstTahunAjaran) {
                DB::table('silabus')
                    ->whereNull('tahun_ajaran_id')
                    ->update(['tahun_ajaran_id' => $firstTahunAjaran->id]);
            }
        }

        DB::table('silabus')->whereNull('tahun_ajaran_id')->delete();

        Schema::table('silabus', function (Blueprint $table) {
            $table->unsignedBigInteger('tahun_ajaran_id')->nullable(false)->change();

            $table->foreign('tahun_ajaran_id')
                ->references('id')
                ->on('tahun_ajaran')
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
