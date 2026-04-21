<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Http\Request;

class JadwalPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $kelasList = Kelas::orderBy('nama')->get();
        $tahunAjaranList = TahunAjaran::orderBy('tahun', 'desc')->get();

        $query = JadwalPelajaran::with(['tahunAjaran', 'mataPelajaran', 'kelas', 'guru']);

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('tahun_ajaran_id')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        }

        $jadwalPelajarans = $query->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
            ->orderBy('jam_mulai')
            ->paginate(50)
            ->appends($request->only(['kelas_id', 'tahun_ajaran_id']));

        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        $selectedKelas = $request->kelas_id ? Kelas::find($request->kelas_id) : null;

        return view('akademik.jadwal-pelajaran.index', compact(
            'jadwalPelajarans',
            'kelasList',
            'tahunAjaranList',
            'days',
            'selectedKelas'
        ));
    }

    public function create()
    {
        $tahunAjarans = TahunAjaran::all();
        $mataPelajarans = MataPelajaran::all();
        $kelas = Kelas::all();
        $gurus = User::whereHas('roles', function ($query) {
            $query->where('slug', 'guru');
        })->with('mataPelajaran')->orderBy('name')->get();

        return view('akademik.jadwal-pelajaran.create', compact('tahunAjarans', 'mataPelajarans', 'kelas', 'gurus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'guru_id' => 'nullable|exists:users,id',
            'hari' => 'required|string|max:255',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        // Check time slot conflict for this kelas
        $conflict = JadwalPelajaran::where('kelas_id', $validated['kelas_id'])
            ->where('tahun_ajaran_id', $validated['tahun_ajaran_id'])
            ->where('hari', $validated['hari'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('jam_mulai', [$validated['jam_mulai'], $validated['jam_selesai']])
                    ->orWhereBetween('jam_selesai', [$validated['jam_mulai'], $validated['jam_selesai']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('jam_mulai', '<=', $validated['jam_mulai'])
                            ->where('jam_selesai', '>=', $validated['jam_selesai']);
                    });
            })->exists();

        if ($conflict) {
            return redirect()->back()->withInput()
                ->withErrors(['jam_mulai' => 'Jadwal bentrok! Kelas sudah memiliki jadwal pada waktu yang sama.']);
        }

        // Check jam_pelajaran weekly limit
        $mapel = MataPelajaran::find($validated['mata_pelajaran_id']);
        $weeklyCount = JadwalPelajaran::where('kelas_id', $validated['kelas_id'])
            ->where('tahun_ajaran_id', $validated['tahun_ajaran_id'])
            ->where('mata_pelajaran_id', $validated['mata_pelajaran_id'])
            ->count();

        if ($weeklyCount >= $mapel->jam_pelajaran) {
            return redirect()->back()->withInput()
                ->withErrors(['mata_pelajaran_id' => "Batas jam pelajaran tercapai! {$mapel->nama} hanya boleh {$mapel->jam_pelajaran} slot per minggu per kelas. Saat ini sudah ada {$weeklyCount} slot."]);
        }

        JadwalPelajaran::create($validated);

        return redirect()->route('jadwal-pelajaran.index')
            ->with('success', 'Jadwal Pelajaran berhasil ditambahkan.');
    }

    public function edit(JadwalPelajaran $jadwalPelajaran)
    {
        $tahunAjarans = TahunAjaran::all();
        $mataPelajarans = MataPelajaran::all();
        $kelas = Kelas::all();
        $gurus = User::whereHas('roles', function ($query) {
            $query->where('slug', 'guru');
        })->with('mataPelajaran')->orderBy('name')->get();

        return view('akademik.jadwal-pelajaran.edit', compact('jadwalPelajaran', 'tahunAjarans', 'mataPelajarans', 'kelas', 'gurus'));
    }

    public function update(Request $request, JadwalPelajaran $jadwalPelajaran)
    {
        $validated = $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'guru_id' => 'nullable|exists:users,id',
            'hari' => 'required|string|max:255',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        // Check time slot conflict (exclude self)
        $conflict = JadwalPelajaran::where('kelas_id', $validated['kelas_id'])
            ->where('tahun_ajaran_id', $validated['tahun_ajaran_id'])
            ->where('hari', $validated['hari'])
            ->where('id', '!=', $jadwalPelajaran->id)
            ->where(function ($query) use ($validated) {
                $query->whereBetween('jam_mulai', [$validated['jam_mulai'], $validated['jam_selesai']])
                    ->orWhereBetween('jam_selesai', [$validated['jam_mulai'], $validated['jam_selesai']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('jam_mulai', '<=', $validated['jam_mulai'])
                            ->where('jam_selesai', '>=', $validated['jam_selesai']);
                    });
            })->exists();

        if ($conflict) {
            return redirect()->back()->withInput()
                ->withErrors(['jam_mulai' => 'Jadwal bentrok! Kelas sudah memiliki jadwal pada waktu yang sama.']);
        }

        // Check jam_pelajaran weekly limit (exclude self)
        $mapel = MataPelajaran::find($validated['mata_pelajaran_id']);
        $weeklyCount = JadwalPelajaran::where('kelas_id', $validated['kelas_id'])
            ->where('tahun_ajaran_id', $validated['tahun_ajaran_id'])
            ->where('mata_pelajaran_id', $validated['mata_pelajaran_id'])
            ->where('id', '!=', $jadwalPelajaran->id)
            ->count();

        if ($weeklyCount >= $mapel->jam_pelajaran) {
            return redirect()->back()->withInput()
                ->withErrors(['mata_pelajaran_id' => "Batas jam pelajaran tercapai! {$mapel->nama} hanya boleh {$mapel->jam_pelajaran} slot per minggu per kelas. Saat ini sudah ada {$weeklyCount} slot."]);
        }

        $jadwalPelajaran->update($validated);

        return redirect()->route('jadwal-pelajaran.index')
            ->with('success', 'Jadwal Pelajaran berhasil diperbarui.');
    }

    public function destroy(JadwalPelajaran $jadwalPelajaran)
    {
        $jadwalPelajaran->delete();

        return redirect()->route('jadwal-pelajaran.index')
            ->with('success', 'Jadwal Pelajaran berhasil dihapus.');
    }
}
