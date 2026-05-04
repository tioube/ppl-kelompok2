<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE siswa_tahun_ajaran MODIFY COLUMN status ENUM('aktif', 'naik_kelas', 'lulus', 'pindah', 'dikeluarkan', 'cuti', 'tinggal_kelas') DEFAULT 'aktif'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE siswa_tahun_ajaran MODIFY COLUMN status ENUM('aktif', 'naik_kelas', 'lulus', 'pindah', 'dikeluarkan', 'cuti') DEFAULT 'aktif'");
    }
};

