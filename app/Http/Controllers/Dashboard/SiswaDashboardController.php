<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\GuruMapelKelas;
use App\Models\Schedule;
use Illuminate\View\View;

class SiswaDashboardController extends Controller
{
    public function index(): View
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $hariEn = now()->englishDayOfWeek;

        $jadwalHariIni = $user->kelas_id
            ? Schedule::with(['mataPelajaran', 'guru', 'timeSlot'])
                ->where('kelas_id', $user->kelas_id)
                ->whereHas('timeSlot', fn($q) => $q->where('day', $hariEn)->where('type', 'teaching'))
                ->get()->sortBy('timeSlot.start_time')
            : collect();

        $guruKelas = $user->kelas_id
            ? GuruMapelKelas::with(['guru', 'mataPelajaran'])->where('kelas_id', $user->kelas_id)->get()
            : collect();

        $stats = [
            'my_classes' => 0,
            'my_grades' => 0,
            'attendance_percentage' => 0,
            'upcoming_exams' => 0,
            'total_mapel'            => $user->kelas_id ? GuruMapelKelas::where('kelas_id', $user->kelas_id)->distinct('mata_pelajaran_id')->count('mata_pelajaran_id') : 0,
            'jadwal_hari_ini'        => $jadwalHariIni->count(),
            'total_guru'             => $guruKelas->pluck('guru_id')->unique()->count(),
            'kelas'                  => $user->kelas?->nama ?? '-',
            'jurusan'                => $user->jurusan?->nama ?? '-',
            'nisn'                   => $user->nisn ?? '-',
        ];

        return view('dashboards.siswa', [
            'title' => 'Siswa Dashboard',
            'stats' => $stats,
            'jadwalHariIni' => $jadwalHariIni,
            'guruKelas'     => $guruKelas,
            'user'          => $user,
        ]);
    }
}
