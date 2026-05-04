<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\GuruMapelKelas;
use App\Models\JurnalMengajar;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Silabus;
use App\Models\User;
use Illuminate\Http\Request;

class JurnalMengajarController extends Controller
{
    public function index(Request $request)
    {
        $query = JurnalMengajar::with([
            'guruMapelKelas.guru',
            'guruMapelKelas.kelas',
            'guruMapelKelas.mataPelajaran',
            'silabus',
            'absensi',
        ]);

        if (auth()->user()->hasRole('guru')) {
            $query->whereHas('guruMapelKelas', function ($q) {
                $q->where('guru_id', auth()->id());
            });
        }

        if ($request->filled('kelas_id')) {
            $query->whereHas('guruMapelKelas', fn ($q) => $q->where('kelas_id', $request->kelas_id));
        }
        if ($request->filled('mata_pelajaran_id')) {
            $query->whereHas('guruMapelKelas', fn ($q) => $q->where('mata_pelajaran_id', $request->mata_pelajaran_id));
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('catatan', 'like', "%{$search}%")
                    ->orWhereHas('silabus', fn ($sq) => $sq->where('tujuan_pembelajaran', 'like', "%{$search}%"));
            });
        }

        $jurnalMengajar = $query->orderBy('tanggal', 'desc')
            ->orderBy('waktu_mulai', 'desc')
            ->paginate(15)
            ->withQueryString();

        $kelasList = Kelas::orderBy('nama')->get();
        $mataPelajaranList = MataPelajaran::orderBy('nama')->get();

        return view('jurnal-mengajar.index', compact('jurnalMengajar', 'kelasList', 'mataPelajaranList'));
    }

    public function create()
    {
        if (auth()->user()->hasRole('guru')) {
            $guruMapelKelas = GuruMapelKelas::with(['kelas', 'mataPelajaran'])
                ->where('guru_id', auth()->id())
                ->get();
        } else {
            $guruMapelKelas = GuruMapelKelas::with(['kelas', 'mataPelajaran', 'guru'])
                ->get();
        }

        return view('jurnal-mengajar.create', compact('guruMapelKelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guru_mapel_kelas_id' => 'required|exists:guru_mapel_kelas,id',
            'silabus_id' => 'required|exists:silabus,id',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
            'catatan' => 'nullable|string',
            'absensi' => 'required|array',
            'absensi.*.siswa_id' => 'required|exists:users,id',
            'absensi.*.status' => 'required|in:hadir,sakit,izin,alfa',
            'absensi.*.keterangan' => 'nullable|string|max:255',
        ]);

        $guruMapelKelas = GuruMapelKelas::findOrFail($validated['guru_mapel_kelas_id']);

        if (auth()->user()->hasRole('guru') && $guruMapelKelas->guru_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $jurnal = JurnalMengajar::create([
            'guru_mapel_kelas_id' => $validated['guru_mapel_kelas_id'],
            'silabus_id' => $validated['silabus_id'],
            'tanggal' => $validated['tanggal'],
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'],
            'catatan' => $validated['catatan'],
            'created_by' => auth()->id(),
        ]);

        foreach ($validated['absensi'] as $absensiData) {
            Absensi::create([
                'jurnal_mengajar_id' => $jurnal->id,
                'siswa_id' => $absensiData['siswa_id'],
                'status' => $absensiData['status'],
                'keterangan' => $absensiData['keterangan'] ?? null,
            ]);
        }

        return redirect()->route('jurnal-mengajar.index')
            ->with('success', 'Jurnal Mengajar berhasil dibuat.');
    }

    public function show(JurnalMengajar $jurnalMengajar)
    {
        if (auth()->user()->hasRole('guru') && $jurnalMengajar->guruMapelKelas->guru_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $jurnalMengajar->load([
            'guruMapelKelas.guru',
            'guruMapelKelas.kelas',
            'guruMapelKelas.mataPelajaran',
            'silabus',
            'absensi.siswa',
            'createdBy',
        ]);

        $absensiStats = [
            'hadir' => $jurnalMengajar->absensi->where('status', 'hadir')->count(),
            'sakit' => $jurnalMengajar->absensi->where('status', 'sakit')->count(),
            'izin' => $jurnalMengajar->absensi->where('status', 'izin')->count(),
            'alfa' => $jurnalMengajar->absensi->where('status', 'alfa')->count(),
            'total' => $jurnalMengajar->absensi->count(),
        ];

        return view('jurnal-mengajar.show', compact('jurnalMengajar', 'absensiStats'));
    }

    public function edit(JurnalMengajar $jurnalMengajar)
    {
        if (auth()->user()->hasRole('guru') && $jurnalMengajar->guruMapelKelas->guru_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $jurnalMengajar->load(['absensi']);

        if (auth()->user()->hasRole('guru')) {
            $guruMapelKelas = GuruMapelKelas::with(['kelas', 'mataPelajaran'])
                ->where('guru_id', auth()->id())
                ->get();
        } else {
            $guruMapelKelas = GuruMapelKelas::with(['kelas', 'mataPelajaran', 'guru'])
                ->get();
        }

        $silabusList = Silabus::where('mata_pelajaran_id', $jurnalMengajar->guruMapelKelas->mata_pelajaran_id)
            ->approved()
            ->active()
            ->get();

        $siswaList = User::siswa()
            ->byKelas($jurnalMengajar->guruMapelKelas->kelas_id)
            ->tahunAjaranAktif()
            ->orderBy('name')
            ->get();

        $existingAbsensi = $jurnalMengajar->absensi->keyBy('siswa_id');

        return view('jurnal-mengajar.edit', compact(
            'jurnalMengajar',
            'guruMapelKelas',
            'silabusList',
            'siswaList',
            'existingAbsensi'
        ));
    }

    public function update(Request $request, JurnalMengajar $jurnalMengajar)
    {
        if (auth()->user()->hasRole('guru') && $jurnalMengajar->guruMapelKelas->guru_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'guru_mapel_kelas_id' => 'required|exists:guru_mapel_kelas,id',
            'silabus_id' => 'required|exists:silabus,id',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
            'catatan' => 'nullable|string',
            'absensi' => 'required|array',
            'absensi.*.siswa_id' => 'required|exists:users,id',
            'absensi.*.status' => 'required|in:hadir,sakit,izin,alfa',
            'absensi.*.keterangan' => 'nullable|string|max:255',
        ]);

        $jurnalMengajar->update([
            'guru_mapel_kelas_id' => $validated['guru_mapel_kelas_id'],
            'silabus_id' => $validated['silabus_id'],
            'tanggal' => $validated['tanggal'],
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'],
            'catatan' => $validated['catatan'],
        ]);

        foreach ($validated['absensi'] as $absensiData) {
            Absensi::updateOrCreate(
                [
                    'jurnal_mengajar_id' => $jurnalMengajar->id,
                    'siswa_id' => $absensiData['siswa_id'],
                ],
                [
                    'status' => $absensiData['status'],
                    'keterangan' => $absensiData['keterangan'] ?? null,
                ]
            );
        }

        return redirect()->route('jurnal-mengajar.index')
            ->with('success', 'Jurnal Mengajar berhasil diperbarui.');
    }

    public function destroy(JurnalMengajar $jurnalMengajar)
    {
        if (auth()->user()->hasRole('guru') && $jurnalMengajar->guruMapelKelas->guru_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $jurnalMengajar->delete();

        return redirect()->route('jurnal-mengajar.index')
            ->with('success', 'Jurnal Mengajar berhasil dihapus.');
    }

    public function getSilabusByGuruMapelKelas($id)
    {
        $guruMapelKelas = GuruMapelKelas::findOrFail($id);

        $silabus = Silabus::where('mata_pelajaran_id', $guruMapelKelas->mata_pelajaran_id)
            ->approved()
            ->active()
            ->select('id', 'tujuan_pembelajaran', 'kategori')
            ->get();

        return response()->json($silabus);
    }

    public function getSiswaByGuruMapelKelas($id)
    {
        $guruMapelKelas = GuruMapelKelas::findOrFail($id);

        $siswa = User::siswa()
            ->byKelas($guruMapelKelas->kelas_id)
            ->tahunAjaranAktif()
            ->select('id', 'name', 'nisn')
            ->orderBy('name')
            ->get();

        return response()->json($siswa);
    }
}
