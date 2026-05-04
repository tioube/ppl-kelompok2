<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            SuperAdminSeeder::class,
            AkademikSeeder::class,
            MataPelajaranSeeder::class,
            MataPelajaranTahunAjaranSeeder::class,
            GuruSeeder::class,
            SiswaSeeder::class,
            TimeSlotSeeder::class,
            SilabusSeeder::class,
        ]);
    }
}
