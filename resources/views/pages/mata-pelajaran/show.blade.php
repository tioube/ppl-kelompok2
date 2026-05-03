@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb
        pageTitle="Detail Mata Pelajaran"
        :breadcrumbs="[
            ['name' => 'Mata Pelajaran', 'url' => route('mata-pelajaran.index')],
            ['name' => $mataPelajaran->nama, 'url' => null]
        ]"
    />

    <div class="space-y-6">
        @session('success')
            <x-ui.alert variant="success">{{ $value }}</x-ui.alert>
        @endsession

        <!-- Header Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $mataPelajaran->nama }}</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Kode: {{ $mataPelajaran->kode }}</p>
                    @if($mataPelajaran->deskripsi)
                        <p class="text-gray-700 dark:text-gray-300 mt-2">{{ $mataPelajaran->deskripsi }}</p>
                    @endif
                </div>
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @switch($mataPelajaran->kategori)
                            @case('Wajib')
                                bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                                @break
                            @case('Peminatan')
                                bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                @break
                            @case('Lintas Minat')
                                bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300
                                @break
                        @endswitch
                    ">
                        {{ $mataPelajaran->kategori }}
                    </span>
                    @can('update', $mataPelajaran)
                        <a href="{{ route('mata-pelajaran.edit', $mataPelajaran) }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/30">
                            <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Jam Pelajaran</p>
                        <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $mataPelajaran->jam_pelajaran }} JP</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/30">
                            <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Silabus</p>
                        <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $silabusStats['total'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-yellow-100 dark:bg-yellow-900/30">
                            <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Formatif</p>
                        <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $silabusStats['formatif'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900/30">
                            <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Sumatif</p>
                        <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $silabusStats['sumatif'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subject Details -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Detail Mata Pelajaran</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Informasi Umum</h3>
                    <dl class="space-y-2">
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600 dark:text-gray-400">Kode Mata Pelajaran</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $mataPelajaran->kode }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600 dark:text-gray-400">Kategori</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $mataPelajaran->kategori }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600 dark:text-gray-400">Jam Pelajaran</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $mataPelajaran->jam_pelajaran }} JP</dd>
                        </div>
                    </dl>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Pengaturan Jadwal</h3>
                    <dl class="space-y-2">
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600 dark:text-gray-400">Blok Preferensi</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $mataPelajaran->preferred_block }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600 dark:text-gray-400">Maksimal per Hari</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-white">{{ $mataPelajaran->max_per_day }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Approved Silabus Section -->
        @if($mataPelajaran->silabusAktif->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Silabus yang Disetujui</h2>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                        {{ $mataPelajaran->silabusAktif->count() }} Silabus Aktif
                    </span>
                </div>

                <div class="space-y-4">
                    @php
                        $groupedSilabus = $mataPelajaran->silabusAktif->groupBy('kategori');
                    @endphp

                    @foreach(['formatif', 'sumatif'] as $kategori)
                        @if(isset($groupedSilabus[$kategori]) && $groupedSilabus[$kategori]->count() > 0)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white capitalize">
                                        Silabus {{ ucfirst($kategori) }}
                                        <span class="ml-2 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            @if($kategori === 'formatif')
                                                bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                                            @else
                                                bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300
                                            @endif
                                        ">
                                            {{ $groupedSilabus[$kategori]->count() }} item
                                        </span>
                                    </h3>
                                </div>
                                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($groupedSilabus[$kategori] as $silabus)
                                        <div class="p-4">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1 min-w-0">
                                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">
                                                        Urutan {{ $silabus->urutan }}: {{ Str::limit($silabus->tujuan_pembelajaran, 100) }}
                                                    </h4>
                                                    <div class="flex items-center space-x-4 text-xs text-gray-500 dark:text-gray-400">
                                                        <span class="flex items-center">
                                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                            </svg>
                                                            Dibuat oleh: {{ $silabus->createdBy->name }}
                                                        </span>
                                                        @if($silabus->approvedBy)
                                                            <span class="flex items-center">
                                                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                </svg>
                                                                Disetujui oleh: {{ $silabus->approvedBy->name }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex items-center space-x-2">
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                                        Disetujui
                                                    </span>
                                                    @can('view', $silabus)
                                                        <a href="{{ route('silabus.show', $silabus) }}"
                                                           class="inline-flex items-center px-3 py-1 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                            <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                            </svg>
                                                            Lihat Detail
                                                        </a>
                                                    @endcan
                                                </div>
                                            </div>
                                            @if(strlen($silabus->tujuan_pembelajaran) > 100)
                                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $silabus->tujuan_pembelajaran }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="mt-4 text-sm font-medium text-gray-900 dark:text-white">Belum ada silabus yang disetujui</h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Mata pelajaran ini belum memiliki silabus yang disetujui dan aktif.
                    </p>
                    @can('create', App\Models\Silabus::class)
                        <div class="mt-4">
                            <a href="{{ route('silabus.create') }}?mata_pelajaran_id={{ $mataPelajaran->id }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Buat Silabus Baru
                            </a>
                        </div>
                    @endcan
                </div>
            </div>
        @endif
    </div>
@endsection
