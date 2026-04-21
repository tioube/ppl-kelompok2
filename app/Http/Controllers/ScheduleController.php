<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Kelas;
use App\Models\TimeSlot;
use App\Services\ScheduleGeneratorService;

class ScheduleController extends Controller
{
    protected $generator;

    public function __construct(ScheduleGeneratorService $generator)
    {
        $this->generator = $generator;
    }

    public function index(Request $request)
    {
        $kelasList = Kelas::orderBy('nama')->get();
        $selectedKelasId = $request->get('kelas_id');

        $schedules = null;
        $timeSlotsByDay = null;

        if ($selectedKelasId) {
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
            'timeSlotsByDay' => $timeSlotsByDay
        ]);
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id'
        ]);

        $kelas = Kelas::findOrFail($validated['kelas_id']);
        $result = $this->generator->generateScheduleForKelas($kelas);

        if ($result['success']) {
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
            'kelas_id' => 'required|exists:kelas,id'
        ]);

        Schedule::where('kelas_id', $validated['kelas_id'])->delete();

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
        $targetSlot = \App\Models\TimeSlot::findOrFail($validated['target_slot_id']);

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

            return redirect()->route('schedules.index', ['kelas_id' => $validated['kelas_id']])
                ->with('success', 'Jadwal berhasil ditukar posisi!');
        } else {
            $schedule->time_slot_id = $validated['target_slot_id'];
            $schedule->save();

            return redirect()->route('schedules.index', ['kelas_id' => $validated['kelas_id']])
                ->with('success', 'Jadwal berhasil dipindahkan!');
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'time_slot_id' => 'required|exists:time_slots,id',
            'mata_pelajaran_id' => 'nullable|exists:mata_pelajaran,id',
            'guru_id' => 'nullable|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $schedule = Schedule::findOrFail($id);

        $newTimeSlot = TimeSlot::findOrFail($validated['time_slot_id']);

        if ($newTimeSlot->type !== 'teaching') {
            return redirect()->back()
                ->with('error', 'Tidak bisa memindahkan ke slot non-pengajaran!');
        }

        $conflictCheck = Schedule::where('time_slot_id', $validated['time_slot_id'])
            ->where('kelas_id', $schedule->kelas_id)
            ->where('id', '!=', $id)
            ->exists();

        if ($conflictCheck) {
            return redirect()->back()
                ->with('error', 'Slot waktu ini sudah terisi!');
        }

        $mataPelajaranId = $validated['mata_pelajaran_id'] ?? $schedule->mata_pelajaran_id;
        $mataPelajaran = \App\Models\MataPelajaran::find($mataPelajaranId);

        if ($mataPelajaran) {
            $oldTimeSlot = $schedule->timeSlot;

            if ($newTimeSlot->day !== $oldTimeSlot->day) {
                $dailyCount = Schedule::where('kelas_id', $schedule->kelas_id)
                    ->where('mata_pelajaran_id', $mataPelajaran->id)
                    ->where('id', '!=', $id)
                    ->whereHas('timeSlot', function($query) use ($newTimeSlot) {
                        $query->where('day', $newTimeSlot->day);
                    })
                    ->count();

                if ($dailyCount >= $mataPelajaran->max_per_day) {
                    return redirect()->back()
                        ->with('error', "Mata pelajaran {$mataPelajaran->nama} sudah mencapai batas per hari ({$mataPelajaran->max_per_day} JP) untuk hari {$newTimeSlot->day}!");
                }
            }
        }

        $schedule->update($validated);

        return redirect()->route('schedules.index', ['kelas_id' => $validated['kelas_id']])
            ->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function edit($id)
    {
        $schedule = Schedule::with(['kelas', 'timeSlot', 'mataPelajaran', 'guru'])->findOrFail($id);
        $timeSlots = TimeSlot::where('type', 'teaching')->orderBy('day')->orderBy('slot_index')->get();
        $mataPelajarans = \App\Models\MataPelajaran::orderBy('nama')->get();
        $gurus = \App\Models\User::whereHas('roles', function($query) {
            $query->where('slug', 'guru');
        })->orderBy('name')->get();

        return view('akademik.schedules.edit', compact('schedule', 'timeSlots', 'mataPelajarans', 'gurus'));
    }

    public function create(Request $request)
    {
        $kelasId = $request->get('kelas_id');
        $slotId = $request->get('slot_id');

        if (!$kelasId || !$slotId) {
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

        $assignments = \App\Models\GuruMapelKelas::where('kelas_id', $kelasId)
            ->with(['guru', 'mataPelajaran'])
            ->get();

        return view('akademik.schedules.create', compact('kelas', 'timeSlot', 'assignments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'time_slot_id' => 'required|exists:time_slots,id',
            'guru_mapel_kelas_id' => 'required|exists:guru_mapel_kelas,id',
        ]);

        $assignment = \App\Models\GuruMapelKelas::findOrFail($validated['guru_mapel_kelas_id']);

        if ($assignment->kelas_id != $validated['kelas_id']) {
            return redirect()->back()
                ->with('error', 'Penugasan tidak sesuai dengan kelas!');
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

        $weeklyCount = Schedule::where('kelas_id', $validated['kelas_id'])
            ->where('mata_pelajaran_id', $mataPelajaran->id)
            ->count();

        if ($weeklyCount >= $mataPelajaran->jam_pelajaran) {
            return redirect()->back()
                ->with('error', "Mata pelajaran {$mataPelajaran->nama} sudah mencapai batas jam pelajaran per minggu ({$mataPelajaran->jam_pelajaran} JP)!");
        }

        $dailyCount = Schedule::where('kelas_id', $validated['kelas_id'])
            ->where('mata_pelajaran_id', $mataPelajaran->id)
            ->whereHas('timeSlot', function($query) use ($timeSlot) {
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

        return redirect()->route('schedules.index', ['kelas_id' => $validated['kelas_id']])
            ->with('success', 'Jadwal berhasil ditambahkan!');
    }
}
