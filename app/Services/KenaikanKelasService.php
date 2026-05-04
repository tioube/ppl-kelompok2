<?php

namespace App\Services;

use App\Models\SiswaTahunAjaran;
use App\Models\TahunAjaran;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class KenaikanKelasService
{
    public function naikKelasMassal(
        int $tahunAjaranLamaId,
        int $tahunAjaranBaruId,
        int $kelasLamaId,
        int $kelasBaruId,
        ?int $jurusanBaruId = null,
        array $siswaIds = []
    ): array {
        $result = [
            'success' => 0,
            'failed' => 0,
            'skipped' => 0,
            'errors' => [],
        ];

        if (empty($siswaIds)) {
            return $result;
        }

        $siswaList = SiswaTahunAjaran::where('tahun_ajaran_id', $tahunAjaranLamaId)
            ->where('kelas_id', $kelasLamaId)
            ->where('status', 'aktif')
            ->whereIn('user_id', $siswaIds)
            ->get();

        DB::beginTransaction();

        try {
            foreach ($siswaList as $siswaTahunAjaranLama) {
                $existingEntry = SiswaTahunAjaran::where('user_id', $siswaTahunAjaranLama->user_id)
                    ->where('tahun_ajaran_id', $tahunAjaranBaruId)
                    ->first();

                if ($existingEntry) {
                    $result['skipped']++;
                    continue;
                }

                $siswaTahunAjaranLama->update(['status' => 'naik_kelas']);

                SiswaTahunAjaran::create([
                    'user_id' => $siswaTahunAjaranLama->user_id,
                    'tahun_ajaran_id' => $tahunAjaranBaruId,
                    'kelas_id' => $kelasBaruId,
                    'jurusan_id' => $jurusanBaruId ?? $siswaTahunAjaranLama->jurusan_id,
                    'status' => 'aktif',
                ]);

                $result['success']++;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $result['errors'][] = $e->getMessage();
            $result['failed'] = $siswaList->count();
            $result['success'] = 0;
        }

        return $result;
    }

    public function luluskanMassal(
        int $tahunAjaranId,
        int $kelasId,
        array $siswaIds = []
    ): array {
        $result = [
            'success' => 0,
            'failed' => 0,
            'tinggal_kelas' => 0,
            'errors' => [],
        ];

        if (empty($siswaIds)) {
            return $result;
        }

        DB::beginTransaction();

        try {
            $updated = SiswaTahunAjaran::where('tahun_ajaran_id', $tahunAjaranId)
                ->where('kelas_id', $kelasId)
                ->where('status', 'aktif')
                ->whereIn('user_id', $siswaIds)
                ->update(['status' => 'lulus']);

            $result['success'] = $updated;

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $result['errors'][] = $e->getMessage();
        }

        return $result;
    }

    public function tinggalKelasMassal(
        int $tahunAjaranId,
        int $kelasId,
        array $siswaIds = []
    ): int {
        if (empty($siswaIds)) {
            return 0;
        }

        return SiswaTahunAjaran::where('tahun_ajaran_id', $tahunAjaranId)
            ->where('kelas_id', $kelasId)
            ->where('status', 'aktif')
            ->whereIn('user_id', $siswaIds)
            ->update(['status' => 'tinggal_kelas']);
    }

    public function previewKelulusan(
        int $tahunAjaranId,
        int $kelasId
    ): Collection {
        return SiswaTahunAjaran::where('tahun_ajaran_id', $tahunAjaranId)
            ->where('kelas_id', $kelasId)
            ->where('status', 'aktif')
            ->with(['siswa', 'kelas', 'jurusan'])
            ->get();
    }

    public function previewNaikKelas(
        int $tahunAjaranLamaId,
        int $kelasLamaId
    ): Collection {
        return SiswaTahunAjaran::where('tahun_ajaran_id', $tahunAjaranLamaId)
            ->where('kelas_id', $kelasLamaId)
            ->where('status', 'aktif')
            ->with(['siswa', 'kelas', 'jurusan'])
            ->get();
    }

    public function naikKelasIndividu(
        int $userId,
        int $tahunAjaranLamaId,
        int $tahunAjaranBaruId,
        int $kelasBaruId,
        ?int $jurusanBaruId = null
    ): array {
        $result = [
            'success' => false,
            'message' => '',
        ];

        $siswaTahunAjaranLama = SiswaTahunAjaran::where('user_id', $userId)
            ->where('tahun_ajaran_id', $tahunAjaranLamaId)
            ->first();

        if (!$siswaTahunAjaranLama) {
            $result['message'] = 'Siswa tidak ditemukan di tahun ajaran lama.';
            return $result;
        }

        $existingEntry = SiswaTahunAjaran::where('user_id', $userId)
            ->where('tahun_ajaran_id', $tahunAjaranBaruId)
            ->first();

        if ($existingEntry) {
            $result['message'] = 'Siswa sudah terdaftar di tahun ajaran baru.';
            return $result;
        }

        DB::beginTransaction();

        try {
            $siswaTahunAjaranLama->update(['status' => 'naik_kelas']);

            SiswaTahunAjaran::create([
                'user_id' => $userId,
                'tahun_ajaran_id' => $tahunAjaranBaruId,
                'kelas_id' => $kelasBaruId,
                'jurusan_id' => $jurusanBaruId ?? $siswaTahunAjaranLama->jurusan_id,
                'status' => 'aktif',
            ]);

            DB::commit();

            $result['success'] = true;
            $result['message'] = 'Siswa berhasil dinaikkelaskan.';
        } catch (\Exception $e) {
            DB::rollBack();
            $result['message'] = 'Gagal menaikkelaskan siswa: ' . $e->getMessage();
        }

        return $result;
    }
}

