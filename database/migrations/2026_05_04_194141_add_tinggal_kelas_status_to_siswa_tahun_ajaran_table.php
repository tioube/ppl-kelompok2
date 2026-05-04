<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE siswa_tahun_ajaran MODIFY COLUMN status ENUM('aktif', 'naik_kelas', 'lulus', 'pindah', 'dikeluarkan', 'cuti', 'tinggal_kelas') DEFAULT 'aktif'");
        }
    }

    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE siswa_tahun_ajaran MODIFY COLUMN status ENUM('aktif', 'naik_kelas', 'lulus', 'pindah', 'dikeluarkan', 'cuti') DEFAULT 'aktif'");
        }
    }
};
