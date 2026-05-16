@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Guru Dashboard</h1>
    <p class="text-gray-600 dark:text-gray-400">Teaching management and student monitoring</p>
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
                <h4 class="text-xl font-bold text-black dark:text-white">{{ $stats['total_students'] }}</h4>
                <span class="text-sm font-medium">My Students</span>
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
                <h4 class="text-xl font-bold text-black dark:text-white">{{ $stats['pending_grades'] }}</h4>
                <span class="text-sm font-medium">Pending Grades</span>
            </div>
            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-warning dark:bg-meta-4">
                <svg class="fill-white" width="22" height="22" viewBox="0 0 22 22" fill="none">
                    <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0Z" fill=""/>
                </svg>
            </div>
        </div>
    </div>

    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="flex items-center justify-between">
            <div>
                <h4 class="text-xl font-bold text-black dark:text-white">{{ $stats['attendance_today'] }}</h4>
                <span class="text-sm font-medium">Attendance Today</span>
            </div>
            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-success dark:bg-meta-4">
                <svg class="fill-white" width="22" height="22" viewBox="0 0 22 22" fill="none">
                    <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0Z" fill=""/>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 gap-4 md:gap-6 xl:grid-cols-2">
    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
        <h3 class="mb-4 text-xl font-semibold text-black dark:text-white">Teaching Tools</h3>
        <div class="space-y-3">
            <a href="#" class="flex items-center gap-3 rounded-lg border border-stroke p-4 transition hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary">
                    <svg class="fill-white" width="18" height="18" viewBox="0 0 22 22" fill="none">
                        <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0Z" fill=""/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-medium text-black dark:text-white">Manage Grades</h4>
                    <span class="text-sm">Input and update student grades</span>
                </div>
            </a>

            <a href="#" class="flex items-center gap-3 rounded-lg border border-stroke p-4 transition hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-meta-3">
                    <svg class="fill-white" width="18" height="18" viewBox="0 0 22 22" fill="none">
                        <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0Z" fill=""/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-medium text-black dark:text-white">Attendance</h4>
                    <span class="text-sm">Take and manage attendance</span>
                </div>
            </a>

            <a href="#" class="flex items-center gap-3 rounded-lg border border-stroke p-4 transition hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-meta-5">
                    <svg class="fill-white" width="18" height="18" viewBox="0 0 22 22" fill="none">
                        <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0Z" fill=""/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-medium text-black dark:text-white">My Classes</h4>
                    <span class="text-sm">View class schedules and details</span>
                </div>
            </a>

            <a href="#" class="flex items-center gap-3 rounded-lg border border-stroke p-4 transition hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-warning">
                    <svg class="fill-white" width="18" height="18" viewBox="0 0 22 22" fill="none">
                        <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0Z" fill=""/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-medium text-black dark:text-white">Student Reports</h4>
                    <span class="text-sm">Generate performance reports</span>
                </div>
            </a>
        </div>
    </div>

    <div class="rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
        <h3 class="mb-4 text-xl font-semibold text-black dark:text-white">Today's Schedule</h3>
        <div class="space-y-3">
            <div class="rounded-lg border border-stroke p-4 dark:border-strokedark">
                <div class="mb-2 flex items-center justify-between">
                    <span class="text-sm font-medium text-meta-3">08:00 - 09:30</span>
                    <span class="rounded-full bg-success bg-opacity-10 px-2.5 py-0.5 text-xs font-medium text-success">Active</span>
                </div>
                <h5 class="mb-1 font-medium text-black dark:text-white">Mathematics - Class X-A</h5>
                <p class="text-sm text-gray-600 dark:text-gray-400">Room 101 • 30 Students</p>
            </div>

            <div class="rounded-lg border border-stroke p-4 dark:border-strokedark">
                <div class="mb-2 flex items-center justify-between">
                    <span class="text-sm font-medium text-meta-3">10:00 - 11:30</span>
                    <span class="rounded-full bg-warning bg-opacity-10 px-2.5 py-0.5 text-xs font-medium text-warning">Upcoming</span>
                </div>
                <h5 class="mb-1 font-medium text-black dark:text-white">Mathematics - Class X-B</h5>
                <p class="text-sm text-gray-600 dark:text-gray-400">Room 102 • 28 Students</p>
            </div>

            <div class="rounded-lg border border-stroke p-4 dark:border-strokedark">
                <div class="mb-2 flex items-center justify-between">
                    <span class="text-sm font-medium text-meta-3">13:00 - 14:30</span>
                    <span class="rounded-full bg-gray-2 bg-opacity-10 px-2.5 py-0.5 text-xs font-medium text-gray-600 dark:bg-meta-4 dark:text-gray-400">Scheduled</span>
                </div>
                <h5 class="mb-1 font-medium text-black dark:text-white">Mathematics - Class X-C</h5>
                <p class="text-sm text-gray-600 dark:text-gray-400">Room 103 • 32 Students</p>
            </div>
        </div>
    </div>
</div>
@endsection

