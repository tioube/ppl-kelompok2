<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Traits\Auditable;

class Kelas extends Model
{
    use Auditable;

    protected $table = 'kelas';

    protected $fillable = [
        'nama',
        'jurusan_id',
    ];

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function guruMapelKelas(): HasMany
    {
        return $this->hasMany(GuruMapelKelas::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function siswaTahunAjaran(): HasMany
    {
        return $this->hasMany(SiswaTahunAjaran::class);
    }
}
