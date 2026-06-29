<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        if ($this->hasRevokedPermission($permission)) {
            return false;
        }

        return $this->hasPermissionThroughRole($permission) ||
            $this->hasPermissionDirect($permission) ||
            $this->hasPermissionThroughParent($permission);
    }

    public function hasPermissionThroughParent(string $permission): bool
    {
        $parentPermissions = $this->getParentPermissions($permission);

        foreach ($parentPermissions as $parentSlug) {
            if ($this->hasPermissionThroughRole($parentSlug) || $this->hasPermissionDirect($parentSlug)) {
                return true;
            }
        }

        return false;
    }

    public function hasRevokedPermission(string $permission): bool
    {
        if ($this->revokedPermissions()->where('slug', $permission)->exists()) {
            return true;
        }

        $parentPermissions = $this->getParentPermissions($permission);

        foreach ($parentPermissions as $parentSlug) {
            if ($this->revokedPermissions()->where('slug', $parentSlug)->exists()) {
                return true;
            }
        }

        return false;
    }

    protected function getParentPermissions(string $permission): array
    {
        $permissionHierarchy = [
            'view-users' => ['manage-users'],
            'create-users' => ['manage-users'],
            'edit-users' => ['manage-users'],
            'delete-users' => ['manage-users'],
            'manage-roles' => ['manage-users'],
            'manage-permissions' => ['manage-users'],

            'view-mata-pelajaran' => ['manage-mata-pelajaran'],
            'create-mata-pelajaran' => ['manage-mata-pelajaran'],
            'edit-mata-pelajaran' => ['manage-mata-pelajaran'],
            'delete-mata-pelajaran' => ['manage-mata-pelajaran'],

            'view-silabus' => ['manage-silabus'],
            'create-silabus' => ['manage-silabus'],
            'edit-silabus' => ['manage-silabus'],
            'delete-silabus' => ['manage-silabus'],
            'approve-silabus' => ['manage-silabus'],

            'view-siswa' => ['manage-siswa'],
            'create-siswa' => ['manage-siswa'],
            'edit-siswa' => ['manage-siswa'],
            'delete-siswa' => ['manage-siswa'],

            'view-guru' => ['manage-guru'],
            'create-guru' => ['manage-guru'],
            'edit-guru' => ['manage-guru'],
            'delete-guru' => ['manage-guru'],

            'view-tahun-ajaran' => ['manage-tahun-ajaran'],
            'create-tahun-ajaran' => ['manage-tahun-ajaran'],
            'edit-tahun-ajaran' => ['manage-tahun-ajaran'],
            'delete-tahun-ajaran' => ['manage-tahun-ajaran'],

            'view-jurusan' => ['manage-jurusan'],
            'create-jurusan' => ['manage-jurusan'],
            'edit-jurusan' => ['manage-jurusan'],
            'delete-jurusan' => ['manage-jurusan'],

            'view-kelas' => ['manage-kelas'],
            'create-kelas' => ['manage-kelas'],
            'edit-kelas' => ['manage-kelas'],
            'delete-kelas' => ['manage-kelas'],

            'view-classes' => ['manage-classes'],
            'create-classes' => ['manage-classes'],
            'edit-classes' => ['manage-classes'],
            'delete-classes' => ['manage-classes'],

            'view-guru-mapel-kelas' => ['manage-guru-mapel-kelas'],
            'create-guru-mapel-kelas' => ['manage-guru-mapel-kelas'],
            'edit-guru-mapel-kelas' => ['manage-guru-mapel-kelas'],
            'delete-guru-mapel-kelas' => ['manage-guru-mapel-kelas'],
            'generate-guru-mapel-kelas' => ['manage-guru-mapel-kelas'],
            'clear-guru-mapel-kelas' => ['manage-guru-mapel-kelas'],

            'view-schedules' => ['manage-schedules'],
            'create-schedules' => ['manage-schedules'],
            'edit-schedules' => ['manage-schedules'],
            'delete-schedules' => ['manage-schedules'],
            'generate-schedules' => ['manage-schedules'],
            'swap-schedules' => ['manage-schedules'],
            'move-schedules' => ['manage-schedules'],

            'view-grades' => ['manage-grades'],
            'view-own-grades' => ['view-grades', 'manage-grades'],

            'view-attendance' => ['manage-attendance'],

            'view-jurnal-mengajar' => ['manage-jurnal-mengajar'],
            'create-jurnal-mengajar' => ['manage-jurnal-mengajar'],
            'edit-jurnal-mengajar' => ['manage-jurnal-mengajar'],
            'delete-jurnal-mengajar' => ['manage-jurnal-mengajar'],

            'view-kenaikan-kelas' => ['manage-kenaikan-kelas'],
            'process-kenaikan-kelas' => ['manage-kenaikan-kelas'],
            'manage-kelulusan' => ['manage-kenaikan-kelas'],

            'view-mapel-tahun-ajaran' => ['manage-mapel-tahun-ajaran'],

            'view-settings' => ['manage-settings'],

            'view-academic' => ['manage-academic'],
        ];

        return $permissionHierarchy[$permission] ?? [];
    }

    public function getChildPermissions(string $parentPermission): array
    {
        $childPermissions = [];

        $allPermissions = [
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            'manage-roles',
            'manage-permissions',
            'view-mata-pelajaran',
            'create-mata-pelajaran',
            'edit-mata-pelajaran',
            'delete-mata-pelajaran',
            'view-silabus',
            'create-silabus',
            'edit-silabus',
            'delete-silabus',
            'approve-silabus',
            'view-siswa',
            'create-siswa',
            'edit-siswa',
            'delete-siswa',
            'view-guru',
            'create-guru',
            'edit-guru',
            'delete-guru',
            'view-tahun-ajaran',
            'create-tahun-ajaran',
            'edit-tahun-ajaran',
            'delete-tahun-ajaran',
            'view-jurusan',
            'create-jurusan',
            'edit-jurusan',
            'delete-jurusan',
            'view-kelas',
            'create-kelas',
            'edit-kelas',
            'delete-kelas',
            'view-classes',
            'create-classes',
            'edit-classes',
            'delete-classes',
            'view-guru-mapel-kelas',
            'create-guru-mapel-kelas',
            'edit-guru-mapel-kelas',
            'delete-guru-mapel-kelas',
            'generate-guru-mapel-kelas',
            'clear-guru-mapel-kelas',
            'view-schedules',
            'create-schedules',
            'edit-schedules',
            'delete-schedules',
            'generate-schedules',
            'swap-schedules',
            'move-schedules',
            'view-grades',
            'view-own-grades',
            'view-attendance',
            'view-jurnal-mengajar',
            'create-jurnal-mengajar',
            'edit-jurnal-mengajar',
            'delete-jurnal-mengajar',
            'view-kenaikan-kelas',
            'process-kenaikan-kelas',
            'manage-kelulusan',
            'view-mapel-tahun-ajaran',
            'view-settings',
            'view-academic',
        ];

        foreach ($allPermissions as $perm) {
            $parents = $this->getParentPermissions($perm);
            if (in_array($parentPermission, $parents)) {
                $childPermissions[] = $perm;
            }
        }

        return $childPermissions;
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
            ->whereHas('tahunAjaran', fn ($q) => $q->where('is_active', true))
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
