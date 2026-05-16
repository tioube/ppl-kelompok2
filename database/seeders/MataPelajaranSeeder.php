<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $mataPelajaran = [
            // MATA PELAJARAN WAJIB - KELOMPOK A (Umum)
            [
                'kode' => 'PAI',
                'nama' => 'Pendidikan Agama Islam dan Budi Pekerti',
                'deskripsi' => 'Mata pelajaran yang mengajarkan nilai-nilai agama Islam dan pembentukan karakter',
                'kategori' => 'Wajib',
                'jam_pelajaran' => 3,
            ],
            [
                'kode' => 'PAK',
                'nama' => 'Pendidikan Agama Kristen dan Budi Pekerti',
                'deskripsi' => 'Mata pelajaran yang mengajarkan nilai-nilai agama Kristen dan pembentukan karakter',
                'kategori' => 'Wajib',
                'jam_pelajaran' => 3,
            ],
            [
                'kode' => 'PAP',
                'nama' => 'Pendidikan Agama Katolik dan Budi Pekerti',
                'deskripsi' => 'Mata pelajaran yang mengajarkan nilai-nilai agama Katolik dan pembentukan karakter',
                'kategori' => 'Wajib',
                'jam_pelajaran' => 3,
            ],
            [
                'kode' => 'PAH',
                'nama' => 'Pendidikan Agama Hindu dan Budi Pekerti',
                'deskripsi' => 'Mata pelajaran yang mengajarkan nilai-nilai agama Hindu dan pembentukan karakter',
                'kategori' => 'Wajib',
                'jam_pelajaran' => 3,
            ],
            [
                'kode' => 'PAB',
                'nama' => 'Pendidikan Agama Buddha dan Budi Pekerti',
                'deskripsi' => 'Mata pelajaran yang mengajarkan nilai-nilai agama Buddha dan pembentukan karakter',
                'kategori' => 'Wajib',
                'jam_pelajaran' => 3,
            ],
            [
                'kode' => 'PAKK',
                'nama' => 'Pendidikan Agama Khonghucu dan Budi Pekerti',
                'deskripsi' => 'Mata pelajaran yang mengajarkan nilai-nilai agama Khonghucu dan pembentukan karakter',
                'kategori' => 'Wajib',
                'jam_pelajaran' => 3,
            ],
            [
                'kode' => 'PP',
                'nama' => 'Pendidikan Pancasila',
                'deskripsi' => 'Mata pelajaran yang membentuk karakter warga negara berdasarkan nilai-nilai Pancasila',
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
                'kode' => 'INF',
                'nama' => 'Informatika',
                'deskripsi' => 'Mata pelajaran teknologi informasi dan komunikasi',
                'kategori' => 'Wajib',
                'jam_pelajaran' => 2,
            ],
            [
                'kode' => 'BK',
                'nama' => 'Bimbingan Konseling',
                'deskripsi' => 'Layanan bimbingan dan konseling untuk pengembangan diri siswa',
                'kategori' => 'Wajib',
                'jam_pelajaran' => 2,
            ],
            [
                'kode' => 'ML',
                'nama' => 'Muatan Lokal',
                'deskripsi' => 'Mata pelajaran muatan lokal sesuai kekhasan daerah',
                'kategori' => 'Wajib',
                'jam_pelajaran' => 2,
            ],

            // MATA PELAJARAN PEMINATAN MIPA
            // MATA PELAJARAN PEMINATAN MIPA
            [
                'kode' => 'MTML',
                'nama' => 'Matematika Lanjut',
                'deskripsi' => 'Mata pelajaran matematika lanjutan untuk peminatan MIPA',
                'kategori' => 'Peminatan',
                'jam_pelajaran' => 4,
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
            // MATA PELAJARAN PEMINATAN IPS
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
                'kode' => 'SEJP',
                'nama' => 'Sejarah Peminatan',
                'deskripsi' => 'Mata pelajaran sejarah lanjutan untuk peminatan IPS',
                'kategori' => 'Peminatan',
                'jam_pelajaran' => 3,
            ],
            [
                'kode' => 'ANT',
                'nama' => 'Antropologi',
                'deskripsi' => 'Mata pelajaran antropologi untuk peminatan IPS',
                'kategori' => 'Peminatan',
                'jam_pelajaran' => 3,
            ],

            // MATA PELAJARAN LINTAS MINAT
            // MATA PELAJARAN LINTAS MINAT
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
                'kode' => 'BKOR',
                'nama' => 'Bahasa Korea',
                'deskripsi' => 'Mata pelajaran bahasa asing pilihan',
                'kategori' => 'Lintas Minat',
                'jam_pelajaran' => 3,
            ],
            [
                'kode' => 'BPRN',
                'nama' => 'Bahasa Prancis',
                'deskripsi' => 'Mata pelajaran bahasa asing pilihan',
                'kategori' => 'Lintas Minat',
                'jam_pelajaran' => 3,
            ],
        ];

        foreach ($mataPelajaran as $mp) {
            MataPelajaran::create($mp);
        }
    }
}
