@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Manajemen Silabus" />

    <div class="space-y-6">
        @session('success')
            <div class="rounded-xl border border-green-200 bg-green-50 p-4 dark:border-green-800 dark:bg-green-900/20">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800 dark:text-green-300">Berhasil!</h3>
                        <div class="mt-1 text-sm text-green-700 dark:text-green-400">{{ $value }}</div>
                    </div>
                </div>
            </div>
        @endsession

        @session('error')
            <div class="rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-800 dark:bg-red-900/20">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-300">Terjadi Kesalahan</h3>
                        <div class="mt-1 text-sm text-red-700 dark:text-red-400">{{ $value }}</div>
                    </div>
                </div>
            </div>
        @endsession

        <!-- Page Header -->
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/30">
                        <svg class="h-7 w-7 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Silabus Pembelajaran</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Kelola silabus mata pelajaran dengan sistem persetujuan terintegrasi
                        </p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    @if(auth()->user()->hasPermission('manage-silabus') || auth()->user()->hasPermission('create-silabus'))
                        <a href="{{ route('silabus.create') }}"
                           class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Tambah Silabus
                        </a>
                    @endif

                    <button type="button"
                            onclick="toggleFilters()"
                            class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"/>
                        </svg>
                        Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/30">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Silabus</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/30">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Disetujui</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['approved'] }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-yellow-100 dark:bg-yellow-900/30">
                        <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Menunggu</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['pending'] }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 dark:bg-emerald-900/30">
                        <svg class="h-6 w-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Aktif</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['aktif'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters (Hidden by default) -->
        <div id="filterSection" class="hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Filter & Pencarian</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Gunakan filter untuk mempersempit hasil pencarian</p>
            </div>
            <form method="GET" class="p-6">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Pencarian
                        </label>
                        <input type="text"
                               name="search"
                               id="search"
                               value="{{ request('search') }}"
                               placeholder="Cari tujuan pembelajaran..."
                               class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white sm:text-sm">
                    </div>

                    <!-- Mata Pelajaran Filter -->
                    <div>
                        <label for="mata_pelajaran_id" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Mata Pelajaran
                        </label>
                        <select name="mata_pelajaran_id"
                                id="mata_pelajaran_id"
                                class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white sm:text-sm">
                            <option value="">Semua Mata Pelajaran</option>
                            @foreach($mataPelajaran as $mapel)
                                <option value="{{ $mapel->id }}" {{ request('mata_pelajaran_id') == $mapel->id ? 'selected' : '' }}>
                                    {{ $mapel->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Kategori Filter -->
                    <div>
                        <label for="kategori" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Kategori
                        </label>
                        <select name="kategori"
                                id="kategori"
                                class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white sm:text-sm">
                            <option value="">Semua Kategori</option>
                            <option value="formatif" {{ request('kategori') == 'formatif' ? 'selected' : '' }}>📝 Formatif</option>
                            <option value="sumatif" {{ request('kategori') == 'sumatif' ? 'selected' : '' }}>📊 Sumatif</option>
                        </select>
                    </div>

                    @if(auth()->user()->hasRole(['super-admin', 'akademik']))
                        <!-- Status Filter -->
                        <div>
                            <label for="approval_status" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Status Persetujuan
                            </label>
                            <select name="approval_status"
                                    id="approval_status"
                                    class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white sm:text-sm">
                                <option value="">Semua Status</option>
                                <option value="draft" {{ request('approval_status') == 'draft' ? 'selected' : '' }}>📝 Draft</option>
                                <option value="pending_approval" {{ request('approval_status') == 'pending_approval' ? 'selected' : '' }}>⏳ Menunggu</option>
                                <option value="approved" {{ request('approval_status') == 'approved' ? 'selected' : '' }}>✅ Disetujui</option>
                                <option value="rejected" {{ request('approval_status') == 'rejected' ? 'selected' : '' }}>❌ Ditolak</option>
                            </select>
                        </div>
                    @endif
                </div>

                <!-- Filter Actions -->
                <div class="mt-6 flex items-center justify-end space-x-3">
                    <a href="{{ route('silabus.index') }}"
                       class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                        Reset
                    </a>
                    <button type="submit"
                            class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Main Content -->
        <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <!-- Content Header -->
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            Daftar Silabus
                            @if($silabus->total() > 0)
                                <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">
                                    ({{ $silabus->total() }} total)
                                </span>
                            @endif
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Kelola dan pantau status persetujuan silabus pembelajaran
                        </p>
                    </div>

                    <div class="flex items-center space-x-3">
                        <!-- Quick Stats -->
                        <div class="hidden sm:flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                            <span>📝 {{ $stats['formatif'] }} Formatif</span>
                            <span>📊 {{ $stats['sumatif'] }} Sumatif</span>
                            @if(auth()->user()->hasRole(['super-admin', 'akademik']))
                                <span>⏳ {{ $stats['pending'] }} Menunggu</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800/50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                #
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Mata Pelajaran
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Tujuan Pembelajaran
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Kategori
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Dibuat Oleh
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                        @forelse($silabus as $index => $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <!-- Number -->
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $silabus->firstItem() + $index }}
                                </td>

                                <!-- Mata Pelajaran -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/30">
                                            <span class="text-xs font-medium text-blue-600 dark:text-blue-400">
                                                {{ substr($item->mataPelajaran->kode, 0, 2) }}
                                            </span>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $item->mataPelajaran->nama }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $item->mataPelajaran->kode }} • {{ $item->mataPelajaran->kategori }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Tujuan Pembelajaran -->
                                <td class="px-6 py-4">
                                    <div class="max-w-xs">
                                        <p class="text-sm text-gray-900 dark:text-white line-clamp-3">
                                            {{ Str::limit($item->tujuan_pembelajaran, 150) }}
                                        </p>
                                    </div>
                                </td>

                                <!-- Kategori -->
                                <td class="px-6 py-4">
                                    <div class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-xs font-medium
                                        {{ $item->kategori === 'formatif' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' }}">
                                        <span class="mr-1">{{ $item->kategori === 'formatif' ? '📝' : '📊' }}</span>
                                        {{ ucfirst($item->kategori) }}
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    <div class="flex flex-col space-y-1">
                                        <!-- Approval Status -->
                                        <div class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-xs font-medium
                                            @if($item->approval_status === 'draft')
                                                bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                            @elseif($item->approval_status === 'pending_approval')
                                                bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                            @elseif($item->approval_status === 'approved')
                                                bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                            @elseif($item->approval_status === 'rejected')
                                                bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                            @endif">
                                            <span class="mr-1">
                                                @if($item->approval_status === 'draft') 📝
                                                @elseif($item->approval_status === 'pending_approval') ⏳
                                                @elseif($item->approval_status === 'approved') ✅
                                                @elseif($item->approval_status === 'rejected') ❌
                                                @endif
                                            </span>
                                            @if($item->approval_status === 'draft') Draft
                                            @elseif($item->approval_status === 'pending_approval') Menunggu
                                            @elseif($item->approval_status === 'approved') Disetujui
                                            @elseif($item->approval_status === 'rejected') Ditolak
                                            @endif
                                        </div>

                                        <!-- Active Status (only if approved) -->
                                        @if($item->approval_status === 'approved')
                                            <div class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-xs font-medium
                                                {{ $item->status === 'aktif' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                                <span class="mr-1">{{ $item->status === 'aktif' ? '🟢' : '🔘' }}</span>
                                                {{ $item->status === 'aktif' ? 'Aktif' : 'Non-aktif' }}
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Created By -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700">
                                            <span class="text-xs font-medium text-gray-600 dark:text-gray-300">
                                                {{ substr($item->createdBy->name, 0, 1) }}{{ substr(explode(' ', $item->createdBy->name)[1] ?? '', 0, 1) }}
                                            </span>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm text-gray-900 dark:text-white">
                                                {{ $item->createdBy->name }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $item->created_at->format('d M Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="relative">
                                        <button type="button"
                                                onclick="toggleActionMenu({{ $item->id }})"
                                                class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                            </svg>
                                            Aksi
                                            <svg class="h-4 w-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </button>

                                        <!-- Actions Dropdown Menu -->
                                        <div id="actionMenu-{{ $item->id }}" class="hidden absolute right-0 z-10 mt-2 w-48 rounded-lg bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 dark:bg-gray-800 dark:ring-gray-700">
                                            <!-- View Action -->
                                            @can('view', $item)
                                                <a href="{{ route('silabus.show', $item) }}"
                                                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                                    <svg class="h-4 w-4 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    Lihat Detail
                                                </a>
                                            @endcan

                                            <!-- Edit Action -->
                                            @can('update', $item)
                                                @if($item->canBeEdited())
                                                    <a href="{{ route('silabus.edit', $item) }}"
                                                       class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                                        <svg class="h-4 w-4 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                        Edit Silabus
                                                    </a>
                                                @endif
                                            @endcan

                                            <!-- Submit for Approval -->
                                            @can('update', $item)
                                                @if($item->approval_status === 'draft')
                                                    <button type="button"
                                                            onclick="submitForApproval({{ $item->id }})"
                                                            class="flex w-full items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                                        <svg class="h-4 w-4 mr-3 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                                        </svg>
                                                        Ajukan Persetujuan
                                                    </button>
                                                @endif
                                            @endcan

                                            <!-- Approval Actions -->
                                            @can('approve', $item)
                                                @if($item->approval_status === 'pending_approval')
                                                    <div class="border-t border-gray-100 dark:border-gray-700">
                                                        <button type="button"
                                                                onclick="approveItem({{ $item->id }})"
                                                                class="flex w-full items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                                            <svg class="h-4 w-4 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            Setujui Silabus
                                                        </button>

                                                        <button type="button"
                                                                onclick="showRejectModal({{ $item->id }})"
                                                                class="flex w-full items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                                            <svg class="h-4 w-4 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                            Tolak Silabus
                                                        </button>
                                                    </div>
                                                @endif

                                                @if($item->approval_status === 'approved')
                                                    <div class="border-t border-gray-100 dark:border-gray-700">
                                                        <button type="button"
                                                                onclick="toggleStatus({{ $item->id }}, '{{ $item->status }}')"
                                                                class="flex w-full items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                                            @if($item->status === 'aktif')
                                                                <svg class="h-4 w-4 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L5.636 5.636"/>
                                                                </svg>
                                                                Nonaktifkan Silabus
                                                            @else
                                                                <svg class="h-4 w-4 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                </svg>
                                                                Aktifkan Silabus
                                                            @endif
                                                        </button>
                                                    </div>
                                                @endif
                                            @endcan

                                            <!-- Delete Action -->
                                            @can('delete', $item)
                                                @if($item->canBeDeleted())
                                                    <div class="border-t border-gray-100 dark:border-gray-700">
                                                        <button type="button"
                                                                onclick="deleteItem({{ $item->id }})"
                                                                class="flex w-full items-center px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:text-red-400 dark:hover:bg-gray-700">
                                                            <svg class="h-4 w-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                            Hapus Silabus
                                                        </button>
                                                    </div>
                                                @endif
                                            @endcan
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="flex h-20 w-20 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                            <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <h3 class="mt-4 text-sm font-medium text-gray-900 dark:text-white">Belum ada silabus</h3>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                            Mulai dengan membuat silabus pertama untuk mata pelajaran Anda.
                                        </p>
                                        @if(auth()->user()->hasPermission('manage-silabus') || auth()->user()->hasPermission('create-silabus'))
                                            <div class="mt-6">
                                                <a href="{{ route('silabus.create') }}"
                                                   class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                    </svg>
                                                    Buat Silabus Pertama
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($silabus->hasPages())
                <div class="border-t border-gray-200 bg-white px-6 py-4 dark:border-gray-800 dark:bg-gray-800">
                    {{ $silabus->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="hideRejectModal()"></div>

            <div class="inline-block w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all dark:bg-gray-800">
                <div class="flex items-center">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Tolak Silabus</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Berikan alasan penolakan yang jelas untuk membantu penulis memperbaiki silabus
                        </p>
                    </div>
                </div>

                <form id="rejectForm" method="POST" class="mt-6">
                    @csrf
                    <div class="mb-4">
                        <label for="rejection_reason" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Alasan Penolakan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="rejection_reason"
                                  id="rejection_reason"
                                  rows="4"
                                  required
                                  placeholder="Contoh: Tujuan pembelajaran belum mengikuti format ABCD yang ditetapkan Kemendikbud..."
                                  class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-red-500 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"></textarea>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button"
                                onclick="hideRejectModal()"
                                class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                            Batal
                        </button>
                        <button type="submit"
                                class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700">
                            Tolak Silabus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Hidden Forms for Actions -->
    <form id="submitApprovalForm" method="POST" style="display: none;">
        @csrf
    </form>

    <form id="approveForm" method="POST" style="display: none;">
        @csrf
    </form>

    <form id="toggleStatusForm" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
    </form>

    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    @push('scripts')
    <script>
        // Action menu toggle
        function toggleActionMenu(silabusId) {
            // Close all other menus first
            document.querySelectorAll('[id^="actionMenu-"]').forEach(menu => {
                if (menu.id !== `actionMenu-${silabusId}`) {
                    menu.classList.add('hidden');
                }
            });

            // Toggle current menu
            const menu = document.getElementById(`actionMenu-${silabusId}`);
            menu.classList.toggle('hidden');
        }

        // Close action menus when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('[onclick^="toggleActionMenu"]') && !event.target.closest('[id^="actionMenu-"]')) {
                document.querySelectorAll('[id^="actionMenu-"]').forEach(menu => {
                    menu.classList.add('hidden');
                });
            }
        });

        // Action functions
        function submitForApproval(silabusId) {
            if (confirm('Ajukan silabus untuk persetujuan?')) {
                document.getElementById('submitApprovalForm').action = `/silabus/${silabusId}/submit-approval`;
                document.getElementById('submitApprovalForm').submit();
            }
        }

        function approveItem(silabusId) {
            if (confirm('Setujui silabus ini?')) {
                document.getElementById('approveForm').action = `/silabus/${silabusId}/approve`;
                document.getElementById('approveForm').submit();
            }
        }

        function toggleStatus(silabusId, currentStatus) {
            const action = currentStatus === 'aktif' ? 'Nonaktifkan' : 'Aktifkan';
            if (confirm(`${action} silabus ini?`)) {
                document.getElementById('toggleStatusForm').action = `/silabus/${silabusId}/toggle-status`;
                document.getElementById('toggleStatusForm').submit();
            }
        }

        function deleteItem(silabusId) {
            if (confirm('Hapus silabus ini? Aksi ini tidak dapat dibatalkan.')) {
                document.getElementById('deleteForm').action = `/silabus/${silabusId}`;
                document.getElementById('deleteForm').submit();
            }
        }

        // Filter toggle
        function toggleFilters() {
            const filterSection = document.getElementById('filterSection');
            filterSection.classList.toggle('hidden');
        }

        // Reject modal
        function showRejectModal(silabusId) {
            document.getElementById('rejectForm').action = `/silabus/${silabusId}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
            document.getElementById('rejection_reason').focus();
        }

        function hideRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('rejection_reason').value = '';
        }

        // Close modals on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                hideRejectModal();
                // Close action menus
                document.querySelectorAll('[id^="actionMenu-"]').forEach(menu => {
                    menu.classList.add('hidden');
                });
            }
        });
    </script>
    @endpush
@endsection
