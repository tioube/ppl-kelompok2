<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Silabus extends Model
{
    protected $table = 'silabus';

    protected $fillable = [
        'mata_pelajaran_id',
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

    // Relationships
    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Scopes
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

    // Helper methods
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
