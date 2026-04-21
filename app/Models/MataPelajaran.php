<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'kategori',
        'jam_pelajaran',
        'preferred_block',
        'max_per_day',
    ];

    public function guruMapelKelas()
    {
        return $this->hasMany(GuruMapelKelas::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
