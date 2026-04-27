<?php

namespace Database\Seeders;

use App\Models\Tugas;
use App\Models\User;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use Illuminate\Database\Seeder;

class TugasSeeder extends Seeder
{
    public function run(): void
    {
        $guru = User::whereHas('roles', fn($q) => $q->where('slug', 'guru'))->first();
        $kelas = Kelas::first();
        $mapelList = MataPelajaran::all();

        foreach ($mapelList->take(5) as $mapel) {
            Tugas::create([
                'judul'             => 'Tugas ' . $mapel->nama,
                'deskripsi'         => 'Kerjakan soal berikut dengan baik dan benar sesuai materi ' . $mapel->nama,
                'mata_pelajaran_id' => $mapel->id,
                'guru_id'           => $guru->id,
                'kelas_id'          => $kelas->id,
                'deadline'          => now()->addDays(rand(1, 14)),
                'file_materi'       => null,
            ]);
        }
    }
}
