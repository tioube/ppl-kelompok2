@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Akademik Dashboard</h1>
    <p class="text-gray-600 dark:text-gray-400">Academic staff management and oversight</p>
</div>

<div class="mb-6">
    <a href="{{ route('silabus.index', $stats['need_review_silabus_params']) }}">
        <div class="transition hover:border-primary hover:shadow-md rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-yellow-100 dark:bg-yellow-900/30">
                    <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-xl font-bold text-black dark:text-white">{{ $stats['need_review_silabus'] }}</h4>
                    <span class="font-medium">Silabus Yang Butuh Direview</span>
                </div>
            </div>
        </div>
    </a>
</div>

<div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4 mb-6">
    <a href="{{ route('siswa.index', absolute: false) }}">
        <div class="transition hover:border-primary hover:shadow-md rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-xl font-bold text-black dark:text-white">{{ $stats['total_students'] }}</h4>
                    <span class="text-sm font-medium">Total Siswa</span>
                </div>
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                    <svg class="fill-primary dark:fill-white" width="22" height="22" viewBox="0 0 22 22" fill="none">
                        <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0Z" fill=""/>
                    </svg>
                </div>
            </div>
        </div>
    </a>

    <a href="{{ route('guru.index', absolute: false) }}">
        <div class="transition hover:border-primary hover:shadow-md rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-xl font-bold text-black dark:text-white">{{ $stats['total_teachers'] }}</h4>
                    <span class="text-sm font-medium">Total Guru</span>
                </div>
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-3 dark:bg-meta-4">
                    <svg class="fill-primary dark:fill-white" width="22" height="22" viewBox="0 0 22 22" fill="none">
                        <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0Z" fill=""/>
                    </svg>
                </div>
            </div>
        </div>
    </a>

    <a href="{{ route('kelas.index', absolute: false) }}">
        <div class="transition hover:border-primary hover:shadow-md rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-xl font-bold text-black dark:text-white">{{ $stats['total_classes'] }}</h4>
                    <span class="text-sm font-medium">Total Kelas</span>
                </div>
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-5 dark:bg-meta-4">
                    <svg class="fill-primary dark:fill-white" width="22" height="22" viewBox="0 0 22 22" fill="none">
                        <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0Z" fill=""/>
                    </svg>
                </div>
            </div>
        </div>
    </a>

    <a href="{{ route('tahun-ajaran.index', absolute: false) }}">
        <div class="transition hover:border-primary hover:shadow-md rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-xl font-bold text-black dark:text-white">{{ $stats['active_academic_year'] }}</h4>
                    <span class="text-sm font-medium">Tahun Ajaran Saat Ini</span>
                </div>
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-warning dark:bg-meta-4">
                    <svg class="fill-white" width="22" height="22" viewBox="0 0 22 22" fill="none">
                        <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0Z" fill=""/>
                    </svg>
                </div>
            </div>
        </div>
    </a>
</div>

<div class="grid grid-cols-1 gap-4 md:gap-6 xl:grid-cols-2">
    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
        <h3 class="mb-4 text-xl font-semibold text-black dark:text-white">Academic Management</h3>
        <div class="space-y-3">
            <a href="#" class="flex items-center gap-3 rounded-lg border border-stroke p-4 transition hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary">
                    <svg class="fill-white" width="18" height="18" viewBox="0 0 22 22" fill="none">
                        <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0Z" fill=""/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-medium text-black dark:text-white">Manage Classes</h4>
                    <span class="text-sm">Create and manage class schedules</span>
                </div>
            </a>

            <a href="#" class="flex items-center gap-3 rounded-lg border border-stroke p-4 transition hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-meta-3">
                    <svg class="fill-white" width="18" height="18" viewBox="0 0 22 22" fill="none">
                        <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0Z" fill=""/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-medium text-black dark:text-white">Academic Data</h4>
                    <span class="text-sm">View and manage academic records</span>
                </div>
            </a>

            <a href="#" class="flex items-center gap-3 rounded-lg border border-stroke p-4 transition hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-meta-5">
                    <svg class="fill-white" width="18" height="18" viewBox="0 0 22 22" fill="none">
                        <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0Z" fill=""/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-medium text-black dark:text-white">View Grades</h4>
                    <span class="text-sm">Monitor student performance</span>
                </div>
            </a>

            <a href="{{ route('users.index') }}" class="flex items-center gap-3 rounded-lg border border-stroke p-4 transition hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-warning">
                    <svg class="fill-white" width="18" height="18" viewBox="0 0 22 22" fill="none">
                        <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0Z" fill=""/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-medium text-black dark:text-white">View Users</h4>
                    <span class="text-sm">View system users</span>
                </div>
            </a>
        </div>
    </div>

    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
        <h3 class="mb-4 text-xl font-semibold text-black dark:text-white">Quick Statistics</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between border-b border-stroke pb-3 dark:border-strokedark">
                <span class="text-sm font-medium">Students Enrolled</span>
                <span class="text-lg font-bold text-black dark:text-white">{{ $stats['total_students'] }}</span>
            </div>
            <div class="flex items-center justify-between border-b border-stroke pb-3 dark:border-strokedark">
                <span class="text-sm font-medium">Active Teachers</span>
                <span class="text-lg font-bold text-black dark:text-white">{{ $stats['total_teachers'] }}</span>
            </div>
            <div class="flex items-center justify-between border-b border-stroke pb-3 dark:border-strokedark">
                <span class="text-sm font-medium">Total Classes</span>
                <span class="text-lg font-bold text-black dark:text-white">{{ $stats['total_classes'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium">Current Year</span>
                <span class="text-lg font-bold text-success">{{ $stats['active_academic_year'] }}</span>
            </div>
        </div>
    </div>
</div>
@endsection

