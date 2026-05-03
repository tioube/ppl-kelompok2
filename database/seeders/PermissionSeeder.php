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
            // System & Dashboard
            ['name' => 'View Dashboard', 'slug' => 'view-dashboard', 'description' => 'Access dashboard'],
            ['name' => 'View Settings', 'slug' => 'view-settings', 'description' => 'View settings'],
            ['name' => 'Manage Settings', 'slug' => 'manage-settings', 'description' => 'Edit system settings'],

            // User Management
            ['name' => 'Manage Users', 'slug' => 'manage-users', 'description' => 'Full access to user management'],
            ['name' => 'View Users', 'slug' => 'view-users', 'description' => 'View user list'],
            ['name' => 'Create Users', 'slug' => 'create-users', 'description' => 'Create new users'],
            ['name' => 'Edit Users', 'slug' => 'edit-users', 'description' => 'Edit user data'],
            ['name' => 'Delete Users', 'slug' => 'delete-users', 'description' => 'Delete users'],
            ['name' => 'Manage Roles', 'slug' => 'manage-roles', 'description' => 'Create, edit, delete roles'],
            ['name' => 'Manage Permissions', 'slug' => 'manage-permissions', 'description' => 'Assign permissions'],

            // Academic Data Management
            ['name' => 'Manage Academic', 'slug' => 'manage-academic', 'description' => 'Manage academic data'],
            ['name' => 'View Academic', 'slug' => 'view-academic', 'description' => 'View academic data'],

            // Subject Management (Mata Pelajaran)
            ['name' => 'Manage Mata Pelajaran', 'slug' => 'manage-mata-pelajaran', 'description' => 'Full access to mata pelajaran management'],
            ['name' => 'View Mata Pelajaran', 'slug' => 'view-mata-pelajaran', 'description' => 'View mata pelajaran list'],
            ['name' => 'Create Mata Pelajaran', 'slug' => 'create-mata-pelajaran', 'description' => 'Create new mata pelajaran'],
            ['name' => 'Edit Mata Pelajaran', 'slug' => 'edit-mata-pelajaran', 'description' => 'Edit mata pelajaran'],
            ['name' => 'Delete Mata Pelajaran', 'slug' => 'delete-mata-pelajaran', 'description' => 'Delete mata pelajaran'],

            // Student Management (Siswa)
            ['name' => 'Manage Siswa', 'slug' => 'manage-siswa', 'description' => 'Full access to siswa management'],
            ['name' => 'View Siswa', 'slug' => 'view-siswa', 'description' => 'View siswa list'],
            ['name' => 'Create Siswa', 'slug' => 'create-siswa', 'description' => 'Create new siswa'],
            ['name' => 'Edit Siswa', 'slug' => 'edit-siswa', 'description' => 'Edit siswa'],
            ['name' => 'Delete Siswa', 'slug' => 'delete-siswa', 'description' => 'Delete siswa'],

            // Academic Year Management (Tahun Ajaran)
            ['name' => 'Manage Tahun Ajaran', 'slug' => 'manage-tahun-ajaran', 'description' => 'Full access to tahun ajaran management'],
            ['name' => 'View Tahun Ajaran', 'slug' => 'view-tahun-ajaran', 'description' => 'View tahun ajaran list'],
            ['name' => 'Create Tahun Ajaran', 'slug' => 'create-tahun-ajaran', 'description' => 'Create new tahun ajaran'],
            ['name' => 'Edit Tahun Ajaran', 'slug' => 'edit-tahun-ajaran', 'description' => 'Edit tahun ajaran'],
            ['name' => 'Delete Tahun Ajaran', 'slug' => 'delete-tahun-ajaran', 'description' => 'Delete tahun ajaran'],

            // Department Management (Jurusan)
            ['name' => 'Manage Jurusan', 'slug' => 'manage-jurusan', 'description' => 'Full access to jurusan management'],
            ['name' => 'View Jurusan', 'slug' => 'view-jurusan', 'description' => 'View jurusan list'],
            ['name' => 'Create Jurusan', 'slug' => 'create-jurusan', 'description' => 'Create new jurusan'],
            ['name' => 'Edit Jurusan', 'slug' => 'edit-jurusan', 'description' => 'Edit jurusan'],
            ['name' => 'Delete Jurusan', 'slug' => 'delete-jurusan', 'description' => 'Delete jurusan'],

            // Class Management (Kelas)
            ['name' => 'Manage Classes', 'slug' => 'manage-classes', 'description' => 'Manage class data'],
            ['name' => 'View Classes', 'slug' => 'view-classes', 'description' => 'View class data'],
            ['name' => 'Manage Kelas', 'slug' => 'manage-kelas', 'description' => 'Full access to kelas management'],
            ['name' => 'View Kelas', 'slug' => 'view-kelas', 'description' => 'View kelas list'],
            ['name' => 'Create Kelas', 'slug' => 'create-kelas', 'description' => 'Create new kelas'],
            ['name' => 'Edit Kelas', 'slug' => 'edit-kelas', 'description' => 'Edit kelas'],
            ['name' => 'Delete Kelas', 'slug' => 'delete-kelas', 'description' => 'Delete kelas'],

            // Teacher Management (Guru)
            ['name' => 'Manage Guru', 'slug' => 'manage-guru', 'description' => 'Full access to guru management'],
            ['name' => 'View Guru', 'slug' => 'view-guru', 'description' => 'View guru list'],
            ['name' => 'Create Guru', 'slug' => 'create-guru', 'description' => 'Create new guru'],
            ['name' => 'Edit Guru', 'slug' => 'edit-guru', 'description' => 'Edit guru'],
            ['name' => 'Delete Guru', 'slug' => 'delete-guru', 'description' => 'Delete guru'],

            // Silabus Management
            ['name' => 'Manage Silabus', 'slug' => 'manage-silabus', 'description' => 'Full access to silabus management'],
            ['name' => 'View Silabus', 'slug' => 'view-silabus', 'description' => 'View silabus list'],
            ['name' => 'Create Silabus', 'slug' => 'create-silabus', 'description' => 'Create new silabus'],
            ['name' => 'Edit Silabus', 'slug' => 'edit-silabus', 'description' => 'Edit silabus'],
            ['name' => 'Delete Silabus', 'slug' => 'delete-silabus', 'description' => 'Delete silabus'],
            ['name' => 'Approve Silabus', 'slug' => 'approve-silabus', 'description' => 'Approve or reject silabus'],

            // Teacher-Subject-Class Management (Guru Mapel Kelas)
            ['name' => 'Manage Guru Mapel Kelas', 'slug' => 'manage-guru-mapel-kelas', 'description' => 'Full access to guru mapel kelas management'],
            ['name' => 'View Guru Mapel Kelas', 'slug' => 'view-guru-mapel-kelas', 'description' => 'View guru mapel kelas list'],
            ['name' => 'Create Guru Mapel Kelas', 'slug' => 'create-guru-mapel-kelas', 'description' => 'Create new guru mapel kelas'],
            ['name' => 'Edit Guru Mapel Kelas', 'slug' => 'edit-guru-mapel-kelas', 'description' => 'Edit guru mapel kelas'],
            ['name' => 'Delete Guru Mapel Kelas', 'slug' => 'delete-guru-mapel-kelas', 'description' => 'Delete guru mapel kelas'],
            ['name' => 'Generate Guru Mapel Kelas', 'slug' => 'generate-guru-mapel-kelas', 'description' => 'Generate guru mapel kelas automatically'],
            ['name' => 'Clear Guru Mapel Kelas', 'slug' => 'clear-guru-mapel-kelas', 'description' => 'Clear all guru mapel kelas'],

            // Schedule Management
            ['name' => 'Manage Jadwal Pelajaran', 'slug' => 'manage-jadwal-pelajaran', 'description' => 'Full access to jadwal pelajaran management'],
            ['name' => 'View Jadwal Pelajaran', 'slug' => 'view-jadwal-pelajaran', 'description' => 'View jadwal pelajaran list'],
            ['name' => 'Create Jadwal Pelajaran', 'slug' => 'create-jadwal-pelajaran', 'description' => 'Create new jadwal pelajaran'],
            ['name' => 'Edit Jadwal Pelajaran', 'slug' => 'edit-jadwal-pelajaran', 'description' => 'Edit jadwal pelajaran'],
            ['name' => 'Delete Jadwal Pelajaran', 'slug' => 'delete-jadwal-pelajaran', 'description' => 'Delete jadwal pelajaran'],
            ['name' => 'Manage Schedules', 'slug' => 'manage-schedules', 'description' => 'Full access to schedule management'],
            ['name' => 'View Schedules', 'slug' => 'view-schedules', 'description' => 'View schedules'],
            ['name' => 'Create Schedules', 'slug' => 'create-schedules', 'description' => 'Create new schedules'],
            ['name' => 'Generate Schedules', 'slug' => 'generate-schedules', 'description' => 'Generate schedules automatically'],
            ['name' => 'Swap Schedules', 'slug' => 'swap-schedules', 'description' => 'Swap schedule positions'],
            ['name' => 'Move Schedules', 'slug' => 'move-schedules', 'description' => 'Move schedules to different time slots'],

            // Assessment & Grading
            ['name' => 'Manage Grades', 'slug' => 'manage-grades', 'description' => 'Input and edit grades'],
            ['name' => 'View Grades', 'slug' => 'view-grades', 'description' => 'View grades'],
            ['name' => 'View Own Grades', 'slug' => 'view-own-grades', 'description' => 'View own grades only'],

            // Attendance Management
            ['name' => 'Manage Attendance', 'slug' => 'manage-attendance', 'description' => 'Manage attendance'],
            ['name' => 'View Attendance', 'slug' => 'view-attendance', 'description' => 'View attendance'],
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
                'view-settings',
                'manage-academic',
                'view-academic',
                'manage-classes',
                'view-classes',
                'view-mata-pelajaran',
                'view-siswa',
                'view-tahun-ajaran',
                'view-jurusan',
                'view-kelas',
                'view-guru',
                'view-guru-mapel-kelas',
                'view-jadwal-pelajaran',
                'view-schedules',
                'manage-grades',
                'view-grades',
                'manage-attendance',
                'view-attendance',
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
                'manage-mata-pelajaran',
                'view-mata-pelajaran',
                'create-mata-pelajaran',
                'edit-mata-pelajaran',
                'manage-siswa',
                'view-siswa',
                'create-siswa',
                'edit-siswa',
                'manage-tahun-ajaran',
                'view-tahun-ajaran',
                'create-tahun-ajaran',
                'edit-tahun-ajaran',
                'manage-jurusan',
                'view-jurusan',
                'create-jurusan',
                'edit-jurusan',
                'manage-kelas',
                'view-kelas',
                'create-kelas',
                'edit-kelas',
                'view-guru',
                'manage-guru-mapel-kelas',
                'view-guru-mapel-kelas',
                'create-guru-mapel-kelas',
                'edit-guru-mapel-kelas',
                'generate-guru-mapel-kelas',
                'manage-silabus',
                'view-silabus',
                'approve-silabus',
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
                'view-mata-pelajaran',
                'view-siswa',
                'view-kelas',
                'view-guru-mapel-kelas',
                'view-jadwal-pelajaran',
                'view-schedules',
                'create-silabus',
                'edit-silabus',
                'view-silabus',
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
                'view-silabus',
                'view-own-grades',
                'view-attendance',
            ])->get();
            $siswa->permissions()->sync($siswaPermissions);
        }
    }
}
