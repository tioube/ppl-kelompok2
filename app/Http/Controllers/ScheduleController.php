<?php

namespace App\Http\Controllers;

use App\Models\GuruMapelKelas;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Schedule;
use App\Models\TimeSlot;
use App\Models\User;
use App\Services\ScheduleJadwalSyncService;
use App\Services\ScheduleGeneratorService;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    protected $generator;

    protected $scheduleJadwalSyncService;

    public function __construct(ScheduleGeneratorService $generator, ScheduleJadwalSyncService $scheduleJadwalSyncService)
    {
        $this->generator = $generator;
        $this->scheduleJadwalSyncService = $scheduleJadwalSyncService;
    }

    public function index(Request $request)
    {
        $kelasList = Kelas::orderBy('nama')->get();
        $selectedKelasId = $request->get('kelas_id');

        $schedules = null;
        $timeSlotsByDay = null;
        $hasAssignments = false;

        if ($selectedKelasId) {
            $hasAssignments = GuruMapelKelas::where('kelas_id', $selectedKelasId)->exists();

            $schedules = Schedule::where('kelas_id', $selectedKelasId)
                ->with(['timeSlot', 'mataPelajaran', 'guru'])
                ->get()
                ->keyBy('time_slot_id');

            $timeSlotsByDay = TimeSlot::orderBy('day')
                ->orderBy('slot_index')
                ->get()
                ->groupBy('day');
        }

        return view('akademik.schedules.index', [
            'title' => 'Jadwal Pelajaran Baru',
            'kelasList' => $kelasList,
            'selectedKelasId' => $selectedKelasId,
            'schedules' => $schedules,
            'timeSlotsByDay' => $timeSlotsByDay,
            'hasAssignments' => $hasAssignments,
        ]);
    }

    public function generate(Request $request)
    {
        // Deprecated path: kept for backward compatibility with existing workflow.
        // Preferred flow is manual schedule management from schedules table edit mode.
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $hasAssignments = GuruMapelKelas::where('kelas_id', $validated['kelas_id'])->exists();
        if (! $hasAssignments) {
            return redirect()->route('schedules.index', ['kelas_id' => $validated['kelas_id']])
                ->with('error', 'Sebelum mengelola jadwal, tambahkan dulu Penugasan Guru untuk kelas ini.');
        }

        $kelas = Kelas::findOrFail($validated['kelas_id']);
        $result = $this->generator->generateScheduleForKelas($kelas);

        if ($result['success']) {
            $this->scheduleJadwalSyncService->syncActiveJadwalFromSchedules((int) $kelas->id);

            return redirect()->route('schedules.index', ['kelas_id' => $kelas->id])
                ->with('success', $result['message']);
        } else {
            return redirect()->back()
                ->with('error', $result['message']);
        }
    }

    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        Schedule::where('kelas_id', $validated['kelas_id'])->delete();
        $this->scheduleJadwalSyncService->syncActiveJadwalFromSchedules((int) $validated['kelas_id']);

        return redirect()->route('schedules.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }

    public function swap(Request $request)
    {
        $validated = $request->validate([
            'schedule1_id' => 'required|exists:schedules,id',
            'schedule2_id' => 'required|exists:schedules,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $schedule1 = Schedule::findOrFail($validated['schedule1_id']);
        $schedule2 = Schedule::findOrFail($validated['schedule2_id']);

        $tempTimeSlotId = $schedule1->time_slot_id;
        $schedule1->time_slot_id = $schedule2->time_slot_id;
        $schedule2->time_slot_id = $tempTimeSlotId;

        $schedule1->save();
        $schedule2->save();
        $this->scheduleJadwalSyncService->syncActiveJadwalFromSchedules((int) $validated['kelas_id']);

        return redirect()->route('schedules.index', ['kelas_id' => $validated['kelas_id']])
            ->with('success', 'Jadwal berhasil ditukar!');
    }

    public function moveToSlot(Request $request)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'target_slot_id' => 'required|exists:time_slots,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $schedule = Schedule::findOrFail($validated['schedule_id']);
        $targetSlot = TimeSlot::findOrFail($validated['target_slot_id']);

        if ($targetSlot->type !== 'teaching') {
            return redirect()->back()
                ->with('error', 'Tidak bisa memindahkan ke slot non-pengajaran!');
        }

        $existingSchedule = Schedule::where('kelas_id', $schedule->kelas_id)
            ->where('time_slot_id', $validated['target_slot_id'])
            ->first();

        if ($existingSchedule) {
            $tempTimeSlotId = $schedule->time_slot_id;
            $schedule->time_slot_id = $existingSchedule->time_slot_id;
            $existingSchedule->time_slot_id = $tempTimeSlotId;

            $schedule->save();
            $existingSchedule->save();
            $this->scheduleJadwalSyncService->syncActiveJadwalFromSchedules((int) $validated['kelas_id']);

            return redirect()->route('schedules.index', ['kelas_id' => $validated['kelas_id']])
                ->with('success', 'Jadwal berhasil ditukar posisi!');
        } else {
            $schedule->time_slot_id = $validated['target_slot_id'];
            $schedule->save();
            $this->scheduleJadwalSyncService->syncActiveJadwalFromSchedules((int) $validated['kelas_id']);

            return redirect()->route('schedules.index', ['kelas_id' => $validated['kelas_id']])
                ->with('success', 'Jadwal berhasil dipindahkan!');
        }
    }

    public function update(Request $request, $id)
    {
        $schedule = Schedule::with('timeSlot')->findOrFail($id);

        $validated = $request->validate([
            'time_slot_id' => 'required|exists:time_slots,id',
            'mata_pelajaran_id' => 'nullable|exists:mata_pelajaran,id',
            'guru_id' => 'nullable|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        if ((int) $validated['time_slot_id'] !== (int) $schedule->time_slot_id) {
            return redirect()->back()
                ->with('error', 'Waktu tidak dapat diubah dari halaman edit jadwal. Gunakan fitur pindah/tukar di tabel jadwal.');
        }

        // If both are empty, treat it as clearing the slot.
        if (empty($validated['mata_pelajaran_id']) && empty($validated['guru_id'])) {
            $schedule->delete();
            $this->scheduleJadwalSyncService->syncActiveJadwalFromSchedules((int) $validated['kelas_id']);

            return redirect()->route('schedules.index', ['kelas_id' => $validated['kelas_id']])
                ->with('success', 'Jadwal berhasil dikosongkan.');
        }

        if (empty($validated['mata_pelajaran_id']) || empty($validated['guru_id'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Mata pelajaran dan guru harus diisi bersamaan, atau kosongkan keduanya untuk menghapus jadwal.');
        }

        $newTimeSlot = $schedule->timeSlot;

        if ($newTimeSlot->type !== 'teaching') {
            return redirect()->back()
                ->with('error', 'Tidak bisa memindahkan ke slot non-pengajaran!');
        }

        $mataPelajaranId = $validated['mata_pelajaran_id'] ?? $schedule->mata_pelajaran_id;
        $mataPelajaran = MataPelajaran::find($mataPelajaranId);

        if ($mataPelajaran) {
            $oldTimeSlot = $schedule->timeSlot;

            if ($newTimeSlot->day !== $oldTimeSlot->day) {
                $dailyCount = Schedule::where('kelas_id', $schedule->kelas_id)
                    ->where('mata_pelajaran_id', $mataPelajaran->id)
                    ->where('id', '!=', $id)
                    ->whereHas('timeSlot', function ($query) use ($newTimeSlot) {
                        $query->where('day', $newTimeSlot->day);
                    })
                    ->count();

                if ($dailyCount >= $mataPelajaran->max_per_day) {
                    return redirect()->back()
                        ->with('error', "Mata pelajaran {$mataPelajaran->nama} sudah mencapai batas per hari ({$mataPelajaran->max_per_day} JP) untuk hari {$newTimeSlot->day}!");
                }
            }
        }

        $validated['time_slot_id'] = $schedule->time_slot_id;
        $schedule->update($validated);
        $this->scheduleJadwalSyncService->syncActiveJadwalFromSchedules((int) $validated['kelas_id']);

        return redirect()->route('schedules.index', ['kelas_id' => $validated['kelas_id']])
            ->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function edit($id)
    {
        $schedule = Schedule::with(['kelas', 'timeSlot', 'mataPelajaran', 'guru'])->findOrFail($id);
        $timeSlots = TimeSlot::where('type', 'teaching')->orderBy('day')->orderBy('slot_index')->get();
        $mataPelajarans = MataPelajaran::orderBy('nama')->get();
        $gurus = User::whereHas('roles', function ($query) {
            $query->where('slug', 'guru');
        })->orderBy('name')->get();

        return view('akademik.schedules.edit', compact('schedule', 'timeSlots', 'mataPelajarans', 'gurus'));
    }

    public function create(Request $request)
    {
        $kelasId = $request->get('kelas_id');
        $slotId = $request->get('slot_id');

        if (! $kelasId || ! $slotId) {
            return redirect()->route('schedules.index')
                ->with('error', 'Kelas dan slot harus dipilih!');
        }

        $kelas = Kelas::findOrFail($kelasId);
        $timeSlot = TimeSlot::findOrFail($slotId);

        if ($timeSlot->type !== 'teaching') {
            return redirect()->route('schedules.index', ['kelas_id' => $kelasId])
                ->with('error', 'Tidak bisa menambahkan jadwal ke slot non-pengajaran!');
        }

        $existingSchedule = Schedule::where('kelas_id', $kelasId)
            ->where('time_slot_id', $slotId)
            ->first();

        if ($existingSchedule) {
            return redirect()->route('schedules.index', ['kelas_id' => $kelasId])
                ->with('error', 'Slot ini sudah terisi!');
        }

        $usedMataPelajaranIds = Schedule::where('kelas_id', $kelasId)
            ->whereNotNull('mata_pelajaran_id')
            ->pluck('mata_pelajaran_id')
            ->unique()
            ->values();

        $hasAssignments = GuruMapelKelas::where('kelas_id', $kelasId)->exists();
        if (! $hasAssignments) {
            return redirect()->route('schedules.index', ['kelas_id' => $kelasId])
                ->with('error', 'Belum ada Penugasan Guru untuk kelas ini. Tambahkan dulu di menu Penugasan Guru.');
        }

        $assignments = GuruMapelKelas::where('kelas_id', $kelasId)
            ->whereNotIn('mata_pelajaran_id', $usedMataPelajaranIds)
            ->with(['guru', 'mataPelajaran'])
            ->get();

        $mataPelajarans = $assignments
            ->pluck('mataPelajaran')
            ->filter()
            ->unique('id')
            ->sortBy('nama')
            ->values();

        $gurus = $assignments
            ->pluck('guru')
            ->filter()
            ->unique('id')
            ->sortBy('name')
            ->values();

        return view('akademik.schedules.create', compact('kelas', 'timeSlot', 'assignments', 'mataPelajarans', 'gurus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'time_slot_id' => 'required|exists:time_slots,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'guru_id' => 'required|exists:users,id',
        ]);

        $assignment = GuruMapelKelas::where('kelas_id', $validated['kelas_id'])
            ->where('mata_pelajaran_id', $validated['mata_pelajaran_id'])
            ->where('guru_id', $validated['guru_id'])
            ->first();

        if (! $assignment) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Kombinasi guru dan mata pelajaran tidak valid untuk kelas ini.');
        }

        $timeSlot = TimeSlot::findOrFail($validated['time_slot_id']);

        if ($timeSlot->type !== 'teaching') {
            return redirect()->back()
                ->with('error', 'Tidak bisa menambahkan jadwal ke slot non-pengajaran!');
        }

        $existingSchedule = Schedule::where('kelas_id', $validated['kelas_id'])
            ->where('time_slot_id', $validated['time_slot_id'])
            ->first();

        if ($existingSchedule) {
            return redirect()->back()
                ->with('error', 'Slot waktu ini sudah terisi!');
        }

        $mataPelajaran = $assignment->mataPelajaran;

        $subjectExists = Schedule::where('kelas_id', $validated['kelas_id'])
            ->where('mata_pelajaran_id', $mataPelajaran->id)
            ->exists();

        if ($subjectExists) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Mata pelajaran {$mataPelajaran->nama} sudah ada di jadwal kelas ini.");
        }

        $weeklyCount = Schedule::where('kelas_id', $validated['kelas_id'])
            ->where('mata_pelajaran_id', $mataPelajaran->id)
            ->count();

        if ($weeklyCount >= $mataPelajaran->jam_pelajaran) {
            return redirect()->back()
                ->with('error', "Mata pelajaran {$mataPelajaran->nama} sudah mencapai batas jam pelajaran per minggu ({$mataPelajaran->jam_pelajaran} JP)!");
        }

        $dailyCount = Schedule::where('kelas_id', $validated['kelas_id'])
            ->where('mata_pelajaran_id', $mataPelajaran->id)
            ->whereHas('timeSlot', function ($query) use ($timeSlot) {
                $query->where('day', $timeSlot->day);
            })
            ->count();

        if ($dailyCount >= $mataPelajaran->max_per_day) {
            return redirect()->back()
                ->with('error', "Mata pelajaran {$mataPelajaran->nama} sudah mencapai batas per hari ({$mataPelajaran->max_per_day} JP) untuk hari {$timeSlot->day}!");
        }

        Schedule::create([
            'kelas_id' => $validated['kelas_id'],
            'time_slot_id' => $validated['time_slot_id'],
            'mata_pelajaran_id' => $assignment->mata_pelajaran_id,
            'guru_id' => $assignment->guru_id,
        ]);

        $this->scheduleJadwalSyncService->syncActiveJadwalFromSchedules((int) $validated['kelas_id']);

        return redirect()->route('schedules.index', ['kelas_id' => $validated['kelas_id']])
            ->with('success', 'Jadwal berhasil ditambahkan!');
    }
}
