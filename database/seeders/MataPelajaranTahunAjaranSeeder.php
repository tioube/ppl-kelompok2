<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use App\Models\MataPelajaranTahunAjaran;
use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;

class MataPelajaranTahunAjaranSeeder extends Seeder
{
    public function run(): void
    {
        $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();

        if (!$tahunAjaranAktif) {
            $this->command->warn('No active tahun ajaran found. Please run AkademikSeeder first.');
            return;
        }

        $mataPelajaranList = MataPelajaran::all();

        if ($mataPelajaranList->isEmpty()) {
            $this->command->warn('No mata pelajaran found. Please run MataPelajaranSeeder first.');
            return;
        }

        $created = 0;
        foreach ($mataPelajaranList as $mapel) {
            $exists = MataPelajaranTahunAjaran::where('mata_pelajaran_id', $mapel->id)
                ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                ->exists();

            if (!$exists) {
                MataPelajaranTahunAjaran::create([
                    'mata_pelajaran_id' => $mapel->id,
                    'tahun_ajaran_id' => $tahunAjaranAktif->id,
                    'is_active' => true,
                    'jam_pelajaran_override' => null,
                    'catatan' => null,
                ]);
                $created++;
            }
        }

        $this->command->info("Created {$created} mata pelajaran mappings for tahun ajaran {$tahunAjaranAktif->tahun}!");
    }
}

