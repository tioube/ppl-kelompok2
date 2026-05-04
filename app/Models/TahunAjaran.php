<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajaran';

    protected $fillable = [
        'tahun',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function siswaTahunAjaran(): HasMany
    {
        return $this->hasMany(SiswaTahunAjaran::class);
    }

    public function siswaList(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'siswa_tahun_ajaran', 'tahun_ajaran_id', 'user_id')
            ->withPivot(['kelas_id', 'jurusan_id', 'status', 'nomor_induk_sekolah', 'catatan'])
            ->withTimestamps();
    }

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

    public function mataPelajaranPivot(): HasMany
    {
        return $this->hasMany(MataPelajaranTahunAjaran::class);
    }

    public function mataPelajaranList(): BelongsToMany
    {
        return $this->belongsToMany(
            MataPelajaran::class,
            'mata_pelajaran_tahun_ajaran',
            'tahun_ajaran_id',
            'mata_pelajaran_id'
        )
            ->withPivot(['is_active', 'jam_pelajaran_override', 'catatan'])
            ->withTimestamps();
    }

    public function mataPelajaranAktif()
    {
        return $this->mataPelajaranList()->wherePivot('is_active', true);
    }

    public function getSiswaByKelas($kelasId)
    {
        return $this->siswaTahunAjaran()
            ->where('kelas_id', $kelasId)
            ->where('status', 'aktif')
            ->with(['siswa', 'jurusan'])
            ->get();
    }

    public function getSiswaByJurusan($jurusanId)
    {
        return $this->siswaTahunAjaran()
            ->where('jurusan_id', $jurusanId)
            ->where('status', 'aktif')
            ->with(['siswa', 'kelas'])
            ->get();
    }

    public function getStatistik()
    {
        return [
            'total_siswa' => $this->siswaTahunAjaran()->where('status', 'aktif')->count(),
            'per_kelas' => $this->siswaTahunAjaran()
                ->where('status', 'aktif')
                ->select('kelas_id', DB::raw('count(*) as total'))
                ->groupBy('kelas_id')
                ->with('kelas')
                ->get(),
            'per_jurusan' => $this->siswaTahunAjaran()
                ->where('status', 'aktif')
                ->select('jurusan_id', DB::raw('count(*) as total'))
                ->groupBy('jurusan_id')
                ->with('jurusan')
                ->get(),
        ];
    }

    public static function getAktif(): ?self
    {
        return static::where('is_active', true)->first();
    }
}
