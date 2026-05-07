<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\GuruMapelKelas;
use App\Models\Schedule;
use App\Models\Silabus;
use App\Models\SiswaTahunAjaran;
use App\Models\TahunAjaran;
use Illuminate\View\View;

class GuruDashboardController extends Controller
{
    public function index(): View
    {
        $dayMap = [
            'monday' => 'senin',
            'tuesday' => 'selasa',
            'wednesday' => 'rabu',
            'thursday' => 'kamis',
            'friday' => 'jumat',
            'saturday' => 'sabtu',
            'sunday' => 'minggu',
        ];

        $today = $dayMap[strtolower(now()->format('l'))];

        $schedules = Schedule::query()
            ->with(['timeSlot', 'mataPelajaran', 'kelas'])
            ->tahunAjaranAktif()
            ->where('guru_id', auth()->id())
            ->whereHas('timeSlot', fn ($q) => $q->where('day', $today))
            ->get()
            ->sortBy(fn ($s) => $s->timeSlot->start_time)
            ->values();

        $totalClasses = GuruMapelKelas::where('guru_id', auth()->id())->count();

        $tahunAjaranAktif = TahunAjaran::getAktif();

        $totalSiswa = SiswaTahunAjaran::whereIn(
            'kelas_id',
            auth()->user()
                ->guruMapelKelas
                ->pluck('kelas_id')
        )
            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->where('status', 'aktif')
            ->count();

        $totalSilabus = Silabus::active()
            ->approved()
            ->where('created_by', auth()->id())
            ->count();

        $stats = [
            'my_classes' => $totalClasses,
            'total_students' => $totalSiswa,
            'total_syllabus' => $totalSilabus,
            'attendance_today' => 0,
        ];

        return view('dashboards.guru', [
            'title' => 'Guru Dashboard',
            'stats' => $stats,
            'schedules' => $schedules,
        ]);
    }
}
