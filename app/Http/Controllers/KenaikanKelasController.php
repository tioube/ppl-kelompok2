<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\TahunAjaran;
use App\Services\KenaikanKelasService;
use Illuminate\Http\Request;

class KenaikanKelasController extends Controller
{
    public function __construct(
        private KenaikanKelasService $kenaikanKelasService
    ) {}

    public function index()
    {
        if (! auth()->user()->hasPermission('manage-siswa')) {
            abort(403, 'You do not have permission to manage class promotion.');
        }

        $tahunAjaranList = TahunAjaran::orderBy('tahun', 'desc')->get();
        $kelasList = Kelas::orderBy('nama')->get();
        $jurusanList = Jurusan::orderBy('nama')->get();

        return view('pages.kenaikan-kelas.index', [
            'title' => 'Kenaikan Kelas Massal',
            'tahunAjaranList' => $tahunAjaranList,
            'kelasList' => $kelasList,
            'jurusanList' => $jurusanList,
        ]);
    }

    public function preview(Request $request)
    {
        if (! auth()->user()->hasPermission('manage-siswa')) {
            abort(403, 'You do not have permission to manage class promotion.');
        }

        $validated = $request->validate([
            'tahun_ajaran_lama_id' => 'required|exists:tahun_ajaran,id',
            'kelas_lama_id' => 'required|exists:kelas,id',
        ]);

        $siswaList = $this->kenaikanKelasService->previewNaikKelas(
            $validated['tahun_ajaran_lama_id'],
            $validated['kelas_lama_id']
        );

        $tahunAjaranList = TahunAjaran::orderBy('tahun', 'desc')->get();
        $kelasList = Kelas::orderBy('nama')->get();
        $jurusanList = Jurusan::orderBy('nama')->get();

        $tahunAjaranLama = TahunAjaran::find($validated['tahun_ajaran_lama_id']);
        $kelasLama = Kelas::find($validated['kelas_lama_id']);

        return view('pages.kenaikan-kelas.preview', [
            'title' => 'Preview Kenaikan Kelas',
            'siswaList' => $siswaList,
            'tahunAjaranList' => $tahunAjaranList,
            'kelasList' => $kelasList,
            'jurusanList' => $jurusanList,
            'tahunAjaranLama' => $tahunAjaranLama,
            'kelasLama' => $kelasLama,
            'tahunAjaranLamaId' => $validated['tahun_ajaran_lama_id'],
            'kelasLamaId' => $validated['kelas_lama_id'],
        ]);
    }

    public function process(Request $request)
    {
        if (! auth()->user()->hasPermission('manage-siswa')) {
            abort(403, 'You do not have permission to manage class promotion.');
        }

        $validated = $request->validate([
            'tahun_ajaran_lama_id' => 'required|exists:tahun_ajaran,id',
            'tahun_ajaran_baru_id' => 'required|exists:tahun_ajaran,id|different:tahun_ajaran_lama_id',
            'kelas_lama_id' => 'required|exists:kelas,id',
            'kelas_baru_id' => 'required|exists:kelas,id',
            'jurusan_baru_id' => 'nullable|exists:jurusan,id',
            'siswa_ids' => 'nullable|array',
            'siswa_ids.*' => 'exists:users,id',
        ]);

        $siswaIds = $validated['siswa_ids'] ?? [];

        $allSiswaCount = \App\Models\SiswaTahunAjaran::where('tahun_ajaran_id', $validated['tahun_ajaran_lama_id'])
            ->where('kelas_id', $validated['kelas_lama_id'])
            ->whereIn('status', ['aktif', 'naik_kelas'])
            ->count();

        $result = $this->kenaikanKelasService->naikKelasMassal(
            $validated['tahun_ajaran_lama_id'],
            $validated['tahun_ajaran_baru_id'],
            $validated['kelas_lama_id'],
            $validated['kelas_baru_id'],
            $validated['jurusan_baru_id'] ?? null,
            $siswaIds
        );

        $result['excluded'] = $allSiswaCount - count($siswaIds);

        $tahunAjaranLama = TahunAjaran::find($validated['tahun_ajaran_lama_id']);
        $tahunAjaranBaru = TahunAjaran::find($validated['tahun_ajaran_baru_id']);
        $kelasLama = Kelas::find($validated['kelas_lama_id']);
        $kelasBaru = Kelas::find($validated['kelas_baru_id']);

        $processedSiswa = \App\Models\SiswaTahunAjaran::where('tahun_ajaran_id', $validated['tahun_ajaran_baru_id'])
            ->where('kelas_id', $validated['kelas_baru_id'])
            ->with(['siswa', 'kelas', 'jurusan'])
            ->orderBy('created_at', 'desc')
            ->limit($result['success'])
            ->get();

        return view('pages.kenaikan-kelas.result', [
            'title' => 'Hasil Kenaikan Kelas',
            'result' => $result,
            'tahunAjaranLama' => $tahunAjaranLama,
            'tahunAjaranBaru' => $tahunAjaranBaru,
            'kelasLama' => $kelasLama,
            'kelasBaru' => $kelasBaru,
            'processedSiswa' => $processedSiswa,
        ]);
    }

