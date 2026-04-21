<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'description' => 'Super Administrator with full access to all features',
            ],
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Administrator with access to most features',
            ],
            [
                'name' => 'Akademik',
                'slug' => 'akademik',
                'description' => 'Academic staff with access to academic features',
            ],
            [
                'name' => 'Guru',
                'slug' => 'guru',
                'description' => 'Teacher with access to teaching features',
            ],
            [
                'name' => 'Siswa',
                'slug' => 'siswa',
                'description' => 'Student with limited access',
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
}

