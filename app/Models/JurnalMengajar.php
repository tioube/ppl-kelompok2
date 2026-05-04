<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalMengajar extends Model
{
    protected $table = 'jurnal_mengajar';

    protected $fillable = [
        'guru_mapel_kelas_id',
        'silabus_id',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'catatan',
        'created_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function guruMapelKelas()
    {
        return $this->belongsTo(GuruMapelKelas::class);
    }

    public function silabus()
    {
        return $this->belongsTo(Silabus::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function getKelasAttribute()
    {
        return $this->guruMapelKelas?->kelas;
    }

    public function getMataPelajaranAttribute()
    {
        return $this->guruMapelKelas?->mataPelajaran;
    }

    public function getGuruAttribute()
    {
        return $this->guruMapelKelas?->guru;
    }

    public function scopeByGuru($query, $guruId)
    {
        return $query->whereHas('guruMapelKelas', function ($q) use ($guruId) {
            $q->where('guru_id', $guruId);
        });
    }

    public function scopeByKelas($query, $kelasId)
    {
        return $query->whereHas('guruMapelKelas', function ($q) use ($kelasId) {
            $q->where('kelas_id', $kelasId);
        });
    }

    public function scopeByMapel($query, $mapelId)
    {
        return $query->whereHas('guruMapelKelas', function ($q) use ($mapelId) {
            $q->where('mata_pelajaran_id', $mapelId);
        });
    }

    public function scopeByTanggal($query, $tanggal)
    {
        return $query->whereDate('tanggal', $tanggal);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal', [$startDate, $endDate]);
    }
}
