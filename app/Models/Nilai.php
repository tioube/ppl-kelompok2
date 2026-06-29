<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nilai extends Model
{
    use Auditable;

    protected $table = 'nilai';

    protected $fillable = [
        'siswa_id',
        'guru_mapel_kelas_id',
        'silabus_id',
        'nilai',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'nilai' => 'integer',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function guruMapelKelas(): BelongsTo
    {
        return $this->belongsTo(GuruMapelKelas::class, 'guru_mapel_kelas_id');
    }

    public function silabus(): BelongsTo
    {
        return $this->belongsTo(Silabus::class, 'silabus_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
