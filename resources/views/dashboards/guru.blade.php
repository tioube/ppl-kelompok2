@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Guru Dashboard</h1>
    <p class="text-gray-600 dark:text-gray-400">Teaching management and student monitoring</p>
</div>

<div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4 mb-6">
    <a href="{{ route('guru-mapel-kelas.index', absolute: false) }}">
        <div class=" transition hover:border-primary hover:shadow-md rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-xl font-bold text-black dark:text-white">{{ $stats['my_classes'] }}</h4>
                    <span class="text-sm font-medium">Total Penugasan/Mata Pelajaran</span>
                </div>
                <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-meta-2 dark:bg-meta-4">
                    <svg class="fill-primary dark:fill-white" width="22" height="22" viewBox="0 0 22 22" fill="none">
                        <path d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0Z" fill=""/>
                    </svg>
                </div>
            </div>
        </div>
    </a>

    <a href="{{ route('siswa.index', absolute: false) }}">
        <div class="transition hover:border-primary hover:shadow-md rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark h-full">
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
    </a>

    <div class="transition hover:border-primary hover:shadow-md rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
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

    <div class="transition hover:border-primary hover:shadow-md rounded-lg border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
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
            <a href="#" class="flex items-center gap-3 rounded-lg border border-stroke p-4 transition hover:border-primary hover:shadow-md ">
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

            <a href="#" class="flex items-center gap-3 rounded-lg border border-stroke p-4 transition hover:border-primary hover:shadow-md ">
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

            <a href="#" class="flex items-center gap-3 rounded-lg border border-stroke p-4 transition hover:border-primary hover:shadow-md ">
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

            <a href="#" class="flex items-center gap-3 rounded-lg border border-stroke p-4 transition hover:border-primary hover:shadow-md ">
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
        <h3 class="mb-4 text-xl font-semibold text-black dark:text-white">
            Today's Schedule
        </h3>

        <div class="space-y-3">
        @forelse ($schedules as $schedule)
            <a 
                href="{{ route('schedules.index', [
                    'tahun_ajaran_id' => $schedule->tahun_ajaran_id,
                    'kelas_id' => $schedule->kelas_id,
                ]) }}"
                class="block"
            >
                <div class="rounded-lg border border-stroke p-4 transition hover:border-primary hover:shadow-md dark:border-strokedark">
                    
                    <div class="mb-2 flex items-center justify-between">
                        <span class="text-sm font-medium text-meta-3">
                            {{ $schedule->timeSlot->start_time }} - {{ $schedule->timeSlot->end_time }}
                        </span>

                        @php
                            $statusColors = [
                                'active' => 'bg-success text-success',
                                'upcoming' => 'bg-warning text-warning',
                                'finished' => 'bg-gray-2 text-gray-600'
                            ];
                        @endphp

                        <span class="rounded-full bg-opacity-10 px-2.5 py-0.5 text-xs font-medium {{ $statusColors[$schedule->status] }}">
                            {{ ucfirst($schedule->status) }}
                        </span>
                    </div>

                    <h5 class="mb-1 font-medium text-black dark:text-white">
                        {{ $schedule->mataPelajaran->nama }} - {{ $schedule->kelas->nama }}
                    </h5>

                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $schedule->kelas->siswaTahunAjaran->count() }} Students
                    </p>
                </div>
            </a>
        @empty
            <p class="text-gray-500">No schedule for today</p>
        @endforelse
        </div>
    </div>
</div>
@endsection

