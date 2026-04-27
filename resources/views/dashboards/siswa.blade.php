@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Siswa Dashboard</h1>
    <p class="text-gray-600 dark:text-gray-400">View your academic progress and information</p>
</div>

<div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4 mb-6">
    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="flex items-center justify-between">
            <div>
                <h4 class="text-xl font-bold text-black dark:text-white">{{ $stats['my_classes'] }}</h4>
                <span class="text-sm font-medium">My Classes</span>
            </div>
            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                <svg class="fill-primary dark:fill-white" width="22" height="22" viewBox="0 0 22 22" fill="none">
                    <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0Z" fill=""/>
                </svg>
            </div>
        </div>
    </div>

    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="flex items-center justify-between">
            <div>
                <h4 class="text-xl font-bold text-black dark:text-white">{{ $stats['my_grades'] }}</h4>
                <span class="text-sm font-medium">Total Grades</span>
            </div>
            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-3 dark:bg-meta-4">
                <svg class="fill-primary dark:fill-white" width="22" height="22" viewBox="0 0 22 22" fill="none">
                    <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0Z" fill=""/>
                </svg>
            </div>
        </div>
    </div>

    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="flex items-center justify-between">
            <div>
                <h4 class="text-xl font-bold text-black dark:text-white">{{ $stats['attendance_percentage'] }}%</h4>
                <span class="text-sm font-medium">Attendance</span>
            </div>
            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-success dark:bg-meta-4">
                <svg class="fill-white" width="22" height="22" viewBox="0 0 22 22" fill="none">
                    <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0Z" fill=""/>
                </svg>
            </div>
        </div>
    </div>

    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="flex items-center justify-between">
            <div>
                <h4 class="text-xl font-bold text-black dark:text-white">{{ $stats['upcoming_exams'] }}</h4>
                <span class="text-sm font-medium">Upcoming Exams</span>
            </div>
            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-warning dark:bg-meta-4">
                <svg class="fill-white" width="22" height="22" viewBox="0 0 22 22" fill="none">
                    <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0Z" fill=""/>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 gap-4 md:gap-6 xl:grid-cols-2">
    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
        <h3 class="mb-4 text-xl font-semibold text-black dark:text-white">Student Portal</h3>
        <div class="space-y-3">
            <a href="#" class="flex items-center gap-3 rounded-lg border border-stroke p-4 transition hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary">
                    <svg class="fill-white" width="18" height="18" viewBox="0 0 22 22" fill="none">
                        <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0Z" fill=""/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-medium text-black dark:text-white">My Grades</h4>
                    <span class="text-sm">View all your grades and scores</span>
                </div>
            </a>

            <a href="#" class="flex items-center gap-3 rounded-lg border border-stroke p-4 transition hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-meta-3">
                    <svg class="fill-white" width="18" height="18" viewBox="0 0 22 22" fill="none">
                        <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0Z" fill=""/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-medium text-black dark:text-white">My Attendance</h4>
                    <span class="text-sm">Check attendance records</span>
                </div>
            </a>

            <a href="#" class="flex items-center gap-3 rounded-lg border border-stroke p-4 transition hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-meta-5">
                    <svg class="fill-white" width="18" height="18" viewBox="0 0 22 22" fill="none">
                        <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0Z" fill=""/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-medium text-black dark:text-white">Class Schedule</h4>
                    <span class="text-sm">View your class timetable</span>
                </div>
            </a>

            <a href="#" class="flex items-center gap-3 rounded-lg border border-stroke p-4 transition hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-warning">
                    <svg class="fill-white" width="18" height="18" viewBox="0 0 22 22" fill="none">
                        <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0Z" fill=""/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-medium text-black dark:text-white">Exam Schedule</h4>
                    <span class="text-sm">View upcoming exams</span>
                </div>
            </a>
        </div>
    </div>

    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
        <h3 class="mb-4 text-xl font-semibold text-black dark:text-white">Recent Grades</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between border-b border-stroke pb-3 dark:border-strokedark">
                <div>
                    <h5 class="font-medium text-black dark:text-white">Mathematics</h5>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Mid Semester Exam</span>
                </div>
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-success bg-opacity-10 text-sm font-bold text-success">85</span>
            </div>

            <div class="flex items-center justify-between border-b border-stroke pb-3 dark:border-strokedark">
                <div>
                    <h5 class="font-medium text-black dark:text-white">English</h5>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Mid Semester Exam</span>
                </div>
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-success bg-opacity-10 text-sm font-bold text-success">90</span>
            </div>

            <div class="flex items-center justify-between border-b border-stroke pb-3 dark:border-strokedark">
                <div>
                    <h5 class="font-medium text-black dark:text-white">Science</h5>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Quiz 3</span>
                </div>
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-warning bg-opacity-10 text-sm font-bold text-warning">75</span>
            </div>

            <div class="flex items-center justify-between">
                <div>
                    <h5 class="font-medium text-black dark:text-white">History</h5>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Assignment 2</span>
                </div>
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-success bg-opacity-10 text-sm font-bold text-success">88</span>
            </div>
        </div>

        <div class="mt-4 pt-4 border-t border-stroke dark:border-strokedark">
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium">Average Grade</span>
                <span class="text-xl font-bold text-success">84.5</span>
            </div>
        </div>
    </div>
