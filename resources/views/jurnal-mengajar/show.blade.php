@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Detail Jurnal Mengajar" />

    <div class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-indigo-100 dark:bg-indigo-900/30">
                        <svg class="h-7 w-7 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Detail Jurnal Mengajar</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $jurnalMengajar->tanggal->format('l, d F Y') }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    @if(auth()->user()->hasPermission('manage-jurnal-mengajar') || auth()->user()->hasPermission('edit-jurnal-mengajar'))
                        <a href="{{ route('jurnal-mengajar.edit', $jurnalMengajar) }}"
                           class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                    @endif
                    <a href="{{ route('jurnal-mengajar.index') }}"
                       class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-6">
                <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Informasi Jurnal</h3>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kelas</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                        {{ $jurnalMengajar->guruMapelKelas->kelas->nama ?? '-' }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Mata Pelajaran</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $jurnalMengajar->guruMapelKelas->mataPelajaran->nama ?? '-' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Guru</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $jurnalMengajar->guruMapelKelas->guru->name ?? '-' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal & Waktu</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $jurnalMengajar->tanggal->format('d M Y') }},
                                    {{ \Carbon\Carbon::parse($jurnalMengajar->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jurnalMengajar->waktu_selesai)->format('H:i') }}
                                </dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Silabus / Tujuan Pembelajaran</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-800">
                                        {{ $jurnalMengajar->silabus->tujuan_pembelajaran ?? '-' }}
                                        <span class="mt-2 inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ ($jurnalMengajar->silabus->kategori ?? '') == 'formatif' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' : 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400' }}">
                                            {{ ucfirst($jurnalMengajar->silabus->kategori ?? '-') }}
                                        </span>
                                    </div>
                                </dd>
                            </div>
                            @if($jurnalMengajar->catatan)
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Catatan</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $jurnalMengajar->catatan }}
                                </dd>
                            </div>
                            @endif
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dibuat oleh</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $jurnalMengajar->createdBy->name ?? '-' }}
                                    <span class="text-gray-500 dark:text-gray-400">pada {{ $jurnalMengajar->created_at->format('d M Y H:i') }}</span>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Daftar Absensi Siswa</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800/50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">No</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">NISN</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Nama Siswa</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-transparent">
                                @forelse($jurnalMengajar->absensi as $index => $absensi)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $index + 1 }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $absensi->siswa->nisn ?? '-' }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $absensi->siswa->name ?? '-' }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            @php
                                                $statusClasses = [
                                                    'hadir' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                                    'sakit' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                                    'izin' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                                    'alfa' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                                ];
                                            @endphp
                                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusClasses[$absensi->status] ?? '' }}">
                                                {{ ucfirst($absensi->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $absensi->keterangan ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                            Tidak ada data absensi
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Statistik Kehadiran</h3>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30">
                                    <svg class="h-4 w-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-white">Hadir</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $absensiStats['hadir'] }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-900/30">
                                    <svg class="h-4 w-4 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-white">Sakit</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $absensiStats['sakit'] }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30">
                                    <svg class="h-4 w-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-white">Izin</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $absensiStats['izin'] }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                                    <svg class="h-4 w-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </div>
                                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-white">Alfa</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $absensiStats['alfa'] }}</span>
                        </div>

                        <div class="border-t border-gray-200 pt-4 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Total Siswa</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $absensiStats['total'] }}</span>
                            </div>
                        </div>

                        @if($absensiStats['total'] > 0)
                            <div class="mt-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Persentase Kehadiran</span>
                                    <span class="text-sm font-semibold text-green-600 dark:text-green-400">
                                        {{ round(($absensiStats['hadir'] / $absensiStats['total']) * 100) }}%
                                    </span>
                                </div>
                                <div class="h-2 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                                    <div class="h-2 rounded-full bg-green-500" style="width: {{ ($absensiStats['hadir'] / $absensiStats['total']) * 100 }}%"></div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

