<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuruMapelKelas extends Model
{
    protected $table = 'guru_mapel_kelas';

    protected $fillable = [
        'guru_id',
        'mata_pelajaran_id',
        'kelas_id',
    ];

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function jurnalMengajar()
    {
        return $this->hasMany(JurnalMengajar::class);
    }

    public function getSiswaInKelas()
    {
        return User::where('kelas_id', $this->kelas_id)
            ->whereHas('roles', function ($q) {
                $q->where('slug', 'siswa');
            })
            ->whereHas('tahunAjaran', function ($q) {
                $q->where('is_active', true);
            })
            ->orderBy('name')
            ->get();
    }
}
