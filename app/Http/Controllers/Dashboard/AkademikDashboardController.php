<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\View\View;

class AkademikDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_students' => User::whereHas('roles', fn ($q) => $q->where('slug', 'siswa'))->count(),
            'total_teachers' => User::whereHas('roles', fn ($q) => $q->where('slug', 'guru'))->count(),
            'total_classes' => Kelas::count(),
            'active_academic_year' => TahunAjaran::where('is_active', true)->first()?->tahun
        ];

        return view('dashboards.akademik', [
            'title' => 'Akademik Dashboard',
            'stats' => $stats,
        ]);
    }
}
