<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->foreignId('siswa_tahun_ajaran_id')
                ->nullable()
                ->after('siswa_id')
                ->constrained('siswa_tahun_ajaran')
                ->onDelete('cascade');

            $table->index(['siswa_tahun_ajaran_id']);
        });
    }

    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropForeign(['siswa_tahun_ajaran_id']);
            $table->dropColumn('siswa_tahun_ajaran_id');
        });
    }
};
