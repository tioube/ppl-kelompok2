<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SiswaTahunAjaran extends Model
{
    protected $table = 'siswa_tahun_ajaran';

    protected $fillable = [
        'user_id',
        'tahun_ajaran_id',
        'kelas_id',
        'jurusan_id',
        'status',
        'nomor_induk_sekolah',
        'catatan',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeTahunAjaranAktif($query)
    {
        return $query->whereHas('tahunAjaran', fn($q) => $q->where('is_active', true));
    }

    public function scopeByKelas($query, $kelasId)
    {
        return $query->where('kelas_id', $kelasId);
    }

    public function scopeByJurusan($query, $jurusanId)
    {
        return $query->where('jurusan_id', $jurusanId);
    }

    public function scopeByTahunAjaran($query, $tahunAjaranId)
    {
        return $query->where('tahun_ajaran_id', $tahunAjaranId);
    }

    public static function getStatusOptions(): array
    {
        return [
            'aktif' => 'Aktif',
            'naik_kelas' => 'Naik Kelas',
            'lulus' => 'Lulus',
            'pindah' => 'Pindah',
            'dikeluarkan' => 'Dikeluarkan',
            'cuti' => 'Cuti',
        ];
    }
}

