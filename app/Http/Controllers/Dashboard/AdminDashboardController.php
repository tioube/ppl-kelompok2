<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_students' => User::whereHas('roles', fn ($q) => $q->where('slug', 'siswa'))->count(),
            'total_teachers' => User::whereHas('roles', fn ($q) => $q->where('slug', 'guru'))->count(),
            'recent_users' => User::with('roles')->latest()->take(5)->get(),
        ];

        return view('dashboards.admin', [
            'title' => 'Admin Dashboard',
            'stats' => $stats,
        ]);
    }
}
