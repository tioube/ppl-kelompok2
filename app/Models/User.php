<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'kelas_id',
        'jurusan_id',
        'tahun_ajaran_id',
        'mata_pelajaran_id',
        'photo_profile',
        'nisn',
        'nip',
        'address',
        'phone',
        'birth_date',
        'gender',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user')->withTimestamps();
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_user')->withTimestamps();
    }

    public function revokedPermissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'user_revoked_permissions')->withTimestamps();
    }

    public function hasRole(string|array $roles): bool
    {
        if (is_array($roles)) {
            return $this->roles()->whereIn('slug', $roles)->exists();
        }

        return $this->roles()->where('slug', $roles)->exists();
    }

    public function hasPermission(string $permission): bool
    {
        // First, check if permission is explicitly revoked
        if ($this->hasRevokedPermission($permission)) {
            return false;
        }

        return $this->hasPermissionThroughRole($permission) ||
               $this->hasPermissionDirect($permission);
    }

    public function hasRevokedPermission(string $permission): bool
    {
        return $this->revokedPermissions()->where('slug', $permission)->exists();
    }

    public function hasPermissionThroughRole(string $permission): bool
    {
        foreach ($this->roles as $role) {
            if ($role->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    public function hasPermissionDirect(string $permission): bool
    {
        return $this->permissions()->where('slug', $permission)->exists();
    }

    public function assignRole(Role|string $role): void
    {
        if (is_string($role)) {
            $role = Role::where('slug', $role)->firstOrFail();
        }

        $this->roles()->syncWithoutDetaching($role);
    }

    public function removeRole(Role|string $role): void
    {
        if (is_string($role)) {
            $role = Role::where('slug', $role)->firstOrFail();
        }

        $this->roles()->detach($role);
    }

    public function givePermissionTo($permission): void
    {
        if (is_string($permission)) {
            $permission = Permission::where('slug', $permission)->firstOrFail();
        } elseif (is_array($permission)) {
            // Handle array of permissions
            foreach ($permission as $perm) {
                $this->givePermissionTo($perm);
            }

            return;
        }

        $this->permissions()->syncWithoutDetaching($permission);
    }

    public function revokePermissionTo($permission): void
    {
        if (is_string($permission)) {
            $permission = Permission::where('slug', $permission)->firstOrFail();
        } elseif (is_array($permission)) {
            // Handle array of permissions
            foreach ($permission as $perm) {
                $this->revokePermissionTo($perm);
            }

            return;
        }

        // Remove from direct permissions if exists
        $this->permissions()->detach($permission);

        // Add to revoked permissions to override role permissions
        $this->revokedPermissions()->syncWithoutDetaching($permission);
    }

    public function restorePermissionTo($permission): void
    {
        if (is_string($permission)) {
            $permission = Permission::where('slug', $permission)->firstOrFail();
        } elseif (is_array($permission)) {
            // Handle array of permissions
            foreach ($permission as $perm) {
                $this->restorePermissionTo($perm);
            }

            return;
        }

        // Remove from revoked permissions
        $this->revokedPermissions()->detach($permission);
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }

    public function siswaTahunAjaran(): HasMany
    {
        return $this->hasMany(SiswaTahunAjaran::class, 'user_id');
    }

    public function tahunAjaranList(): BelongsToMany
    {
        return $this->belongsToMany(TahunAjaran::class, 'siswa_tahun_ajaran', 'user_id', 'tahun_ajaran_id')
            ->withPivot(['kelas_id', 'jurusan_id', 'status', 'nomor_induk_sekolah', 'catatan'])
            ->withTimestamps();
    }

    public function getCurrentSiswaTahunAjaran(): ?SiswaTahunAjaran
    {
        return $this->siswaTahunAjaran()
            ->whereHas('tahunAjaran', fn($q) => $q->where('is_active', true))
            ->where('status', 'aktif')
            ->with(['tahunAjaran', 'kelas', 'jurusan'])
            ->first();
    }

    public function getSiswaTahunAjaranFor($tahunAjaranId): ?SiswaTahunAjaran
    {
        return $this->siswaTahunAjaran()
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->with(['tahunAjaran', 'kelas', 'jurusan'])
            ->first();
    }

    public function getCurrentKelas(): ?Kelas
    {
        return $this->getCurrentSiswaTahunAjaran()?->kelas;
    }

    public function getCurrentJurusan(): ?Jurusan
    {
        return $this->getCurrentSiswaTahunAjaran()?->jurusan;
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function guruMapelKelas(): HasMany
    {
        return $this->hasMany(GuruMapelKelas::class, 'guru_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'guru_id');
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }

    public function scopeSiswa($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('slug', 'siswa');
        });
    }

    public function scopeSiswaAktif($query)
    {
        return $query->siswa()
            ->whereHas('siswaTahunAjaran', function ($q) {
                $q->tahunAjaranAktif()->aktif();
            });
    }

    public function scopeByKelasAndTahunAjaran($query, $kelasId, $tahunAjaranId)
    {
        return $query->whereHas('siswaTahunAjaran', function ($q) use ($kelasId, $tahunAjaranId) {
            $q->where('kelas_id', $kelasId)
              ->where('tahun_ajaran_id', $tahunAjaranId)
              ->aktif();
        });
    }
}
