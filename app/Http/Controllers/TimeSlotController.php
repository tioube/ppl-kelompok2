<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;
use Illuminate\Http\Request;

class TimeSlotController extends Controller
{
    protected array $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];

    protected array $types = ['teaching', 'break', 'ceremony'];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $timeSlots = TimeSlot::orderByRaw("FIELD(day, 'senin', 'selasa', 'rabu', 'kamis', 'jumat')")
            ->orderBy('slot_index')
            ->paginate(50);

        return view('akademik.time-slots.index', [
            'timeSlots' => $timeSlots,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('akademik.time-slots.create', [
            'days' => $this->days,
            'types' => $this->types,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'day' => 'required|in:'.implode(',', $this->days),
            'slot_index' => 'required|integer|min:1',
            'type' => 'required|in:'.implode(',', $this->types),
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $sameSlotIndexExists = TimeSlot::where('day', $validated['day'])
            ->where('slot_index', $validated['slot_index'])
            ->exists();

        if ($sameSlotIndexExists) {
            return redirect()->back()->withInput()
                ->withErrors(['slot_index' => 'Slot index untuk hari ini sudah digunakan.']);
        }

        $overlapExists = TimeSlot::where('day', $validated['day'])
            ->where('start_time', '<', $validated['end_time'])
            ->where('end_time', '>', $validated['start_time'])
            ->exists();

        if ($overlapExists) {
            return redirect()->back()->withInput()
                ->withErrors(['start_time' => 'Rentang waktu bentrok dengan slot lain pada hari yang sama.']);
        }

        TimeSlot::create($validated);

        return redirect()->route('time-slots.index')
            ->with('success', 'Time slot berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TimeSlot $timeSlot)
    {
        return redirect()->route('time-slots.edit', $timeSlot);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TimeSlot $timeSlot)
    {
        return view('akademik.time-slots.edit', [
            'timeSlot' => $timeSlot,
            'days' => $this->days,
            'types' => $this->types,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TimeSlot $timeSlot)
    {
        $validated = $request->validate([
            'day' => 'required|in:'.implode(',', $this->days),
            'slot_index' => 'required|integer|min:1',
            'type' => 'required|in:'.implode(',', $this->types),
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $sameSlotIndexExists = TimeSlot::where('day', $validated['day'])
            ->where('slot_index', $validated['slot_index'])
            ->where('id', '!=', $timeSlot->id)
            ->exists();

        if ($sameSlotIndexExists) {
            return redirect()->back()->withInput()
                ->withErrors(['slot_index' => 'Slot index untuk hari ini sudah digunakan.']);
        }

        $overlapExists = TimeSlot::where('day', $validated['day'])
            ->where('id', '!=', $timeSlot->id)
            ->where('start_time', '<', $validated['end_time'])
            ->where('end_time', '>', $validated['start_time'])
            ->exists();

        if ($overlapExists) {
            return redirect()->back()->withInput()
                ->withErrors(['start_time' => 'Rentang waktu bentrok dengan slot lain pada hari yang sama.']);
        }

        $timeSlot->update($validated);

        return redirect()->route('time-slots.index')
            ->with('success', 'Time slot berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TimeSlot $timeSlot)
    {
        if ($timeSlot->schedules()->exists()) {
            return redirect()->back()
                ->with('error', 'Time slot tidak bisa dihapus karena sudah dipakai pada jadwal otomatis.');
        }

        $timeSlot->delete();

        return redirect()->route('time-slots.index')
            ->with('success', 'Time slot berhasil dihapus.');
    }
}
