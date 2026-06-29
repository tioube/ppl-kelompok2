<?php

namespace Database\Seeders;

use App\Models\GuruMapelKelas;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Silabus;
use App\Models\SiswaTahunAjaran;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Database\Seeder;

class AntropologiSeeder extends Seeder
{
    public function run(): void
    {
        $tahunAjaran = TahunAjaran::getAktif();
        if (! $tahunAjaran) {
            $this->command->error('Active academic year not found.');

            return;
        }

        $kelas = Kelas::where('nama', 'XI IPA 1')->first();
        if (! $kelas) {
            $this->command->error("Class 'XI IPA 1' not found.");

            return;
        }

        $mapel = MataPelajaran::where('nama', 'Antropologi')->first();
        if (! $mapel) {
            $this->command->error("Subject 'Antropologi' not found.");

            return;
        }

        $guru = User::where('name', 'like', '%antropologi%')->first() ?? User::role('guru')->first();
        if (! $guru) {
            $this->command->error('No guru found to assign.');

            return;
        }

        // Find or create GMK assignment
        $gmk = GuruMapelKelas::updateOrCreate([
            'kelas_id' => $kelas->id,
            'mata_pelajaran_id' => $mapel->id,
            'tahun_ajaran_id' => $tahunAjaran->id,
        ], [
            'guru_id' => $guru->id,
        ]);

        $this->command->info("GMK assignment checked/created for Guru: {$guru->name}, Kelas: {$kelas->nama}");

        // Recreate Silabus (TP 1 - 9 Formatif, TP 1 - 3 Sumatif)
        // Clean existing silabus for Antropologi to avoid cluttering
        Silabus::where('mata_pelajaran_id', $mapel->id)
            ->where('tahun_ajaran_id', $tahunAjaran->id)
            ->delete();

        $tps = [
            // Formatif
            ['kategori' => 'formatif', 'tujuan' => 'Pengantar ilmu antropologi, konsep kebudayaan dan ruang lingkup kajiannya.'],
            ['kategori' => 'formatif', 'tujuan' => 'Memahami metode etnografi dalam penelitian antropologi sosial.'],
            ['kategori' => 'formatif', 'tujuan' => 'Menganalisis diferensiasi sosial, stratifikasi sosial, dan keragaman budaya.'],
            ['kategori' => 'formatif', 'tujuan' => 'Mengkaji sistem kekerabatan dan organisasi sosial di masyarakat adat.'],
            ['kategori' => 'formatif', 'tujuan' => 'Menganalisis sistem kepercayaan, religi, dan ritus tradisi di Indonesia.'],
            ['kategori' => 'formatif', 'tujuan' => 'Mengidentifikasi sistem mata pencaharian hidup dan ekonomi tradisional.'],
            ['kategori' => 'formatif', 'tujuan' => 'Mengkaji perkembangan seni, bahasa, dan sastra daerah sebagai warisan budaya.'],
            ['kategori' => 'formatif', 'tujuan' => 'Menganalisis dinamika perubahan sosial budaya dan globalisasi.'],
            ['kategori' => 'formatif', 'tujuan' => 'Memahami peran antropologi dalam menyelesaikan konflik sosial budaya.'],

            // Sumatif
            ['kategori' => 'sumatif', 'tujuan' => 'Evaluasi Bab I - Konsep dasar kebudayaan dan etnografi.'],
            ['kategori' => 'sumatif', 'tujuan' => 'Evaluasi Bab II - Sistem kekerabatan, religi, dan organisasi sosial.'],
            ['kategori' => 'sumatif', 'tujuan' => 'Evaluasi Akhir Semester - Analisis dinamika perubahan budaya dan resolusi konflik.'],
        ];

        $silabusItems = [];
        foreach ($tps as $index => $tp) {
            $silabusItems[] = Silabus::create([
                'mata_pelajaran_id' => $mapel->id,
                'tahun_ajaran_id' => $tahunAjaran->id,
                'tujuan_pembelajaran' => $tp['tujuan'],
                'kategori' => $tp['kategori'],
                'status' => 'aktif',
                'approval_status' => 'approved',
                'urutan' => $index + 1,
                'created_by' => 1,
                'updated_by' => 1,
            ]);
        }

        $this->command->info('Successfully seeded 9 Formatif and 3 Sumatif syllabus objectives for Antropologi.');

        // Get students in this class
        $siswaList = SiswaTahunAjaran::where('kelas_id', $kelas->id)
            ->where('tahun_ajaran_id', $tahunAjaran->id)
            ->get();

        if ($siswaList->isEmpty()) {
            $this->command->warn('No students found in class XI IPA 1.');

            return;
        }

        // Seed grades for each student
        $nilaiCount = 0;
        foreach ($siswaList as $siswaTa) {
            foreach ($silabusItems as $silabus) {
                // Seed grades (some high, some remedial for realistic presentation)
                $score = rand(60, 99);

                Nilai::updateOrCreate([
                    'siswa_id' => $siswaTa->user_id,
                    'guru_mapel_kelas_id' => $gmk->id,
                    'silabus_id' => $silabus->id,
                ], [
                    'nilai' => $score,
                    'created_by' => 1,
                    'updated_by' => 1,
                ]);
                $nilaiCount++;
            }
        }

        $this->command->info("Successfully seeded {$nilaiCount} grades for {$siswaList->count()} students in XI IPA 1.");
    }
}
