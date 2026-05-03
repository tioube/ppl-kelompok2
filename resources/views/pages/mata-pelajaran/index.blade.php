@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Mata Pelajaran" />

    <div class="space-y-6">
        @session('success')
            <x-ui.alert variant="success">{{ $value }}</x-ui.alert>
        @endsession

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/30">
                            <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Mata Pelajaran</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/30">
                            <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Wajib</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['wajib'] }}</p>
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
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Peminatan</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['peminatan'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900/30">
                            <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17v4a2 2 0 002 2h4M15 5l2 2"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Lintas Minat</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['lintas_minat'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <form method="GET" class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Filter & Pencarian</h3>
                    <div class="flex gap-2">
                        @if(request()->hasAny(['search', 'kategori', 'min_jam', 'max_jam']))
                            <a href="{{ route('mata-pelajaran.index') }}"
                               class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Reset Filter
                            </a>
                        @endif
                        @if (auth()->user()->hasPermission('create-mata-pelajaran') || auth()->user()->hasPermission('manage-mata-pelajaran'))
                        <a href="{{ route('mata-pelajaran.create') }}"
                            class="bg-blue-600 hover:bg-blue-700 flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-white dark:bg-blue-600 dark:hover:bg-blue-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Tambah Mata Pelajaran
                        </a>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div class="lg:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pencarian</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text"
                                   name="search"
                                   id="search"
                                   value="{{ $filters['search'] ?? '' }}"
                                   placeholder="Cari kode, nama, atau deskripsi mata pelajaran..."
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label for="kategori" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori</label>
                        <select name="kategori" id="kategori" class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Kategori</option>
                            <option value="Wajib" {{ ($filters['kategori'] ?? '') === 'Wajib' ? 'selected' : '' }}>Wajib</option>
                            <option value="Peminatan" {{ ($filters['kategori'] ?? '') === 'Peminatan' ? 'selected' : '' }}>Peminatan</option>
                            <option value="Lintas Minat" {{ ($filters['kategori'] ?? '') === 'Lintas Minat' ? 'selected' : '' }}>Lintas Minat</option>
                        </select>
                    </div>

                    <!-- Jam Pelajaran Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jam Pelajaran</label>
                        <div class="flex gap-2">
                            <input type="number"
                                   name="min_jam"
                                   value="{{ $filters['min_jam'] ?? '' }}"
                                   placeholder="Min"
                                   min="1" max="10"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                            <input type="number"
                                   name="max_jam"
                                   value="{{ $filters['max_jam'] ?? '' }}"
                                   placeholder="Max"
                                   min="1" max="10"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <div class="flex items-center gap-4">
                        <!-- Sort Options -->
                        <div class="flex items-center gap-2">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Urutkan:</label>
                            <select name="sort" class="px-3 py-1 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="kategori" {{ ($filters['sort'] ?? 'kategori') === 'kategori' ? 'selected' : '' }}>Kategori</option>
                                <option value="kode" {{ ($filters['sort'] ?? '') === 'kode' ? 'selected' : '' }}>Kode</option>
                                <option value="nama" {{ ($filters['sort'] ?? '') === 'nama' ? 'selected' : '' }}>Nama</option>
                                <option value="jam_pelajaran" {{ ($filters['sort'] ?? '') === 'jam_pelajaran' ? 'selected' : '' }}>Jam Pelajaran</option>
                            </select>

                            <select name="direction" class="px-3 py-1 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="asc" {{ ($filters['direction'] ?? 'asc') === 'asc' ? 'selected' : '' }}>A-Z / 1-9</option>
                                <option value="desc" {{ ($filters['direction'] ?? '') === 'desc' ? 'selected' : '' }}>Z-A / 9-1</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Results Info -->
        @if(request()->hasAny(['search', 'kategori', 'min_jam', 'max_jam']))
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 dark:bg-yellow-900/20 dark:border-yellow-800">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-800 dark:text-yellow-300">
                            Menampilkan {{ $mataPelajaran->count() }} dari {{ $mataPelajaran->total() }} mata pelajaran
                            @if($filters['search'] ?? false)
                                yang mengandung "<strong>{{ $filters['search'] }}</strong>"
                            @endif
                            @if($filters['kategori'] ?? false)
                                dengan kategori "<strong>{{ $filters['kategori'] }}</strong>"
                            @endif
                            @if(($filters['min_jam'] ?? false) || ($filters['max_jam'] ?? false))
                                dengan jam pelajaran
                                @if($filters['min_jam'] ?? false)minimal {{ $filters['min_jam'] }}@endif
                                @if(($filters['min_jam'] ?? false) && ($filters['max_jam'] ?? false)) - @endif
                                @if($filters['max_jam'] ?? false)maksimal {{ $filters['max_jam'] }}@endif
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Table -->
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Mata Pelajaran</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Jam Pelajaran menentukan batas maksimal slot jadwal per minggu per kelas
                </p>
            </div>

            <div class="max-w-full overflow-x-auto custom-scrollbar">
                <table class="w-full min-w-[900px]">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50">
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-300">Kode</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-300">Nama Mata Pelajaran</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-300">Kategori</p>
                            </th>
                            <th class="px-5 py-3 text-center sm:px-6">
                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-300">Jam / Minggu</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-300">Deskripsi</p>
                            </th>
                            @if (auth()->user()->hasPermission('edit-mata-pelajaran') || auth()->user()->hasPermission('delete-mata-pelajaran') || auth()->user()->hasPermission('manage-mata-pelajaran') || auth()->user()->hasPermission('view-mata-pelajaran'))
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-300">Aksi</p>
                            </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php $currentKategori = null; @endphp
                        @forelse ($mataPelajaran as $mp)
                            @if($currentKategori !== $mp->kategori)
                                @php $currentKategori = $mp->kategori; @endphp
                                <tr class="bg-gray-100/70 dark:bg-gray-800/60">
                                    <td colspan="{{ (auth()->user()->hasPermission('edit-mata-pelajaran') || auth()->user()->hasPermission('delete-mata-pelajaran') || auth()->user()->hasPermission('manage-mata-pelajaran')) ? '6' : '5' }}" class="px-5 py-2 sm:px-6">
                                        <p class="text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300">
                                            {{ $mp->kategori }}
                                        </p>
                                    </td>
                                </tr>
                            @endif
                            <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900/30 transition">
                                <td class="px-5 py-4 sm:px-6">
                                    <span class="inline-flex rounded-md bg-gray-100 px-2.5 py-1 text-xs font-mono font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                        {{ $mp->kode }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $mp->nama }}</p>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    @php
                                        $badgeColor = match($mp->kategori) {
                                            'Wajib'       => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                            'Peminatan'   => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                            'Lintas Minat'=> 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
                                            default       => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $badgeColor }}">
                                        {{ $mp->kategori }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 sm:px-6 text-center">
                                    <span class="inline-flex items-center justify-center rounded-full w-9 h-9 text-sm font-bold
                                        {{ $mp->jam_pelajaran >= 4 ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' :
                                           ($mp->jam_pelajaran == 3 ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' :
                                           'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400') }}">
                                        {{ $mp->jam_pelajaran }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 max-w-xs truncate" title="{{ $mp->deskripsi }}">
                                        {{ $mp->deskripsi ?? '-' }}
                                    </p>
                                </td>
                                @if (auth()->user()->hasPermission('edit-mata-pelajaran') || auth()->user()->hasPermission('delete-mata-pelajaran') || auth()->user()->hasPermission('manage-mata-pelajaran') || auth()->user()->hasPermission('view-mata-pelajaran'))
                                <td class="px-5 py-4 sm:px-6">
                                    <div class="flex items-center gap-2">
                                        @if (auth()->user()->hasPermission('view-mata-pelajaran') || auth()->user()->hasPermission('manage-mata-pelajaran'))
                                        <a href="{{ route('mata-pelajaran.show', $mp) }}" title="Lihat Detail & Silabus"
                                            class="inline-flex items-center justify-center rounded-lg border border-blue-300 bg-white px-3 py-2 text-sm font-medium text-blue-600 shadow-theme-xs transition hover:bg-blue-50 dark:border-blue-600 dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-blue-900/10">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                                <circle cx="12" cy="12" r="3"/>
                                            </svg>
                                        </a>
                                        @endif

                                        @if (auth()->user()->hasPermission('edit-mata-pelajaran') || auth()->user()->hasPermission('manage-mata-pelajaran'))
                                        <a href="{{ route('mata-pelajaran.edit', $mp) }}" title="Edit Mata Pelajaran"
                                            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-theme-xs transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>
                                        </a>
                                        @endif

                                        @if (auth()->user()->hasPermission('delete-mata-pelajaran') || auth()->user()->hasPermission('manage-mata-pelajaran'))
                                        <form action="{{ route('mata-pelajaran.destroy', $mp) }}" method="POST"
                                            onsubmit="return confirm('Hapus mata pelajaran {{ $mp->nama }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center rounded-lg border border-red-300 bg-white px-3 py-2 text-sm font-medium text-red-600 shadow-theme-xs transition hover:bg-red-50 dark:border-red-700 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-red-900/10">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                </svg>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ (auth()->user()->hasPermission('edit-mata-pelajaran') || auth()->user()->hasPermission('delete-mata-pelajaran') || auth()->user()->hasPermission('manage-mata-pelajaran') || auth()->user()->hasPermission('view-mata-pelajaran')) ? '6' : '5' }}" class="px-5 py-12 text-center sm:px-6">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        <p class="mt-4 text-sm font-medium text-gray-900 dark:text-white">
                                            @if(request()->hasAny(['search', 'kategori', 'min_jam', 'max_jam']))
                                                Tidak ada mata pelajaran yang sesuai dengan filter
                                            @else
                                                Belum ada data mata pelajaran
                                            @endif
                                        </p>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            @if(request()->hasAny(['search', 'kategori', 'min_jam', 'max_jam']))
                                                Coba ubah atau reset filter pencarian
                                            @else
                                                Jalankan seeder untuk menambahkan data mata pelajaran
                                            @endif
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($mataPelajaran->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-800">
                    {{ $mataPelajaran->links() }}
                </div>
            @endif
        </div>

        <!-- Information Panel -->
        <div class="rounded-lg border border-blue-200 bg-blue-50 p-4 dark:border-blue-800 dark:bg-blue-900/20">
            <div class="flex gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 flex-shrink-0 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm text-blue-700 dark:text-blue-400">
                    <p class="font-semibold text-blue-800 dark:text-blue-300">Informasi Kurikulum Merdeka</p>
                    <div class="mt-2 space-y-1">
                        <p><strong>Wajib:</strong> Mata pelajaran yang wajib diikuti semua siswa (termasuk semua agama, Informatika, BK, dan Muatan Lokal)</p>
                        <p><strong>Peminatan:</strong> Mata pelajaran sesuai peminatan (MIPA/IPS dengan mata pelajaran lanjutan)</p>
                        <p><strong>Lintas Minat:</strong> Mata pelajaran pilihan lintas peminatan (bahasa asing dan keterampilan khusus)</p>
                        <p class="text-xs mt-2"><em>Sesuai dengan Peraturan Kemendikdasmen terbaru 2024. Jam/Minggu menentukan batas maksimal slot jadwal per minggu per kelas.</em></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
