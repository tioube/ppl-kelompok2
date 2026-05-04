<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MataPelajaranTahunAjaran extends Model
{
    protected $table = 'mata_pelajaran_tahun_ajaran';

    protected $fillable = [
        'mata_pelajaran_id',
        'tahun_ajaran_id',
        'is_active',
        'jam_pelajaran_override',
        'catatan',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function getJamPelajaranAttribute(): int
    {
        return $this->jam_pelajaran_override
            ?? $this->mataPelajaran->jam_pelajaran
            ?? 2;
    }

    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByTahunAjaran($query, $tahunAjaranId)
    {
        return $query->where('tahun_ajaran_id', $tahunAjaranId);
    }

    public function scopeTahunAjaranAktif($query)
    {
        return $query->whereHas('tahunAjaran', fn($q) => $q->where('is_active', true));
    }
}