    public function previewLuluskan(Request $request)
    {
        if (! auth()->user()->hasPermission('manage-siswa')) {
            abort(403, 'You do not have permission to manage graduation.');
        }

        $validated = $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $siswaList = $this->kenaikanKelasService->previewKelulusan(
            $validated['tahun_ajaran_id'],
            $validated['kelas_id']
        );

        $tahunAjaranList = TahunAjaran::orderBy('tahun', 'desc')->get();
        $kelasList = Kelas::orderBy('nama')->get();
        $tahunAjaran = TahunAjaran::find($validated['tahun_ajaran_id']);
        $kelas = Kelas::find($validated['kelas_id']);

        return view('pages.kenaikan-kelas.graduation-preview', [
            'title' => 'Preview Kelulusan',
            'siswaList' => $siswaList,
            'tahunAjaranList' => $tahunAjaranList,
            'kelasList' => $kelasList,
            'tahunAjaran' => $tahunAjaran,
            'kelas' => $kelas,
            'tahunAjaranId' => $validated['tahun_ajaran_id'],
            'kelasId' => $validated['kelas_id'],
        ]);
    }

    public function luluskan(Request $request)
    {
        if (! auth()->user()->hasPermission('manage-siswa')) {
            abort(403, 'You do not have permission to manage graduation.');
        }

        $validated = $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'siswa_status' => 'required|array',
            'siswa_status.*' => 'in:lulus,tinggal_kelas,skip',
        ]);

        $siswaStatus = $validated['siswa_status'];

        $lulusSiswaIds = [];
        $tinggalKelasSiswaIds = [];

        foreach ($siswaStatus as $userId => $status) {
            if ($status === 'lulus') {
                $lulusSiswaIds[] = $userId;
            } elseif ($status === 'tinggal_kelas') {
                $tinggalKelasSiswaIds[] = $userId;
            }
        }

        $allSiswaCount = count($siswaStatus);

        $result = $this->kenaikanKelasService->luluskanMassal(
            $validated['tahun_ajaran_id'],
            $validated['kelas_id'],
            $lulusSiswaIds
        );

        $tinggalKelasCount = $this->kenaikanKelasService->tinggalKelasMassal(
            $validated['tahun_ajaran_id'],
            $validated['kelas_id'],
            $tinggalKelasSiswaIds
        );

        $result['tinggal_kelas'] = $tinggalKelasCount;
        $result['excluded'] = $allSiswaCount - count($lulusSiswaIds) - count($tinggalKelasSiswaIds);

        $tahunAjaran = TahunAjaran::find($validated['tahun_ajaran_id']);
        $kelas = Kelas::find($validated['kelas_id']);

        $graduatedSiswa = \App\Models\SiswaTahunAjaran::where('tahun_ajaran_id', $validated['tahun_ajaran_id'])
            ->where('kelas_id', $validated['kelas_id'])
            ->where('status', 'lulus')
            ->with(['siswa', 'kelas', 'jurusan'])
            ->get();

        $tinggalKelasSiswa = \App\Models\SiswaTahunAjaran::where('tahun_ajaran_id', $validated['tahun_ajaran_id'])
            ->where('kelas_id', $validated['kelas_id'])
            ->where('status', 'tinggal_kelas')
            ->with(['siswa', 'kelas', 'jurusan'])
            ->get();

        return view('pages.kenaikan-kelas.graduation-result', [
            'title' => 'Hasil Kelulusan Massal',
            'result' => $result,
            'tahunAjaran' => $tahunAjaran,
            'kelas' => $kelas,
            'graduatedSiswa' => $graduatedSiswa,
            'tinggalKelasSiswa' => $tinggalKelasSiswa,
        ]);
    }
}

