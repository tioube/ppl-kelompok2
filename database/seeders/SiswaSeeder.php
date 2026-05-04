<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Role;
use App\Models\SiswaTahunAjaran;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $siswaRole = Role::where('slug', 'siswa')->first();
        $tahunAjaran = TahunAjaran::where('is_active', true)->first() ?? TahunAjaran::first();
        $kelasList = Kelas::all();

        if ($kelasList->isEmpty()) {
            $this->command->warn('No classes found. Please run AkademikSeeder first.');
            return;
        }

        if (!$tahunAjaran) {
            $this->command->warn('No tahun ajaran found. Please run AkademikSeeder first.');
            return;
        }

        $firstNames = [
            'Ahmad', 'Budi', 'Citra', 'Dewi', 'Eko', 'Fitri', 'Gilang', 'Hana',
            'Indra', 'Joko', 'Kartika', 'Lina', 'Maya', 'Nanda', 'Omar', 'Putri',
            'Rizki', 'Sari', 'Tono', 'Umar', 'Vina', 'Wati', 'Yanto', 'Zara',
            'Aditya', 'Bella', 'Candra', 'Dian', 'Fajar', 'Gita', 'Heru', 'Ika',
        ];

        $lastNames = [
            'Santoso', 'Wijaya', 'Pratama', 'Saputra', 'Kusuma', 'Wibowo',
            'Setiawan', 'Nugroho', 'Rahman', 'Hidayat', 'Firmansyah', 'Maulana',
            'Suryanto', 'Hakim', 'Utomo', 'Permana',
        ];

        $genders = ['Laki-laki', 'Perempuan'];

        for ($i = 1; $i <= 30; $i++) {
            $kelas = $kelasList->random();
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $fullName = $firstName.' '.$lastName;
            $gender = $genders[array_rand($genders)];

            $year = rand(2006, 2010);
            $month = rand(1, 12);
            $day = rand(1, 28);
            $birthDate = sprintf('%04d-%02d-%02d', $year, $month, $day);

            $nisn = '00'.str_pad($i, 8, '0', STR_PAD_LEFT);

            $user = User::create([
                'name' => $fullName,
                'email' => strtolower(str_replace(' ', '.', $fullName)).$i.'@student.school.id',
                'password' => Hash::make('password'),
                'nisn' => $nisn,
                'gender' => $gender,
                'birth_date' => $birthDate,
                'phone' => '08'.rand(1000000000, 9999999999),
                'address' => 'Jl. Contoh No. '.rand(1, 100).', Jakarta',
            ]);

            if ($siswaRole) {
                $user->roles()->attach($siswaRole->id);
            }

            SiswaTahunAjaran::create([
                'user_id' => $user->id,
                'tahun_ajaran_id' => $tahunAjaran->id,
                'kelas_id' => $kelas->id,
                'jurusan_id' => $kelas->jurusan_id,
                'status' => 'aktif',
                'nomor_induk_sekolah' => 'NIS-' . str_pad($i, 5, '0', STR_PAD_LEFT),
            ]);
        }

        $this->command->info('Created 30 students with SiswaTahunAjaran records successfully!');
    }
}
