<?php

namespace App\Http\Controllers;

use App\Models\GuruMapelKelas;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use App\Models\User;
use App\Services\GuruMapelKelasGeneratorService;
use Illuminate\Http\Request;

class GuruMapelKelasController extends Controller
{
    protected $generator;

    public function __construct(GuruMapelKelasGeneratorService $generator)
    {
        $this->generator = $generator;
    }

    public function index(Request $request)
    {
        $tahunAjaranAktif = TahunAjaran::getAktif();
        $selectedTahunAjaran = $request->input('tahun_ajaran_id', $tahunAjaranAktif?->id);

        $query = GuruMapelKelas::with(['guru', 'mataPelajaran', 'kelas', 'tahunAjaran']);

        if ($selectedTahunAjaran) {
            $query->where('tahun_ajaran_id', $selectedTahunAjaran);
        }

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('guru', function ($guruQuery) use ($search) {
                    $guruQuery->where('name', 'like', "%{$search}%");
                })
                    ->orWhereHas('mataPelajaran', function ($mapelQuery) use ($search) {
                        $mapelQuery->where('nama', 'like', "%{$search}%")
                            ->orWhere('kode', 'like', "%{$search}%");
                    })
                    ->orWhereHas('kelas', function ($kelasQuery) use ($search) {
                        $kelasQuery->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        if ($guruId = $request->get('guru_id')) {
            $query->where('guru_id', $guruId);
        }

        if ($mataPelajaranId = $request->get('mata_pelajaran_id')) {
            $query->where('mata_pelajaran_id', $mataPelajaranId);
        }

        if ($kelasId = $request->get('kelas_id')) {
            $query->where('kelas_id', $kelasId);
        }

        $sortBy = $request->get('sort', 'kelas_id');
        $sortDirection = $request->get('direction', 'asc');

        $allowedSorts = ['guru_id', 'mata_pelajaran_id', 'kelas_id', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            if ($sortBy === 'guru_id') {
                $query->join('users', 'guru_mapel_kelas.guru_id', '=', 'users.id')
                    ->orderBy('users.name', $sortDirection)
                    ->select('guru_mapel_kelas.*');
            } elseif ($sortBy === 'mata_pelajaran_id') {
                $query->join('mata_pelajaran', 'guru_mapel_kelas.mata_pelajaran_id', '=', 'mata_pelajaran.id')
                    ->orderBy('mata_pelajaran.nama', $sortDirection)
                    ->select('guru_mapel_kelas.*');
            } elseif ($sortBy === 'kelas_id') {
                $query->join('kelas', 'guru_mapel_kelas.kelas_id', '=', 'kelas.id')
                    ->orderBy('kelas.nama', $sortDirection)
                    ->select('guru_mapel_kelas.*');
            } else {
                $query->orderBy($sortBy, $sortDirection);
            }
        } else {
            $query->orderBy('kelas_id');
        }

        $assignments = $query->paginate(15)->withQueryString();

        $gurus = User::whereHas('roles', function ($query) {
            $query->where('slug', 'guru');
        })->orderBy('name')->get();

        $mataPelajarans = MataPelajaran::orderBy('nama')->get();
        $kelas = Kelas::orderBy('nama')->get();
        $tahunAjaranList = TahunAjaran::orderBy('tahun', 'desc')->get();

        $statsQuery = GuruMapelKelas::query();
        if ($selectedTahunAjaran) {
            $statsQuery->where('tahun_ajaran_id', $selectedTahunAjaran);
        }

        $stats = [
            'total' => (clone $statsQuery)->count(),
            'gurus_assigned' => (clone $statsQuery)->distinct('guru_id')->count('guru_id'),
            'mapel_assigned' => (clone $statsQuery)->distinct('mata_pelajaran_id')->count('mata_pelajaran_id'),
            'kelas_covered' => (clone $statsQuery)->distinct('kelas_id')->count('kelas_id'),
        ];

        return view('akademik.guru-mapel-kelas.index', [
            'title' => 'Penugasan Guru',
            'assignments' => $assignments,
            'gurus' => $gurus,
            'mataPelajarans' => $mataPelajarans,
            'kelas' => $kelas,
            'tahunAjaranList' => $tahunAjaranList,
            'selectedTahunAjaran' => $selectedTahunAjaran,
            'stats' => $stats,
            'filters' => $request->only(['search', 'guru_id', 'mata_pelajaran_id', 'kelas_id', 'tahun_ajaran_id', 'sort', 'direction']),
        ]);
    }

    public function create()
    {
        $gurus = User::whereHas('roles', function ($query) {
            $query->where('slug', 'guru');
        })->orderBy('name')->get();

        $mataPelajarans = MataPelajaran::orderBy('nama')->get();
        $kelas = Kelas::orderBy('nama')->get();
        $tahunAjaranList = TahunAjaran::orderBy('tahun', 'desc')->get();
        $tahunAjaranAktif = TahunAjaran::getAktif();

        return view('akademik.guru-mapel-kelas.create', [
            'title' => 'Tambah Penugasan Guru',
            'gurus' => $gurus,
            'mataPelajarans' => $mataPelajarans,
            'kelas' => $kelas,
            'tahunAjaranList' => $tahunAjaranList,
            'tahunAjaranAktif' => $tahunAjaranAktif,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guru_id' => 'required|exists:users,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        ]);

        $exists = GuruMapelKelas::where('guru_id', $validated['guru_id'])
            ->where('mata_pelajaran_id', $validated['mata_pelajaran_id'])
            ->where('kelas_id', $validated['kelas_id'])
            ->where('tahun_ajaran_id', $validated['tahun_ajaran_id'])
            ->exists();

        if ($exists) {
            return redirect()->back()->withInput()
                ->withErrors(['error' => 'Penugasan ini sudah ada!']);
        }

        GuruMapelKelas::create($validated);

        return redirect()->route('guru-mapel-kelas.index')
            ->with('success', 'Penugasan guru berhasil ditambahkan.');
    }

    public function edit(GuruMapelKelas $guruMapelKela)
    {
        $gurus = User::whereHas('roles', function ($query) {
            $query->where('slug', 'guru');
        })->orderBy('name')->get();

        $mataPelajarans = MataPelajaran::orderBy('nama')->get();
        $kelas = Kelas::orderBy('nama')->get();
        $tahunAjaranList = TahunAjaran::orderBy('tahun', 'desc')->get();

        return view('akademik.guru-mapel-kelas.edit', [
            'title' => 'Edit Penugasan Guru',
            'assignment' => $guruMapelKela,
            'gurus' => $gurus,
            'mataPelajarans' => $mataPelajarans,
            'kelas' => $kelas,
            'tahunAjaranList' => $tahunAjaranList,
        ]);
    }

    public function update(Request $request, GuruMapelKelas $guruMapelKela)
    {
        $validated = $request->validate([
            'guru_id' => 'required|exists:users,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        ]);

        $exists = GuruMapelKelas::where('guru_id', $validated['guru_id'])
            ->where('mata_pelajaran_id', $validated['mata_pelajaran_id'])
            ->where('kelas_id', $validated['kelas_id'])
            ->where('tahun_ajaran_id', $validated['tahun_ajaran_id'])
            ->where('id', '!=', $guruMapelKela->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withInput()
                ->withErrors(['error' => 'Penugasan ini sudah ada!']);
        }

        $guruMapelKela->update($validated);

        return redirect()->route('guru-mapel-kelas.index')
            ->with('success', 'Penugasan guru berhasil diperbarui.');
    }

    public function destroy(GuruMapelKelas $guruMapelKela)
    {
        $guruMapelKela->delete();

        return redirect()->route('guru-mapel-kelas.index')
            ->with('success', 'Penugasan guru berhasil dihapus.');
    }

    public function generate()
    {
        $result = $this->generator->generateAssignments();

        if ($result['success']) {
            return redirect()->route('guru-mapel-kelas.index')
                ->with('success', $result['message']);
        } else {
            return redirect()->back()
                ->with('error', $result['message']);
        }
    }

    public function clear()
    {
        $result = $this->generator->clearAllAssignments();

        if ($result['success']) {
            return redirect()->route('guru-mapel-kelas.index')
                ->with('success', $result['message']);
        } else {
            return redirect()->back()
                ->with('error', $result['message']);
        }
    }
}
