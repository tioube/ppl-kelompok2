<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi extends Model
{
    protected $table = 'absensi';

    protected $fillable = [
        'jurnal_mengajar_id',
        'siswa_id',
        'siswa_tahun_ajaran_id',
        'status',
        'keterangan',
    ];

    public function jurnalMengajar(): BelongsTo
    {
        return $this->belongsTo(JurnalMengajar::class);
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function siswaTahunAjaran(): BelongsTo
    {
        return $this->belongsTo(SiswaTahunAjaran::class);
    }

    public function scopeHadir($query)
    {
        return $query->where('status', 'hadir');
    }

    public function scopeSakit($query)
    {
        return $query->where('status', 'sakit');
    }

    public function scopeIzin($query)
    {
        return $query->where('status', 'izin');
    }

    public function scopeAlfa($query)
    {
        return $query->where('status', 'alfa');
    }

    public function scopeBySiswa($query, $siswaId)
    {
        return $query->where('siswa_id', $siswaId);
    }

    public function scopeByTahunAjaran($query, $tahunAjaranId)
    {
        return $query->whereHas('siswaTahunAjaran', function ($q) use ($tahunAjaranId) {
            $q->where('tahun_ajaran_id', $tahunAjaranId);
        });
    }

    public static function getStatusOptions()
    {
        return [
            'hadir' => 'Hadir',
            'sakit' => 'Sakit',
            'izin' => 'Izin',
            'alfa' => 'Alfa',
        ];
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'hadir' => 'success',
            'sakit' => 'warning',
            'izin' => 'info',
            'alfa' => 'danger',
            default => 'secondary',
        };
    }
}
