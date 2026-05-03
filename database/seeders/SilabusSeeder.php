<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use App\Models\Silabus;
use App\Models\User;
use Illuminate\Database\Seeder;

class SilabusSeeder extends Seeder
{
    public function run(): void
    {
        $mataPelajaran = MataPelajaran::all();
        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('slug', ['super-admin', 'guru']);
        })->get();

        if ($mataPelajaran->isEmpty() || $users->isEmpty()) {
            return;
        }

        $tujuanPembelajaranSamples = [
            'formatif' => [
                'Setelah mengikuti pembelajaran, peserta didik mampu mengidentifikasi konsep dasar dengan tepat berdasarkan materi yang diberikan',
                'Melalui diskusi kelompok, peserta didik dapat menjelaskan perbedaan antara konsep A dan B dengan menggunakan contoh konkret',
                'Dengan menggunakan media pembelajaran, siswa mampu mengklasifikasikan berbagai jenis data sesuai dengan kategorinya',
                'Setelah membaca materi, peserta didik dapat menyebutkan minimal 5 karakteristik utama dari topik yang dipelajari',
                'Melalui pengamatan langsung, siswa mampu membandingkan dua fenomena yang berbeda dengan akurasi minimal 80%',
                'Setelah praktikum, peserta didik dapat mencontohkan penerapan teori dalam kehidupan sehari-hari',
            ],
            'sumatif' => [
                'Setelah menyelesaikan unit pembelajaran, peserta didik mampu menganalisis hubungan sebab-akibat dalam fenomena yang dipelajari dengan akurasi minimal 80%',
                'Melalui project-based learning, siswa dapat merancang solusi inovatif untuk masalah nyata dengan menerapkan konsep yang dipelajari',
                'Pada akhir semester, peserta didik mampu mengevaluasi efektivitas berbagai pendekatan yang telah dipelajari dan memberikan rekomendasi perbaikan',
                'Setelah pembelajaran selesai, siswa dapat mencipta karya orisinil yang menggabungkan minimal 3 konsep yang telah dipelajari',
                'Melalui presentasi akhir, peserta didik mampu mengkritisi teori yang ada dan mengajukan alternatif solusi dengan argumentasi yang kuat',
                'Pada evaluasi akhir, siswa dapat menyusun rencana implementasi yang komprehensif berdasarkan analisis mendalam terhadap masalah yang diberikan',
            ],
        ];

        foreach ($mataPelajaran as $mapel) {
            // Create 3-5 silabus per mata pelajaran
            for ($i = 0; $i < rand(3, 5); $i++) {
                $kategori = ['formatif', 'sumatif'][array_rand(['formatif', 'sumatif'])];
                $creator = $users->random();

                // Random approval and status based on realistic distribution
                $approvalStatuses = ['draft', 'pending_approval', 'approved', 'rejected'];
                $approvalWeights = [0.2, 0.3, 0.4, 0.1]; // 20% draft, 30% pending, 40% approved, 10% rejected
                $approvalStatus = $this->weightedRandom($approvalStatuses, $approvalWeights);

                $status = 'pending';
                if ($approvalStatus === 'approved') {
                    $status = ['aktif', 'non_aktif'][array_rand(['aktif', 'non_aktif'])];
                } elseif ($approvalStatus === 'rejected') {
                    $status = 'non_aktif';
                }

                $silabus = Silabus::create([
                    'mata_pelajaran_id' => $mapel->id,
                    'tujuan_pembelajaran' => $tujuanPembelajaranSamples[$kategori][array_rand($tujuanPembelajaranSamples[$kategori])],
                    'kategori' => $kategori,
                    'status' => $status,
                    'approval_status' => $approvalStatus,
                    'urutan' => $i + 1,
                    'created_by' => $creator->id,
                    'updated_by' => $creator->id,
                    'created_at' => now()->subDays(rand(1, 60)),
                    'updated_at' => now()->subDays(rand(0, 30)),
                ]);

                // If approved, set approval details
                if ($approvalStatus === 'approved') {
                    $approver = User::whereHas('roles', function ($query) {
                        $query->whereIn('slug', ['super-admin', 'akademik']);
                    })->inRandomOrder()->first();

                    if ($approver) {
                        $silabus->update([
                            'approved_by' => $approver->id,
                            'approved_at' => now()->subDays(rand(1, 30)),
                        ]);
                    }
                }

                // If rejected, add rejection reason
                if ($approvalStatus === 'rejected') {
                    $rejectionReasons = [
                        'Tujuan pembelajaran belum sesuai dengan format ABCD yang ditetapkan Kemendikbud',
                        'Kata kerja operasional yang digunakan tidak sesuai dengan kategori yang dipilih',
                        'Kriteria keberhasilan belum terukur dengan jelas',
                        'Tujuan pembelajaran terlalu umum dan perlu dibuat lebih spesifik',
                        'Kondisi pembelajaran tidak dijelaskan dengan detail yang memadai',
                    ];

                    $silabus->update([
                        'rejection_reason' => $rejectionReasons[array_rand($rejectionReasons)],
                    ]);
                }
            }
        }
    }

    private function weightedRandom(array $items, array $weights): string
    {
        $totalWeight = array_sum($weights);
        $random = mt_rand(1, $totalWeight * 100) / 100;

        $currentWeight = 0;
        for ($i = 0; $i < count($items); $i++) {
            $currentWeight += $weights[$i];
            if ($random <= $currentWeight) {
                return $items[$i];
            }
        }

        return $items[0];
    }
}
