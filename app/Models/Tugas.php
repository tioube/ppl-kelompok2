<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'mata_pelajaran_id',
        'guru_id',
        'kelas_id',
        'deadline',
        'file_materi',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function pengumpulan()
    {
        return $this->hasMany(PengumpulanTugas::class);
    }

    public function pengumpulanSiswa($siswaId)
    {
        return $this->pengumpulan()->where('siswa_id', $siswaId)->first();
    }
}
