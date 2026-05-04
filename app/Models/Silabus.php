<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Silabus extends Model
{
    protected $table = 'silabus';

    protected $fillable = [
        'mata_pelajaran_id',
        'tahun_ajaran_id',
        'tujuan_pembelajaran',
        'kategori',
        'status',
        'approval_status',
        'urutan',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'approved');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopePendingApproval($query)
    {
        return $query->where('approval_status', 'pending_approval');
    }

    public function scopeFormatif($query)
    {
        return $query->where('kategori', 'formatif');
    }

    public function scopeSumatif($query)
    {
        return $query->where('kategori', 'sumatif');
    }

    public function scopeByTahunAjaran($query, $tahunAjaranId)
    {
        return $query->where('tahun_ajaran_id', $tahunAjaranId);
    }

    public function scopeTahunAjaranAktif($query)
    {
        return $query->whereHas('tahunAjaran', fn ($q) => $q->where('is_active', true));
    }

    public function scopeForMapelAndTahunAjaran($query, $mataPelajaranId, $tahunAjaranId)
    {
        return $query->where('mata_pelajaran_id', $mataPelajaranId)
            ->where('tahun_ajaran_id', $tahunAjaranId);
    }

    public function canBeEdited()
    {
        return in_array($this->approval_status, ['draft', 'rejected']);
    }

    public function canBeDeleted()
    {
        return $this->approval_status !== 'approved' || $this->status !== 'aktif';
    }

    public function isEditable()
    {
        return $this->approval_status === 'draft' || $this->approval_status === 'rejected';
    }
}
