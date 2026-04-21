<?php

namespace Database\Seeders;

use App\Models\TimeSlot;
use Illuminate\Database\Seeder;

class TimeSlotSeeder extends Seeder
{
    public function run(): void
    {
        $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];

        foreach ($days as $day) {
            $slotIndex = 1;

            if ($day === 'senin') {
                TimeSlot::create([
                    'day' => $day,
                    'slot_index' => $slotIndex++,
                    'type' => 'ceremony',
                    'start_time' => '07:00',
                    'end_time' => '07:45',
                ]);
            }

            TimeSlot::create([
                'day' => $day,
                'slot_index' => $slotIndex++,
                'type' => 'teaching',
                'start_time' => $day === 'senin' ? '07:45' : '07:00',
                'end_time' => $day === 'senin' ? '08:30' : '07:45',
            ]);

            TimeSlot::create([
                'day' => $day,
                'slot_index' => $slotIndex++,
                'type' => 'teaching',
                'start_time' => $day === 'senin' ? '08:30' : '07:45',
                'end_time' => $day === 'senin' ? '09:15' : '08:30',
            ]);

            TimeSlot::create([
                'day' => $day,
                'slot_index' => $slotIndex++,
                'type' => 'teaching',
                'start_time' => $day === 'senin' ? '09:15' : '08:30',
                'end_time' => $day === 'senin' ? '10:00' : '09:15',
            ]);

            TimeSlot::create([
                'day' => $day,
                'slot_index' => $slotIndex++,
                'type' => 'break',
                'start_time' => $day === 'senin' ? '10:00' : '09:15',
                'end_time' => $day === 'senin' ? '10:15' : '09:30',
            ]);

            TimeSlot::create([
                'day' => $day,
                'slot_index' => $slotIndex++,
                'type' => 'teaching',
                'start_time' => $day === 'senin' ? '10:15' : '09:30',
                'end_time' => $day === 'senin' ? '11:00' : '10:15',
            ]);

            TimeSlot::create([
                'day' => $day,
                'slot_index' => $slotIndex++,
                'type' => 'teaching',
                'start_time' => $day === 'senin' ? '11:00' : '10:15',
                'end_time' => $day === 'senin' ? '11:45' : '11:00',
            ]);

            TimeSlot::create([
                'day' => $day,
                'slot_index' => $slotIndex++,
                'type' => 'teaching',
                'start_time' => $day === 'senin' ? '11:45' : '11:00',
                'end_time' => $day === 'senin' ? '12:30' : '11:45',
            ]);

            TimeSlot::create([
                'day' => $day,
                'slot_index' => $slotIndex++,
                'type' => 'break',
                'start_time' => $day === 'senin' ? '12:30' : '11:45',
                'end_time' => $day === 'senin' ? '13:00' : '12:15',
            ]);

            TimeSlot::create([
                'day' => $day,
                'slot_index' => $slotIndex++,
                'type' => 'teaching',
                'start_time' => $day === 'senin' ? '13:00' : '12:15',
                'end_time' => $day === 'senin' ? '13:45' : '13:00',
            ]);

            TimeSlot::create([
                'day' => $day,
                'slot_index' => $slotIndex++,
                'type' => 'teaching',
                'start_time' => $day === 'senin' ? '13:45' : '13:00',
                'end_time' => $day === 'senin' ? '14:30' : '13:45',
            ]);
        }
    }
}
