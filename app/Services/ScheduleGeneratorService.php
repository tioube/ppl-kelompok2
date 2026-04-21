<?php

namespace App\Services;

use App\Models\GuruMapelKelas;
use App\Models\Kelas;
use App\Models\Schedule;
use App\Models\TimeSlot;
use Illuminate\Support\Facades\DB;

class ScheduleGeneratorService
{
    private $maxUniqueSubjectsPerDay = 6;

    private $maxSlotsPerDay = 10;

    private $timeSlotsCache = [];

    public function generateScheduleForKelas(Kelas $kelas)
    {
        DB::beginTransaction();

        try {
            Schedule::where('kelas_id', $kelas->id)->delete();

            $assignments = GuruMapelKelas::where('kelas_id', $kelas->id)
                ->with(['mataPelajaran', 'guru'])
                ->get();

            $allTimeSlots = TimeSlot::all()->keyBy('id');
            $this->timeSlotsCache = $allTimeSlots;

            $teachingSlots = TimeSlot::where('type', 'teaching')
                ->orderBy('day')
                ->orderBy('slot_index')
                ->get()
                ->groupBy('day');

            $scheduleData = [];
            $mapelWeeklyCount = [];

            foreach ($assignments as $assignment) {
                $mapel = $assignment->mataPelajaran;
                $guru = $assignment->guru;
                $totalSlots = $mapel->jam_pelajaran;
                $preferredBlock = $mapel->preferred_block;
                $maxPerDay = $mapel->max_per_day;

                $mapelWeeklyCount[$mapel->id] = 0;

                $blocks = $this->splitIntoBlocks($totalSlots, $preferredBlock);

                foreach ($blocks as $blockSize) {
                    if ($mapelWeeklyCount[$mapel->id] >= $totalSlots) {
                        break;
                    }

                    $assigned = false;

                    foreach ($teachingSlots as $day => $slots) {
                        if ($assigned) {
                            break;
                        }

                        $dailyCount = $this->getDailyMapelCount($scheduleData, $day, $mapel->id);
                        if ($dailyCount + $blockSize > $maxPerDay) {
                            continue;
                        }

                        if ($totalSlots < $mapelWeeklyCount[$mapel->id] + $blockSize) {
                            continue;
                        }

                        $uniqueSubjectsToday = $this->getUniqueSubjectsCount($scheduleData, $day);
                        if ($uniqueSubjectsToday >= $this->maxUniqueSubjectsPerDay) {
                            continue;
                        }

                        $consecutiveSlots = $this->findConsecutiveSlots($scheduleData, $slots, $blockSize);

                        if ($consecutiveSlots) {
                            $guruAvailable = $this->isGuruAvailable($scheduleData, $guru->id, $consecutiveSlots);

                            if ($guruAvailable) {
                                foreach ($consecutiveSlots as $slot) {
                                    $scheduleData[] = [
                                        'kelas_id' => $kelas->id,
                                        'time_slot_id' => $slot->id,
                                        'mata_pelajaran_id' => $mapel->id,
                                        'guru_id' => $guru->id,
                                    ];
                                    $mapelWeeklyCount[$mapel->id]++;
                                }
                                $assigned = true;
                            }
                        }
                    }

                    if (! $assigned) {
                        foreach ($teachingSlots as $day => $slots) {
                            if ($assigned) {
                                break;
                            }

                            $dailyCount = $this->getDailyMapelCount($scheduleData, $day, $mapel->id);
                            if ($dailyCount + $blockSize > $maxPerDay) {
                                continue;
                            }

                            if ($totalSlots < $mapelWeeklyCount[$mapel->id] + $blockSize) {
                                continue;
                            }

                            $availableSlots = $this->findAvailableSlots($scheduleData, $slots, $blockSize, $guru->id);

                            if (count($availableSlots) >= $blockSize) {
                                $slotsToUse = $availableSlots->take($blockSize);

                                foreach ($slotsToUse as $slot) {
                                    $scheduleData[] = [
                                        'kelas_id' => $kelas->id,
                                        'time_slot_id' => $slot->id,
                                        'mata_pelajaran_id' => $mapel->id,
                                        'guru_id' => $guru->id,
                                    ];
                                    $mapelWeeklyCount[$mapel->id]++;
                                }
                                $assigned = true;
                            }
                        }
                    }
                }
            }

            foreach ($scheduleData as $data) {
                Schedule::create($data);
            }

            DB::commit();

            return [
                'success' => true,
                'message' => 'Jadwal berhasil digenerate untuk kelas '.$kelas->nama,
                'total_slots' => count($scheduleData),
            ];

        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => 'Gagal generate jadwal: '.$e->getMessage(),
            ];
        }
    }

    private function splitIntoBlocks($total, $preferredBlock)
    {
        $blocks = [];
        $remaining = $total;

        while ($remaining > 0) {
            if ($remaining >= $preferredBlock) {
                $blocks[] = $preferredBlock;
                $remaining -= $preferredBlock;
            } else {
                $blocks[] = $remaining;
                $remaining = 0;
            }
        }

        return $blocks;
    }

    private function getDailyMapelCount($scheduleData, $day, $mapelId)
    {
        $count = 0;
        foreach ($scheduleData as $schedule) {
            $timeSlot = $this->timeSlotsCache[$schedule['time_slot_id']] ?? null;
            if ($timeSlot && $timeSlot->day === $day && $schedule['mata_pelajaran_id'] === $mapelId) {
                $count++;
            }
        }

        return $count;
    }

    private function getUniqueSubjectsCount($scheduleData, $day)
    {
        $subjects = [];
        foreach ($scheduleData as $schedule) {
            $timeSlot = $this->timeSlotsCache[$schedule['time_slot_id']] ?? null;
            if ($timeSlot && $timeSlot->day === $day) {
                $subjects[$schedule['mata_pelajaran_id']] = true;
            }
        }

        return count($subjects);
    }

    private function findConsecutiveSlots($scheduleData, $slots, $blockSize)
    {
        $usedSlotIds = array_column($scheduleData, 'time_slot_id');
        $availableSlots = $slots->reject(function ($slot) use ($usedSlotIds) {
            return in_array($slot->id, $usedSlotIds);
        })->values();

        if (count($availableSlots) < $blockSize) {
            return null;
        }

        for ($i = 0; $i <= count($availableSlots) - $blockSize; $i++) {
            $consecutive = true;
            $expectedIndex = $availableSlots[$i]->slot_index;

            for ($j = 0; $j < $blockSize; $j++) {
                if (! isset($availableSlots[$i + $j]) || $availableSlots[$i + $j]->slot_index != $expectedIndex + $j) {
                    $consecutive = false;
                    break;
                }
            }

            if ($consecutive) {
                return $availableSlots->slice($i, $blockSize)->values();
            }
        }

        return null;
    }

    private function isGuruAvailable($scheduleData, $guruId, $slots)
    {
        $slotIds = $slots->pluck('id')->toArray();

        foreach ($scheduleData as $schedule) {
            if ($schedule['guru_id'] === $guruId && in_array($schedule['time_slot_id'], $slotIds)) {
                return false;
            }
        }

        return true;
    }

    private function findAvailableSlots($scheduleData, $slots, $blockSize, $guruId)
    {
        $usedSlotIds = array_column($scheduleData, 'time_slot_id');
        $guruSlotIds = [];

        foreach ($scheduleData as $schedule) {
            if ($schedule['guru_id'] === $guruId) {
                $guruSlotIds[] = $schedule['time_slot_id'];
            }
        }

        return $slots->reject(function ($slot) use ($usedSlotIds, $guruSlotIds) {
            return in_array($slot->id, $usedSlotIds) || in_array($slot->id, $guruSlotIds);
        })->values();
    }
}
