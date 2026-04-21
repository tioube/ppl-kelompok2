@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Mata Pelajaran" />

    <div class="space-y-6">
        @session('success')
            <x-ui.alert variant="success">{{ $value }}</x-ui.alert>
        @endsession

        <div class="flex justify-end">
            <a href="{{ route('mata-pelajaran.create') }}"
                class="bg-blue-600 hover:bg-blue-700 flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-white dark:bg-blue-600 dark:hover:bg-blue-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Tambah Mata Pelajaran
            </a>
        </div>

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
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-300">Aksi</p>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $currentKategori = null; @endphp
                        @forelse ($mataPelajaran as $mp)
                            @if($currentKategori !== $mp->kategori)
                                @php $currentKategori = $mp->kategori; @endphp
                                <tr class="bg-gray-100/70 dark:bg-gray-800/60">
                                    <td colspan="6" class="px-5 py-2 sm:px-6">
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
                                <td class="px-5 py-4 sm:px-6">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('mata-pelajaran.edit', $mp) }}"
                                            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-theme-xs transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>
                                        </a>
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
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-8 text-center sm:px-6">
                                    <p class="text-gray-500 dark:text-gray-400">Belum ada data mata pelajaran.</p>
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

        <div class="rounded-lg border border-blue-200 bg-blue-50 p-4 dark:border-blue-800 dark:bg-blue-900/20">
            <div class="flex gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 flex-shrink-0 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm text-blue-700 dark:text-blue-400">
                    <p class="font-semibold text-blue-800 dark:text-blue-300">Aturan Jam Pelajaran</p>
                    <p class="mt-1">Nilai <strong>Jam / Minggu</strong> menentukan berapa kali maksimal mata pelajaran ini dapat dijadwalkan dalam satu minggu per kelas. Contoh: nilai <strong>4</strong> berarti maksimal <strong>4 slot jadwal per minggu</strong> per kelas.</p>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('content')
    <x-common.page-breadcrumb pageTitle="List Mata Pelajaran" />

    <div class="space-y-6">
        @session('success')
            <x-ui.alert variant="success">
                {{ $value }}
            </x-ui.alert>
        @endsession

        @session('error')
            <x-ui.alert variant="danger">
                {{ $value }}
            </x-ui.alert>
        @endsession

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Mata Pelajaran</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">List semua mata pelajaran untuk SMA berdasarkan Kurikulum Merdeka</p>
            </div>

            <div class="max-w-full overflow-x-auto custom-scrollbar">
                <table class="w-full min-w-[1102px]">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Kode</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Nama Mata Pelajaran</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Kategori</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Jam Pelajaran</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Deskripsi</p>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $currentKategori = null;
                        @endphp
                        @forelse ($mataPelajaran as $mp)
                            @if($currentKategori !== $mp->kategori)
                                @php $currentKategori = $mp->kategori; @endphp
                                <tr class="bg-gray-50 dark:bg-gray-800/50">
                                    <td colspan="5" class="px-5 py-2 sm:px-6">
                                        <p class="text-xs font-semibold uppercase text-gray-700 dark:text-gray-300">
                                            {{ $mp->kategori }}
                                        </p>
                                    </td>
                                </tr>
                            @endif
                            <tr class="border-b border-gray-100 dark:border-gray-800">
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
                                            'Wajib' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                            'Peminatan' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                            'Lintas Minat' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
                                            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400'
                                        };
                                    @endphp
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $badgeColor }}">
                                        {{ $mp->kategori }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                        {{ $mp->jam_pelajaran }} jam/minggu
                                    </p>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 max-w-md truncate" title="{{ $mp->deskripsi }}">
                                        {{ $mp->deskripsi ?? '-' }}
                                    </p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-8 text-center sm:px-6">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        <p class="mt-4 text-sm font-medium text-gray-900 dark:text-white">Belum ada data Mata Pelajaran</p>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Jalankan seeder untuk menambahkan data mata pelajaran</p>
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

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 dark:bg-blue-900/20 dark:border-blue-800">
            <div class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">Informasi Kurikulum</h3>
                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-400">
                        <p>Data mata pelajaran mengikuti <strong>Kurikulum Merdeka</strong> untuk tingkat SMA/MA dengan 3 kategori:</p>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li><strong>Wajib:</strong> Mata pelajaran yang wajib diikuti semua siswa</li>
                            <li><strong>Peminatan:</strong> Mata pelajaran sesuai peminatan (MIPA/IPS)</li>
                            <li><strong>Lintas Minat:</strong> Mata pelajaran pilihan lintas peminatan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

