<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GuruMapelKelas;
use App\Models\User;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Services\GuruMapelKelasGeneratorService;

class GuruMapelKelasController extends Controller
{
    protected $generator;

    public function __construct(GuruMapelKelasGeneratorService $generator)
    {
        $this->generator = $generator;
    }
    public function index()
    {
        $assignments = GuruMapelKelas::with(['guru', 'mataPelajaran', 'kelas'])
            ->orderBy('kelas_id')
            ->paginate(15);

        return view('akademik.guru-mapel-kelas.index', [
            'title' => 'Penugasan Guru',
            'assignments' => $assignments
        ]);
    }

    public function create()
    {
        $gurus = User::whereHas('roles', function($query) {
            $query->where('slug', 'guru');
        })->orderBy('name')->get();

        $mataPelajarans = MataPelajaran::orderBy('nama')->get();
        $kelas = Kelas::orderBy('nama')->get();

        return view('akademik.guru-mapel-kelas.create', [
            'title' => 'Tambah Penugasan Guru',
            'gurus' => $gurus,
            'mataPelajarans' => $mataPelajarans,
            'kelas' => $kelas
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guru_id' => 'required|exists:users,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $exists = GuruMapelKelas::where('guru_id', $validated['guru_id'])
            ->where('mata_pelajaran_id', $validated['mata_pelajaran_id'])
            ->where('kelas_id', $validated['kelas_id'])
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
        $gurus = User::whereHas('roles', function($query) {
            $query->where('slug', 'guru');
        })->orderBy('name')->get();

        $mataPelajarans = MataPelajaran::orderBy('nama')->get();
        $kelas = Kelas::orderBy('nama')->get();

        return view('akademik.guru-mapel-kelas.edit', [
            'title' => 'Edit Penugasan Guru',
            'assignment' => $guruMapelKela,
            'gurus' => $gurus,
            'mataPelajarans' => $mataPelajarans,
            'kelas' => $kelas
        ]);
    }

    public function update(Request $request, GuruMapelKelas $guruMapelKela)
    {
        $validated = $request->validate([
            'guru_id' => 'required|exists:users,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $exists = GuruMapelKelas::where('guru_id', $validated['guru_id'])
            ->where('mata_pelajaran_id', $validated['mata_pelajaran_id'])
            ->where('kelas_id', $validated['kelas_id'])
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
