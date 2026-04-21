<?php

namespace App\Services;

use App\Models\GuruMapelKelas;
use App\Models\User;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;

class GuruMapelKelasGeneratorService
{
    public function generateAssignments()
    {
        DB::beginTransaction();

        try {
            GuruMapelKelas::query()->delete();

            $gurus = User::whereHas('roles', function($query) {
                $query->where('slug', 'guru');
            })->get();

            $mataPelajarans = MataPelajaran::all();
            $kelasList = Kelas::all();

            if ($gurus->isEmpty() || $mataPelajarans->isEmpty() || $kelasList->isEmpty()) {
                DB::rollBack();
                return [
                    'success' => false,
                    'message' => 'Data guru, mata pelajaran, atau kelas tidak lengkap untuk generate otomatis.'
                ];
            }

            $assignmentData = [];
            $guruIndex = 0;
            $totalGurus = $gurus->count();

            foreach ($kelasList as $kelas) {
                foreach ($mataPelajarans as $mapel) {
                    $guru = $gurus[$guruIndex % $totalGurus];

                    GuruMapelKelas::create([
                        'guru_id' => $guru->id,
                        'mata_pelajaran_id' => $mapel->id,
                        'kelas_id' => $kelas->id,
                    ]);

                    $assignmentData[] = [
                        'guru' => $guru->name,
                        'mapel' => $mapel->nama,
                        'kelas' => $kelas->nama,
                    ];

                    $guruIndex++;
                }
            }

            DB::commit();

            return [
                'success' => true,
                'message' => 'Berhasil generate ' . count($assignmentData) . ' penugasan guru otomatis.',
                'total' => count($assignmentData)
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Gagal generate penugasan: ' . $e->getMessage()
            ];
        }
    }

    public function clearAllAssignments()
    {
        try {
            $count = GuruMapelKelas::count();
            GuruMapelKelas::query()->delete();

            return [
                'success' => true,
                'message' => "Berhasil menghapus $count penugasan guru."
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Gagal menghapus penugasan: ' . $e->getMessage()
            ];
        }
    }
}

