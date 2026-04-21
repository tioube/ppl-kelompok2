<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $mataPelajaran = [
            [
                'kode' => 'PAI',
                'nama' => 'Pendidikan Agama Islam dan Budi Pekerti',
                'deskripsi' => 'Mata pelajaran yang mengajarkan nilai-nilai agama Islam dan pembentukan karakter',
                'kategori' => 'Wajib',
                'jam_pelajaran' => 3,
            ],
            [
                'kode' => 'PKN',
                'nama' => 'Pendidikan Pancasila dan Kewarganegaraan',
                'deskripsi' => 'Mata pelajaran yang membentuk karakter warga negara yang baik',
                'kategori' => 'Wajib',
                'jam_pelajaran' => 2,
            ],
            [
                'kode' => 'BIND',
                'nama' => 'Bahasa Indonesia',
                'deskripsi' => 'Mata pelajaran bahasa nasional Indonesia',
                'kategori' => 'Wajib',
                'jam_pelajaran' => 4,
            ],
            [
                'kode' => 'MTK',
                'nama' => 'Matematika',
                'deskripsi' => 'Mata pelajaran matematika umum',
                'kategori' => 'Wajib',
                'jam_pelajaran' => 4,
            ],
            [
                'kode' => 'SEJ',
                'nama' => 'Sejarah Indonesia',
                'deskripsi' => 'Mata pelajaran sejarah Indonesia',
                'kategori' => 'Wajib',
                'jam_pelajaran' => 2,
            ],
            [
                'kode' => 'BING',
                'nama' => 'Bahasa Inggris',
                'deskripsi' => 'Mata pelajaran bahasa asing wajib',
                'kategori' => 'Wajib',
                'jam_pelajaran' => 3,
            ],
            [
                'kode' => 'PJOK',
                'nama' => 'Pendidikan Jasmani, Olahraga dan Kesehatan',
                'deskripsi' => 'Mata pelajaran olahraga dan kesehatan',
                'kategori' => 'Wajib',
                'jam_pelajaran' => 3,
            ],
            [
                'kode' => 'SBDP',
                'nama' => 'Seni Budaya',
                'deskripsi' => 'Mata pelajaran seni dan budaya',
                'kategori' => 'Wajib',
                'jam_pelajaran' => 2,
            ],
            [
                'kode' => 'PKWU',
                'nama' => 'Prakarya dan Kewirausahaan',
                'deskripsi' => 'Mata pelajaran prakarya dan kewirausahaan',
                'kategori' => 'Wajib',
                'jam_pelajaran' => 2,
            ],
            [
                'kode' => 'FIS',
                'nama' => 'Fisika',
                'deskripsi' => 'Mata pelajaran fisika untuk peminatan MIPA',
                'kategori' => 'Peminatan',
                'jam_pelajaran' => 4,
            ],
            [
                'kode' => 'KIM',
                'nama' => 'Kimia',
                'deskripsi' => 'Mata pelajaran kimia untuk peminatan MIPA',
                'kategori' => 'Peminatan',
                'jam_pelajaran' => 4,
            ],
            [
                'kode' => 'BIO',
                'nama' => 'Biologi',
                'deskripsi' => 'Mata pelajaran biologi untuk peminatan MIPA',
                'kategori' => 'Peminatan',
                'jam_pelajaran' => 4,
            ],
            [
                'kode' => 'EKO',
                'nama' => 'Ekonomi',
                'deskripsi' => 'Mata pelajaran ekonomi untuk peminatan IPS',
                'kategori' => 'Peminatan',
                'jam_pelajaran' => 4,
            ],
            [
                'kode' => 'SOS',
                'nama' => 'Sosiologi',
                'deskripsi' => 'Mata pelajaran sosiologi untuk peminatan IPS',
                'kategori' => 'Peminatan',
                'jam_pelajaran' => 3,
            ],
            [
                'kode' => 'GEO',
                'nama' => 'Geografi',
                'deskripsi' => 'Mata pelajaran geografi untuk peminatan IPS',
                'kategori' => 'Peminatan',
                'jam_pelajaran' => 3,
            ],
            [
                'kode' => 'BSAR',
                'nama' => 'Bahasa Arab',
                'deskripsi' => 'Mata pelajaran bahasa asing pilihan',
                'kategori' => 'Lintas Minat',
                'jam_pelajaran' => 3,
            ],
            [
                'kode' => 'BJEP',
                'nama' => 'Bahasa Jepang',
                'deskripsi' => 'Mata pelajaran bahasa asing pilihan',
                'kategori' => 'Lintas Minat',
                'jam_pelajaran' => 3,
            ],
            [
                'kode' => 'BMDR',
                'nama' => 'Bahasa Mandarin',
                'deskripsi' => 'Mata pelajaran bahasa asing pilihan',
                'kategori' => 'Lintas Minat',
                'jam_pelajaran' => 3,
            ],
            [
                'kode' => 'TIK',
                'nama' => 'Teknologi Informasi dan Komunikasi',
                'deskripsi' => 'Mata pelajaran teknologi informasi',
                'kategori' => 'Lintas Minat',
                'jam_pelajaran' => 2,
            ],
        ];

        foreach ($mataPelajaran as $mp) {
            MataPelajaran::create($mp);
        }
    }
}