</div>

{{-- Jadwal Hari Ini & Guru Pengajar --}}
<div class="grid grid-cols-1 gap-4 md:gap-6 xl:grid-cols-2 mt-6">

    {{-- Jadwal Hari Ini --}}
    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
        <h3 class="mb-4 text-xl font-semibold text-black dark:text-white">
            📅 Jadwal Hari Ini
            <span class="ml-2 text-sm font-normal text-gray-400">({{ now()->translatedFormat('l, d F Y') }})</span>
        </h3>

        @if ($jadwalHariIni->isEmpty())
            <p class="text-sm text-gray-400 text-center py-6">Tidak ada jadwal pelajaran hari ini</p>
        @else
            <div class="space-y-3">
                @foreach ($jadwalHariIni as $jadwal)
                    <div class="flex items-center gap-4 rounded-lg border border-stroke p-4 dark:border-strokedark hover:bg-gray-2 dark:hover:bg-meta-4 transition">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-primary bg-opacity-10 text-primary font-bold text-sm">
                            {{ $loop->iteration }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-black dark:text-white truncate">{{ $jadwal->mataPelajaran?->nama ?? '-' }}</p>
                            <p class="text-xs text-gray-500">{{ $jadwal->guru?->name ?? '-' }}</p>
                        </div>
                        <div class="text-right text-xs text-gray-400 shrink-0">
                            <p>{{ $jadwal->timeSlot?->start_time ?? '' }}</p>
                            <p>{{ $jadwal->timeSlot?->end_time ?? '' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Guru Pengajar Kelas --}}
    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
        <h3 class="mb-4 text-xl font-semibold text-black dark:text-white">👨‍🏫 Guru Pengajar Kelas</h3>

        @if ($guruKelas->isEmpty())
            <p class="text-sm text-gray-400 text-center py-6">Belum ada guru yang ditugaskan</p>
        @else
            <div class="space-y-3 max-h-80 overflow-y-auto pr-1">
                @foreach ($guruKelas as $gmk)
                    <div class="flex items-center gap-3 rounded-lg border border-stroke p-3 dark:border-strokedark hover:bg-gray-2 dark:hover:bg-meta-4 transition">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4 text-primary font-semibold text-sm">
                            {{ strtoupper(substr($gmk->guru?->name ?? 'G', 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-black dark:text-white truncate">{{ $gmk->guru?->name ?? '-' }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $gmk->mataPelajaran?->nama ?? '-' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection

