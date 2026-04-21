<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class AkademikDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_students' => User::whereHas('roles', fn($q) => $q->where('slug', 'siswa'))->count(),
            'total_teachers' => User::whereHas('roles', fn($q) => $q->where('slug', 'guru'))->count(),
            'total_classes' => 0,
            'active_academic_year' => date('Y') . '/' . (date('Y') + 1),
        ];

        return view('dashboards.akademik', [
            'title' => 'Akademik Dashboard',
            'stats' => $stats,
        ]);
    }
}
