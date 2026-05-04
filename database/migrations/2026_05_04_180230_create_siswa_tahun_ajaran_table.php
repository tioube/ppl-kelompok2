<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa_tahun_ajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('tahun_ajaran_id')
                ->constrained('tahun_ajaran')
                ->onDelete('cascade');
            $table->foreignId('kelas_id')
                ->nullable()
                ->constrained('kelas')
                ->onDelete('set null');
            $table->foreignId('jurusan_id')
                ->nullable()
                ->constrained('jurusan')
                ->onDelete('set null');
            $table->enum('status', [
                'aktif',
                'naik_kelas',
                'lulus',
                'pindah',
                'dikeluarkan',
                'cuti',
            ])->default('aktif');
            $table->string('nomor_induk_sekolah')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'tahun_ajaran_id'], 'unique_siswa_tahun');
            $table->index(['tahun_ajaran_id', 'kelas_id'], 'idx_tahun_kelas');
            $table->index(['tahun_ajaran_id', 'jurusan_id'], 'idx_tahun_jurusan');
            $table->index(['status'], 'idx_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa_tahun_ajaran');
    }
};
