<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('guru_mapel_kelas_id')->constrained('guru_mapel_kelas')->onDelete('cascade');
            $table->foreignId('silabus_id')->constrained('silabus')->onDelete('cascade');
            $table->integer('nilai');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            // Indexes and constraints
            $table->unique(['siswa_id', 'guru_mapel_kelas_id', 'silabus_id'], 'unique_nilai_siswa_mapel_silabus');
            $table->index('siswa_id', 'idx_nilai_siswa');
            $table->index('guru_mapel_kelas_id', 'idx_nilai_gmk');
            $table->index('silabus_id', 'idx_nilai_silabus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
