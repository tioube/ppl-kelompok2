<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\GuruMapelKelas;
use Illuminate\View\View;

class GuruDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'my_classes' => GuruMapelKelas::where('guru_id', auth()->id())->count(),
            'total_students' => 0,
            'pending_grades' => 0,
            'attendance_today' => 0,
        ];

        return view('dashboards.guru', [
            'title' => 'Guru Dashboard',
            'stats' => $stats,
        ]);
    }
}
