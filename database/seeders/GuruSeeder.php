<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\MataPelajaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $guruRole = Role::where('slug', 'guru')->first();
        $mataPelajarans = MataPelajaran::all();

        if ($mataPelajarans->isEmpty()) {
            $this->command->error('No Mata Pelajaran found. Please seed mata pelajaran first.');
            return;
        }

        $guruNames = [
            'Matematika' => ['Budi Santoso', 'S.Pd', 'Laki-laki'],
            'Fisika' => ['Siti Nurhaliza', 'S.Pd', 'Perempuan'],
            'Kimia' => ['Ahmad Dahlan', 'S.Si', 'Laki-laki'],
            'Biologi' => ['Dewi Sartika', 'S.Pd', 'Perempuan'],
            'Bahasa Indonesia' => ['Kartini Wijaya', 'S.Pd', 'Perempuan'],
            'Bahasa Inggris' => ['John Rahman', 'S.Pd', 'Laki-laki'],
            'Sejarah' => ['Harun Nasution', 'S.Pd', 'Laki-laki'],
            'Geografi' => ['Ratna Sari', 'S.Pd', 'Perempuan'],
            'Ekonomi' => ['Hendra Gunawan', 'S.E', 'Laki-laki'],
            'Sosiologi' => ['Maya Kusuma', 'S.Sos', 'Perempuan'],
            'Pendidikan Agama Islam' => ['Ustadz Abdullah', 'S.Ag', 'Laki-laki'],
            'Pendidikan Kewarganegaraan' => ['Rini Handayani', 'S.Pd', 'Perempuan'],
            'Seni Budaya' => ['Bambang Suryanto', 'S.Sn', 'Laki-laki'],
            'Pendidikan Jasmani' => ['Eko Prasetyo', 'S.Pd', 'Laki-laki'],
            'Teknologi Informasi' => ['Andi Wijaya', 'S.Kom', 'Laki-laki'],
        ];

        $assignedMapel = [];

        foreach ($mataPelajarans as $mapel) {
            $guruData = $guruNames[$mapel->nama] ?? null;

            if ($guruData) {
                [$name, $gelar, $gender] = $guruData;
                $fullName = $name . ', ' . $gelar;
            } else {
                $name = 'Guru ' . $mapel->nama;
                $gelar = 'S.Pd';
                $fullName = $name . ', ' . $gelar;
                $gender = ['Laki-laki', 'Perempuan'][array_rand(['Laki-laki', 'Perempuan'])];
            }

            $email = strtolower(str_replace([' ', ',', '.'], ['', '', ''], $name)) . '@guru.school.id';

            $year = rand(1970, 1990);
            $month = rand(1, 12);
            $day = rand(1, 28);
            $birthDate = sprintf('%04d-%02d-%02d', $year, $month, $day);

            $user = User::create([
                'name' => $fullName,
                'email' => $email,
                'password' => Hash::make('password'),
                'mata_pelajaran_id' => $mapel->id,
                'gender' => $gender,
                'birth_date' => $birthDate,
                'phone' => '08' . rand(1000000000, 9999999999),
                'address' => 'Jl. Pendidikan No. ' . rand(1, 100) . ', Jakarta',
            ]);

            if ($guruRole) {
                $user->roles()->attach($guruRole->id);
            }

            $assignedMapel[] = $mapel->nama;
        }

        $this->command->info('Created ' . count($assignedMapel) . ' guru users!');
        $this->command->info('Each guru assigned to one mata pelajaran.');
    }
}
