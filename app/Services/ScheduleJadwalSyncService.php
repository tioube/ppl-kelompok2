<?php

namespace App\Services;

use App\Models\JadwalPelajaran;
use App\Models\Schedule;
use App\Models\TahunAjaran;
use App\Models\TimeSlot;
use Illuminate\Support\Facades\DB;

class ScheduleJadwalSyncService
{
    public function syncSchedulesFromJadwalIfActive(int $kelasId, int $tahunAjaranId): void
    {
        $activeTahunAjaran = TahunAjaran::where('is_active', true)->first();

        if (! $activeTahunAjaran || $activeTahunAjaran->id !== $tahunAjaranId) {
            return;
        }

        $jadwalRows = JadwalPelajaran::where('kelas_id', $kelasId)
            ->where('tahun_ajaran_id', $activeTahunAjaran->id)
            ->get();

        $teachingSlots = TimeSlot::where('type', 'teaching')->get()->keyBy(function (TimeSlot $slot) {
            return $this->buildSlotKey($slot->day, $slot->start_time, $slot->end_time);
        });

        DB::transaction(function () use ($kelasId, $jadwalRows, $teachingSlots) {
            Schedule::where('kelas_id', $kelasId)->delete();

            foreach ($jadwalRows as $jadwal) {
                $slotKey = $this->buildSlotKey(
                    strtolower($jadwal->hari),
                    (string) $jadwal->jam_mulai,
                    (string) $jadwal->jam_selesai
                );

                $timeSlot = $teachingSlots->get($slotKey);
                if (! $timeSlot) {
                    continue;
                }

                Schedule::create([
                    'kelas_id' => $jadwal->kelas_id,
                    'time_slot_id' => $timeSlot->id,
                    'mata_pelajaran_id' => $jadwal->mata_pelajaran_id,
                    'guru_id' => $jadwal->guru_id,
                ]);
            }
        });
    }

    public function syncActiveJadwalFromSchedules(int $kelasId): void
    {
        $activeTahunAjaran = TahunAjaran::where('is_active', true)->first();

        if (! $activeTahunAjaran) {
            return;
        }

        $schedules = Schedule::where('kelas_id', $kelasId)
            ->with('timeSlot')
            ->get();

        DB::transaction(function () use ($kelasId, $activeTahunAjaran, $schedules) {
            JadwalPelajaran::where('kelas_id', $kelasId)
                ->where('tahun_ajaran_id', $activeTahunAjaran->id)
                ->delete();

            foreach ($schedules as $schedule) {
                $slot = $schedule->timeSlot;

                if (! $slot || $slot->type !== 'teaching' || ! $schedule->mata_pelajaran_id) {
                    continue;
                }

                JadwalPelajaran::create([
                    'tahun_ajaran_id' => $activeTahunAjaran->id,
                    'mata_pelajaran_id' => $schedule->mata_pelajaran_id,
                    'kelas_id' => $schedule->kelas_id,
                    'guru_id' => $schedule->guru_id,
                    'hari' => ucfirst($slot->day),
                    'jam_mulai' => substr((string) $slot->start_time, 0, 5),
                    'jam_selesai' => substr((string) $slot->end_time, 0, 5),
                ]);
            }
        });
    }

    private function buildSlotKey(string $day, string $startTime, string $endTime): string
    {
        return strtolower($day).'|'.substr($startTime, 0, 5).'|'.substr($endTime, 0, 5);
    }
}
