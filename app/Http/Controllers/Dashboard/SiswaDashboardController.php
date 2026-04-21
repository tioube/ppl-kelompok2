<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SiswaDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'my_classes' => 0,
            'my_grades' => 0,
            'attendance_percentage' => 0,
            'upcoming_exams' => 0,
        ];

        return view('dashboards.siswa', [
            'title' => 'Siswa Dashboard',
            'stats' => $stats,
        ]);
    }
}
