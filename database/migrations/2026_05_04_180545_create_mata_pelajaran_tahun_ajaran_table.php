<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mata_pelajaran_tahun_ajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mata_pelajaran_id')
                ->constrained('mata_pelajaran')
                ->onDelete('cascade');
            $table->foreignId('tahun_ajaran_id')
                ->constrained('tahun_ajaran')
                ->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->integer('jam_pelajaran_override')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(
                ['mata_pelajaran_id', 'tahun_ajaran_id'],
                'unique_mapel_tahun'
            );
            $table->index(['tahun_ajaran_id', 'is_active'], 'idx_tahun_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mata_pelajaran_tahun_ajaran');
    }
};
