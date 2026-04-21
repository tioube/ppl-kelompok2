<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TahunAjaran;
use App\Models\Jurusan;
use App\Models\Kelas;

class AkademikSeeder extends Seeder
{
    public function run(): void
    {
        $tahunAjaran = TahunAjaran::create([
            'tahun' => '2024-2025',
            'is_active' => true,
        ]);

        TahunAjaran::create([
            'tahun' => '2025-2026',
            'is_active' => false,
        ]);

        $ipa = Jurusan::create([
            'nama' => 'Ilmu Pengetahuan Alam',
            'deskripsi' => 'Program studi yang berfokus pada ilmu-ilmu alam seperti Matematika, Fisika, Kimia, dan Biologi',
        ]);

        $ips = Jurusan::create([
            'nama' => 'Ilmu Pengetahuan Sosial',
            'deskripsi' => 'Program studi yang berfokus pada ilmu-ilmu sosial seperti Sejarah, Geografi, Ekonomi, dan Sosiologi',
        ]);

        $bahasa = Jurusan::create([
            'nama' => 'Bahasa',
            'deskripsi' => 'Program studi yang berfokus pada bahasa dan sastra',
        ]);

        Kelas::create(['nama' => 'X']);
        Kelas::create(['nama' => 'XI IPA 1', 'jurusan_id' => $ipa->id]);
        Kelas::create(['nama' => 'XI IPA 2', 'jurusan_id' => $ipa->id]);
        Kelas::create(['nama' => 'XI IPS 1', 'jurusan_id' => $ips->id]);
        Kelas::create(['nama' => 'XI IPS 2', 'jurusan_id' => $ips->id]);
        Kelas::create(['nama' => 'XI Bahasa 1', 'jurusan_id' => $bahasa->id]);
        Kelas::create(['nama' => 'XII IPA 1', 'jurusan_id' => $ipa->id]);
        Kelas::create(['nama' => 'XII IPA 2', 'jurusan_id' => $ipa->id]);
        Kelas::create(['nama' => 'XII IPS 1', 'jurusan_id' => $ips->id]);
        Kelas::create(['nama' => 'XII Bahasa 1', 'jurusan_id' => $bahasa->id]);
    }
}

