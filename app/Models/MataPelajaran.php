<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function guruMapelKelas(): HasMany
    {
        return $this->hasMany(GuruMapelKelas::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function silabus(): HasMany
    {
        return $this->hasMany(Silabus::class);
    }

    public function tahunAjaranPivot(): HasMany
    {
        return $this->hasMany(MataPelajaranTahunAjaran::class);
    }

    public function tahunAjaranList(): BelongsToMany
    {
        return $this->belongsToMany(
            TahunAjaran::class,
            'mata_pelajaran_tahun_ajaran',
            'mata_pelajaran_id',
            'tahun_ajaran_id'
        )
            ->withPivot(['is_active', 'jam_pelajaran_override', 'catatan'])
            ->withTimestamps();
    }

    public function isActiveInTahunAjaran($tahunAjaranId): bool
    {
        return $this->tahunAjaranPivot()
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->where('is_active', true)
            ->exists();
    }

    public function getJamPelajaranForTahunAjaran($tahunAjaranId): int
    {
        $pivot = $this->tahunAjaranPivot()
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->first();

        return $pivot?->jam_pelajaran_override ?? $this->jam_pelajaran ?? 2;
    }

    public function scopeActiveInTahunAjaran($query, $tahunAjaranId)
    {
        return $query->whereHas('tahunAjaranPivot', function ($q) use ($tahunAjaranId) {
            $q->where('tahun_ajaran_id', $tahunAjaranId)
                ->where('is_active', true);
        });
    }

    public function scopeActiveInCurrentTahunAjaran($query)
    {
        $tahunAjaranAktif = TahunAjaran::getAktif();
        if (! $tahunAjaranAktif) {
            return $query->whereRaw('1 = 0');
        }

        return $query->activeInTahunAjaran($tahunAjaranAktif->id);
    }

    public function silabusAktif()
    {
        return $this->hasMany(Silabus::class)->active()->approved();
    }

    public function silabusFormatif()
    {
        return $this->hasMany(Silabus::class)->formatif()->active()->approved();
    }

    public function silabusSumatif()
    {
        return $this->hasMany(Silabus::class)->sumatif()->active()->approved();
    }
}
