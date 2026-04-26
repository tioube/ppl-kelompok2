<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use App\Models\TimeSlot;
use App\Models\User;
use App\Services\ScheduleJadwalSyncService;
use Illuminate\Http\Request;

class JadwalPelajaranController extends Controller
{
    public function __construct(protected ScheduleJadwalSyncService $scheduleJadwalSyncService)
    {
    }

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
        $teachingSlots = TimeSlot::where('type', 'teaching')
            ->orderByRaw("FIELD(day, 'senin', 'selasa', 'rabu', 'kamis', 'jumat')")
            ->orderBy('slot_index')
            ->get();
        $gurus = User::whereHas('roles', function ($query) {
            $query->where('slug', 'guru');
        })->with('mataPelajaran')->orderBy('name')->get();

        return view('akademik.jadwal-pelajaran.create', compact('tahunAjarans', 'mataPelajarans', 'kelas', 'gurus', 'teachingSlots'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'guru_id' => 'nullable|exists:users,id',
            'time_slot_id' => 'required|exists:time_slots,id',
        ]);

        $timeSlot = TimeSlot::where('type', 'teaching')->find($validated['time_slot_id']);

        if (! $timeSlot) {
            return redirect()->back()->withInput()
                ->withErrors(['time_slot_id' => 'Slot waktu harus berupa slot pengajaran.']);
        }

        $validated['hari'] = ucfirst($timeSlot->day);
        $validated['jam_mulai'] = substr($timeSlot->start_time, 0, 5);
        $validated['jam_selesai'] = substr($timeSlot->end_time, 0, 5);
        unset($validated['time_slot_id']);

        // Check time slot conflict for this kelas
        $conflict = JadwalPelajaran::where('kelas_id', $validated['kelas_id'])
            ->where('tahun_ajaran_id', $validated['tahun_ajaran_id'])
            ->where('hari', $validated['hari'])
            ->where('jam_mulai', '<', $validated['jam_selesai'])
            ->where('jam_selesai', '>', $validated['jam_mulai'])
            ->exists();

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

        $this->scheduleJadwalSyncService->syncSchedulesFromJadwalIfActive(
            (int) $validated['kelas_id'],
            (int) $validated['tahun_ajaran_id']
        );

        return redirect()->route('jadwal-pelajaran.index')
            ->with('success', 'Jadwal Pelajaran berhasil ditambahkan.');
    }

    public function edit(JadwalPelajaran $jadwalPelajaran)
    {
        $tahunAjarans = TahunAjaran::all();
        $mataPelajarans = MataPelajaran::all();
        $kelas = Kelas::all();
        $teachingSlots = TimeSlot::where('type', 'teaching')
            ->orderByRaw("FIELD(day, 'senin', 'selasa', 'rabu', 'kamis', 'jumat')")
            ->orderBy('slot_index')
            ->get();
        $selectedTimeSlotId = TimeSlot::where('type', 'teaching')
            ->where('day', strtolower($jadwalPelajaran->hari))
            ->whereTime('start_time', $jadwalPelajaran->jam_mulai)
            ->whereTime('end_time', $jadwalPelajaran->jam_selesai)
            ->value('id');
        $gurus = User::whereHas('roles', function ($query) {
            $query->where('slug', 'guru');
        })->with('mataPelajaran')->orderBy('name')->get();

        return view('akademik.jadwal-pelajaran.edit', compact('jadwalPelajaran', 'tahunAjarans', 'mataPelajarans', 'kelas', 'gurus', 'teachingSlots', 'selectedTimeSlotId'));
    }

    public function update(Request $request, JadwalPelajaran $jadwalPelajaran)
    {
        $validated = $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'kelas_id' => 'required|exists:kelas,id',
            'guru_id' => 'nullable|exists:users,id',
            'time_slot_id' => 'required|exists:time_slots,id',
        ]);

        $timeSlot = TimeSlot::where('type', 'teaching')->find($validated['time_slot_id']);

        if (! $timeSlot) {
            return redirect()->back()->withInput()
                ->withErrors(['time_slot_id' => 'Slot waktu harus berupa slot pengajaran.']);
        }

        $validated['hari'] = ucfirst($timeSlot->day);
        $validated['jam_mulai'] = substr($timeSlot->start_time, 0, 5);
        $validated['jam_selesai'] = substr($timeSlot->end_time, 0, 5);
        unset($validated['time_slot_id']);

        // Check time slot conflict (exclude self)
        $conflict = JadwalPelajaran::where('kelas_id', $validated['kelas_id'])
            ->where('tahun_ajaran_id', $validated['tahun_ajaran_id'])
            ->where('hari', $validated['hari'])
            ->where('id', '!=', $jadwalPelajaran->id)
            ->where('jam_mulai', '<', $validated['jam_selesai'])
            ->where('jam_selesai', '>', $validated['jam_mulai'])
            ->exists();

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

        $this->scheduleJadwalSyncService->syncSchedulesFromJadwalIfActive(
            (int) $validated['kelas_id'],
            (int) $validated['tahun_ajaran_id']
        );

        return redirect()->route('jadwal-pelajaran.index')
            ->with('success', 'Jadwal Pelajaran berhasil diperbarui.');
    }

    public function destroy(JadwalPelajaran $jadwalPelajaran)
    {
        $kelasId = (int) $jadwalPelajaran->kelas_id;
        $tahunAjaranId = (int) $jadwalPelajaran->tahun_ajaran_id;
        $jadwalPelajaran->delete();

        $this->scheduleJadwalSyncService->syncSchedulesFromJadwalIfActive($kelasId, $tahunAjaranId);

        return redirect()->route('jadwal-pelajaran.index')
            ->with('success', 'Jadwal Pelajaran berhasil dihapus.');
    }
}
