@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Jadwal Pelajaran" />

    <div class="space-y-6">
        @session('success')
            <x-ui.alert variant="success">
                {{ $value }}
            </x-ui.alert>
        @endsession

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex-1">
                <form method="GET" action="{{ route('jadwal-pelajaran.index') }}" class="flex flex-col gap-3 sm:flex-row">
                    <div class="flex-1">
                        <select name="kelas_id" onchange="this.form.submit()"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                    {{ $kelas->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1">
                        <select name="tahun_ajaran_id" onchange="this.form.submit()"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            <option value="">Semua Tahun Ajaran</option>
                            @foreach($tahunAjaranList as $ta)
                                <option value="{{ $ta->id }}" {{ request('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if(request('kelas_id') || request('tahun_ajaran_id'))
                        <a href="{{ route('jadwal-pelajaran.index') }}"
                            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                            Reset
                        </a>
                    @endif
                </form>
            </div>
            <a href="{{ route('jadwal-pelajaran.create') }}" class="bg-blue-600 hover:bg-blue-700 flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-white dark:bg-blue-600 dark:hover:bg-blue-700 transition whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Tambah Jadwal
            </a>
        </div>

        @if($selectedKelas)
            <div class="rounded-lg bg-blue-50 p-4 dark:bg-blue-900/20">
                <p class="text-sm font-medium text-blue-800 dark:text-blue-300">
                    Menampilkan jadwal untuk: <span class="font-bold">{{ $selectedKelas->nama }}</span>
                </p>
            </div>
        @endif

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    @if(request('kelas_id'))
                        Jadwal Kelas: {{ $selectedKelas->nama }}
                    @else
                        Semua Jadwal Pelajaran
                    @endif
                </h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Total: {{ $jadwalPelajarans->total() }} jadwal
                </p>
            </div>

            <div class="max-w-full overflow-x-auto custom-scrollbar">
                <table class="w-full min-w-[1000px]">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50">
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-300">Hari</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-300">Waktu</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-300">Mata Pelajaran</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-300">Guru</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-300">Kelas</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-300">Tahun Ajaran</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-700 text-theme-xs dark:text-gray-300">Aksi</p>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $currentDay = null;
                        @endphp
                        @forelse ($jadwalPelajarans as $jadwal)
                            @if($currentDay !== $jadwal->hari)
                                @php $currentDay = $jadwal->hari; @endphp
                                <tr class="bg-gray-100 dark:bg-gray-800/50">
                                    <td colspan="7" class="px-5 py-2 sm:px-6">
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ $jadwal->hari }}</p>
                                    </td>
                                </tr>
                            @endif
                            <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900/30 transition">
                                <td class="px-5 py-4 sm:px-6">
                                    <p class="text-gray-500 text-sm dark:text-gray-400">{{ $jadwal->hari }}</p>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg>
                                        <p class="font-medium text-gray-900 dark:text-white">
                                            {{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}
                                        </p>
                                    </div>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $jadwal->mataPelajaran->nama }}</p>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    @if($jadwal->guru)
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $jadwal->guru->name }}</p>
                                    @else
                                        <span class="text-sm text-gray-400 dark:text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    <span class="inline-flex rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">
                                        {{ $jadwal->kelas->nama }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $jadwal->tahunAjaran->tahun }}</p>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('jadwal-pelajaran.edit', $jadwal) }}"
                                            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-theme-xs transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]"
                                            title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('jadwal-pelajaran.destroy', $jadwal) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center rounded-lg border border-red-300 bg-white px-3 py-2 text-sm font-medium text-red-600 shadow-theme-xs transition hover:bg-red-50 dark:border-red-700 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-red-900/10"
                                                title="Delete">
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
                                <td colspan="7" class="px-5 py-12 text-center sm:px-6">
                                    <div class="flex flex-col items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="mt-4 text-gray-500 dark:text-gray-400 font-medium">Belum ada jadwal pelajaran</p>
                                        <p class="mt-1 text-sm text-gray-400 dark:text-gray-500">
                                            @if(request('kelas_id'))
                                                Belum ada jadwal untuk kelas ini
                                            @else
                                                Klik "Tambah Jadwal" untuk membuat jadwal baru
                                            @endif
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($jadwalPelajarans->hasPages())
            <div class="mt-4">
                {{ $jadwalPelajarans->links() }}
            </div>
        @endif
    </div>
@endsection

                </table>
            </div>
        </div>



