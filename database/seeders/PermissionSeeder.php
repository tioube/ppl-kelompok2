<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'View Dashboard', 'slug' => 'view-dashboard', 'description' => 'Access dashboard'],
            ['name' => 'Manage Users', 'slug' => 'manage-users', 'description' => 'Create, edit, delete users'],
            ['name' => 'View Users', 'slug' => 'view-users', 'description' => 'View user list'],
            ['name' => 'Manage Roles', 'slug' => 'manage-roles', 'description' => 'Create, edit, delete roles'],
            ['name' => 'Manage Permissions', 'slug' => 'manage-permissions', 'description' => 'Assign permissions'],
            ['name' => 'Manage Academic', 'slug' => 'manage-academic', 'description' => 'Manage academic data'],
            ['name' => 'View Academic', 'slug' => 'view-academic', 'description' => 'View academic data'],
            ['name' => 'Manage Classes', 'slug' => 'manage-classes', 'description' => 'Manage class data'],
            ['name' => 'View Classes', 'slug' => 'view-classes', 'description' => 'View class data'],
            ['name' => 'Manage Grades', 'slug' => 'manage-grades', 'description' => 'Input and edit grades'],
            ['name' => 'View Grades', 'slug' => 'view-grades', 'description' => 'View grades'],
            ['name' => 'View Own Grades', 'slug' => 'view-own-grades', 'description' => 'View own grades only'],
            ['name' => 'Manage Attendance', 'slug' => 'manage-attendance', 'description' => 'Manage attendance'],
            ['name' => 'View Attendance', 'slug' => 'view-attendance', 'description' => 'View attendance'],
            ['name' => 'View Settings', 'slug' => 'view-settings', 'description' => 'View settings'],
            ['name' => 'Manage Settings', 'slug' => 'manage-settings', 'description' => 'Edit system settings'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }

        $superAdmin = Role::where('slug', 'super-admin')->first();
        if ($superAdmin) {
            $superAdmin->permissions()->sync(Permission::all());
        }

        $admin = Role::where('slug', 'admin')->first();
        if ($admin) {
            $adminPermissions = Permission::whereIn('slug', [
                'view-dashboard',
                'manage-users',
                'view-users',
                'manage-academic',
                'view-academic',
                'manage-classes',
                'view-classes',
                'manage-grades',
                'view-grades',
                'manage-attendance',
                'view-attendance',
                'view-settings',
            ])->get();
            $admin->permissions()->sync($adminPermissions);
        }

        $akademik = Role::where('slug', 'akademik')->first();
        if ($akademik) {
            $akademikPermissions = Permission::whereIn('slug', [
                'view-dashboard',
                'view-users',
                'manage-academic',
                'view-academic',
                'manage-classes',
                'view-classes',
                'view-grades',
                'view-attendance',
            ])->get();
            $akademik->permissions()->sync($akademikPermissions);
        }

        $guru = Role::where('slug', 'guru')->first();
        if ($guru) {
            $guruPermissions = Permission::whereIn('slug', [
                'view-dashboard',
                'view-classes',
                'manage-grades',
                'view-grades',
                'manage-attendance',
                'view-attendance',
            ])->get();
            $guru->permissions()->sync($guruPermissions);
        }

        $siswa = Role::where('slug', 'siswa')->first();
        if ($siswa) {
            $siswaPermissions = Permission::whereIn('slug', [
                'view-dashboard',
                'view-own-grades',
                'view-attendance',
            ])->get();
            $siswa->permissions()->sync($siswaPermissions);
        }
    }
}
