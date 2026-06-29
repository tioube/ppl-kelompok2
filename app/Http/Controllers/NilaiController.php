<?php

namespace App\Http\Controllers;

use App\Models\GuruMapelKelas;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Silabus;
use App\Models\SiswaTahunAjaran;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function create()
    {
        $tahunAjaranAktif = TahunAjaran::getAktif();

        if (auth()->user()->hasRole('guru')) {
            $gmkList = GuruMapelKelas::where('guru_id', auth()->id())
                ->when($tahunAjaranAktif, fn ($q) => $q->where('tahun_ajaran_id', $tahunAjaranAktif->id))
                ->with(['kelas', 'mataPelajaran'])
                ->get();

            $kelasList = $gmkList->pluck('kelas')->unique('id')->sortBy('nama')->values();
            $mataPelajaranList = $gmkList->pluck('mataPelajaran')->unique('id')->sortBy('nama')->values();
        } else {
            // Admin, Super Admin, Akademik see all active classes and subjects
            $kelasList = Kelas::orderBy('nama')->get();
            $mataPelajaranList = MataPelajaran::orderBy('nama')->get();
        }

        return view('nilai.create', compact('kelasList', 'mataPelajaranList', 'tahunAjaranAktif'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'silabus_id' => 'required|exists:silabus,id',
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|integer|min:0|max:100',
        ]);

        $tahunAjaranAktif = TahunAjaran::getAktif();
        if (! $tahunAjaranAktif) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Tahun Ajaran aktif tidak ditemukan.']);
        }

        // Get the teacher-class mapping
        $gmk = GuruMapelKelas::where('kelas_id', $validated['kelas_id'])
            ->where('mata_pelajaran_id', $validated['mata_pelajaran_id'])
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->first();

        if (! $gmk) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Kombinasi Kelas dan Mata Pelajaran ini belum memiliki guru yang ditugaskan di Penugasan Guru.']);
        }

        // Authorization check for Guru
        if (auth()->user()->hasRole('guru') && $gmk->guru_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $userId = auth()->id();

        foreach ($validated['nilai'] as $siswaId => $score) {
            if ($score === null || $score === '') {
                // If score is empty, we can delete the grade if it exists, or just skip it
                Nilai::where('siswa_id', $siswaId)
                    ->where('guru_mapel_kelas_id', $gmk->id)
                    ->where('silabus_id', $validated['silabus_id'])
                    ->delete();

                continue;
            }

            Nilai::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'guru_mapel_kelas_id' => $gmk->id,
                    'silabus_id' => $validated['silabus_id'],
                ],
                [
                    'nilai' => $score,
                    'created_by' => $userId,
                    'updated_by' => $userId,
                ]
            );
        }

        return redirect()->route('nilai.create')
            ->with('success', 'Nilai siswa berhasil disimpan.');
    }

    public function getSiswaByKelas($kelasId)
    {
        $tahunAjaranAktif = TahunAjaran::getAktif();
        if (! $tahunAjaranAktif) {
            return response()->json([]);
        }

        $siswa = SiswaTahunAjaran::where('kelas_id', $kelasId)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->where('status', 'aktif')
            ->with('siswa:id,name,nisn')
            ->get()
            ->map(fn ($sta) => [
                'id' => $sta->siswa->id,
                'name' => $sta->siswa->name,
                'nisn' => $sta->nomor_induk_sekolah ?? $sta->siswa->nisn ?? '-',
            ])
            ->sortBy('name')
            ->values();

        return response()->json($siswa);
    }

    public function getSilabusByMapel(Request $request, $mapelId)
    {
        $tahunAjaranAktif = TahunAjaran::getAktif();
        if (! $tahunAjaranAktif) {
            return response()->json([]);
        }

        $kategori = $request->query('kategori');

        $silabus = Silabus::where('mata_pelajaran_id', $mapelId)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->approved()
            ->active()
            ->when($kategori, fn ($q) => $q->where('kategori', $kategori))
            ->orderBy('urutan')
            ->get(['id', 'tujuan_pembelajaran', 'kategori']);

        return response()->json($silabus);
    }

    public function getExistingNilai(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required',
            'mata_pelajaran_id' => 'required',
            'silabus_id' => 'required',
        ]);

        $tahunAjaranAktif = TahunAjaran::getAktif();
        if (! $tahunAjaranAktif) {
            return response()->json([]);
        }

        $gmk = GuruMapelKelas::where('kelas_id', $request->kelas_id)
            ->where('mata_pelajaran_id', $request->mata_pelajaran_id)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->first();

        if (! $gmk) {
            return response()->json([]);
        }

        $nilai = Nilai::where('guru_mapel_kelas_id', $gmk->id)
            ->where('silabus_id', $request->silabus_id)
            ->get(['siswa_id', 'nilai'])
            ->pluck('nilai', 'siswa_id');

        return response()->json($nilai);
    }

    public function siswaIndex()
    {
        $tahunAjaranAktif = TahunAjaran::getAktif();
        if (! $tahunAjaranAktif) {
            $nilaiGrouped = collect();

            return view('nilai.siswa', [
                'title' => 'Nilai Saya',
                'nilaiGrouped' => $nilaiGrouped,
                'tahunAjaranAktif' => null,
            ]);
        }

        $nilaiList = Nilai::where('siswa_id', auth()->id())
            ->whereHas('guruMapelKelas', function ($q) use ($tahunAjaranAktif) {
                $q->where('tahun_ajaran_id', $tahunAjaranAktif->id);
            })
            ->with(['guruMapelKelas.mataPelajaran', 'guruMapelKelas.guru', 'silabus'])
            ->get();

        // Group by subject, then by category (formatif/sumatif)
        $nilaiGrouped = $nilaiList->groupBy(function ($item) {
            return $item->guruMapelKelas->mataPelajaran->nama;
        })->map(function ($subjectGrades) {
            $totalScore = $subjectGrades->sum('nilai');
            $count = $subjectGrades->count();
            $average = $count > 0 ? round($totalScore / $count, 1) : 0;

            return [
                'guru' => $subjectGrades->first()->guruMapelKelas->guru->name ?? '-',
                'average' => $average,
                'grades' => $subjectGrades->groupBy(function ($gradeItem) {
                    return $gradeItem->silabus->kategori;
                })->map(function ($items) {
                    return $items->map(function ($grade) {
                        return [
                            'nilai' => $grade->nilai,
                            'tujuan_pembelajaran' => $grade->silabus->tujuan_pembelajaran,
                            'kategori' => $grade->silabus->kategori,
                        ];
                    });
                }),
            ];
        });

        return view('nilai.siswa', [
            'title' => 'Nilai Saya',
            'nilaiGrouped' => $nilaiGrouped,
            'tahunAjaranAktif' => $tahunAjaranAktif,
        ]);
    }

    public function index()
    {
        $tahunAjaranAktif = TahunAjaran::getAktif();

        if (auth()->user()->hasRole('guru')) {
            $gmkList = GuruMapelKelas::where('guru_id', auth()->id())
                ->when($tahunAjaranAktif, fn ($q) => $q->where('tahun_ajaran_id', $tahunAjaranAktif->id))
                ->with(['kelas', 'mataPelajaran'])
                ->get();

            $kelasList = $gmkList->pluck('kelas')->unique('id')->sortBy('nama')->values();
            $mataPelajaranList = $gmkList->pluck('mataPelajaran')->unique('id')->sortBy('nama')->values();
        } else {
            // Admin, Super Admin, Akademik see all active classes and subjects
            $kelasList = Kelas::orderBy('nama')->get();
            $mataPelajaranList = MataPelajaran::orderBy('nama')->get();
        }

        return view('nilai.index', compact('kelasList', 'mataPelajaranList', 'tahunAjaranAktif'));
    }

    public function getReportData(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required',
            'mata_pelajaran_id' => 'required',
            'kategori' => 'nullable|string',
        ]);

        $tahunAjaranAktif = TahunAjaran::getAktif();
        if (! $tahunAjaranAktif) {
            return response()->json([
                'silabus' => [],
                'students' => [],
            ]);
        }

        $gmk = GuruMapelKelas::where('kelas_id', $request->kelas_id)
            ->where('mata_pelajaran_id', $request->mata_pelajaran_id)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->first();

        if (! $gmk) {
            return response()->json([
                'silabus' => [],
                'students' => [],
            ]);
        }

        // Get active approved syllabus items for this subject
        $silabusItems = Silabus::where('mata_pelajaran_id', $request->mata_pelajaran_id)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->approved()
            ->active()
            ->when($request->kategori, fn ($q) => $q->where('kategori', $request->kategori))
            ->orderBy('urutan')
            ->get(['id', 'tujuan_pembelajaran', 'kategori']);

        // Get students in this class
        $siswaList = SiswaTahunAjaran::where('kelas_id', $request->kelas_id)
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->with('siswa')
            ->get()
            ->sortBy(fn ($s) => $s->siswa->name ?? '');

        // Get grades
        $nilaiList = Nilai::where('guru_mapel_kelas_id', $gmk->id)
            ->whereIn('silabus_id', $silabusItems->pluck('id'))
            ->get();

        // Build response
        $studentsData = [];
        foreach ($siswaList as $siswaTa) {
            $studentUser = $siswaTa->siswa;
            if (! $studentUser) {
                continue;
            }

            $grades = [];
            $totalFormatif = 0;
            $countFormatif = 0;
            $totalSumatif = 0;
            $countSumatif = 0;

            foreach ($silabusItems as $silabus) {
                $nilaiRecord = $nilaiList->where('siswa_id', $studentUser->id)
                    ->where('silabus_id', $silabus->id)
                    ->first();

                $score = $nilaiRecord ? $nilaiRecord->nilai : null;
                $grades[$silabus->id] = $score;

                if ($score !== null) {
                    if ($silabus->kategori === 'formatif') {
                        $totalFormatif += $score;
                        $countFormatif++;
                    } else {
                        $totalSumatif += $score;
                        $countSumatif++;
                    }
                }
            }

            $avgFormatif = $countFormatif > 0 ? round($totalFormatif / $countFormatif, 1) : null;
            $avgSumatif = $countSumatif > 0 ? round($totalSumatif / $countSumatif, 1) : null;

            if ($avgFormatif !== null && $avgSumatif !== null) {
                $average = round(($avgFormatif + $avgSumatif) / 2, 1);
            } elseif ($avgFormatif !== null) {
                $average = $avgFormatif;
            } elseif ($avgSumatif !== null) {
                $average = $avgSumatif;
            } else {
                $average = null;
            }

            $status = $average !== null ? ($average >= 75 ? 'Tuntas' : 'Perlu Remedial') : '-';

            $studentsData[] = [
                'id' => $studentUser->id,
                'name' => $studentUser->name,
                'nisn' => $siswaTa->nomor_induk_sekolah ?? $siswaTa->siswa->nisn ?? '-',
                'grades' => $grades,
                'avg_formatif' => $avgFormatif,
                'avg_sumatif' => $avgSumatif,
                'average' => $average,
                'status' => $status,
            ];
        }

        return response()->json([
            'silabus' => $silabusItems,
            'students' => $studentsData,
        ]);
    }
}
