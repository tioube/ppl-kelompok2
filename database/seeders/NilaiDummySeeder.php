<?php

namespace Database\Seeders;

use App\Models\GuruMapelKelas;
use App\Models\Nilai;
use App\Models\Silabus;
use App\Models\SiswaTahunAjaran;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Database\Seeder;

class NilaiDummySeeder extends Seeder
{
    public function run(): void
    {
        $siswaId = 52;
        $user = User::find($siswaId);
        if (! $user) {
            $this->command->error("User with ID $siswaId not found.");

            return;
        }

        $tahunAjaran = TahunAjaran::getAktif();
        if (! $tahunAjaran) {
            $this->command->error('Active academic year not found.');

            return;
        }

        $siswaTa = SiswaTahunAjaran::where('user_id', $siswaId)
            ->where('tahun_ajaran_id', $tahunAjaran->id)
            ->first();

        if (! $siswaTa) {
            $this->command->error("User with ID $siswaId is not enrolled in any class for the active year.");

            return;
        }

        $gmkList = GuruMapelKelas::where('kelas_id', $siswaTa->kelas_id)
            ->where('tahun_ajaran_id', $tahunAjaran->id)
            ->get();

        if ($gmkList->isEmpty()) {
            $this->command->error("No subjects assigned to the class of user $siswaId.");

            return;
        }

        // Seed for selected core subjects: Bahasa Indonesia, Matematika, Bahasa Inggris, Fisika, Kimia, Biologi
        $selectedMapelIds = [8, 9, 11, 19, 20, 21];
        $seededCount = 0;

        foreach ($gmkList as $gmk) {
            if (! in_array($gmk->mata_pelajaran_id, $selectedMapelIds)) {
                continue;
            }

            // Get active approved syllabus items for this subject
            $silabusList = Silabus::where('mata_pelajaran_id', $gmk->mata_pelajaran_id)
                ->where('tahun_ajaran_id', $tahunAjaran->id)
                ->approved()
                ->active()
                ->get();

            if ($silabusList->isEmpty()) {
                continue;
            }

            foreach ($silabusList as $silabus) {
                // Seed a random grade between 65 and 98
                $score = rand(65, 98);

                Nilai::updateOrCreate(
                    [
                        'siswa_id' => $siswaId,
                        'guru_mapel_kelas_id' => $gmk->id,
                        'silabus_id' => $silabus->id,
                    ],
                    [
                        'nilai' => $score,
                        'created_by' => 1, // Super Admin
                        'updated_by' => 1,
                    ]
                );
                $seededCount++;
            }
        }

        $this->command->info("Successfully seeded $seededCount grades for student user $siswaId.");
    }
}
