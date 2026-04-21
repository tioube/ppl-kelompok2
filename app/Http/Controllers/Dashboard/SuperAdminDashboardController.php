<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\View\View;

class SuperAdminDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_roles' => Role::count(),
            'total_permissions' => Permission::count(),
            'recent_users' => User::with('roles')->latest()->take(5)->get(),
        ];

        return view('dashboards.super-admin', [
            'title' => 'Super Admin Dashboard',
            'stats' => $stats,
        ]);
    }
}

