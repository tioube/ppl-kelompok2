<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    protected $fillable = [
        'day',
        'slot_index',
        'type',
        'start_time',
        'end_time',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function isTeachingSlot()
    {
        return $this->type === 'teaching';
    }
}

