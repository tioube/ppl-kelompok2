@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="List Siswa" />

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

        <div class="flex flex-wrap items-center justify-between gap-4">
            <form action="{{ route('siswa.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
                <select name="tahun_ajaran_id" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white" onchange="this.form.submit()">
                    <option value="">Semua Tahun Ajaran</option>
                    @foreach($tahunAjaranList as $ta)
                        <option value="{{ $ta->id }}" {{ request('tahun_ajaran_id', $selectedTahunAjaran) == $ta->id ? 'selected' : '' }}>
                            {{ $ta->tahun }} {{ $ta->is_active ? '(Aktif)' : '' }}
                        </option>
                    @endforeach
                </select>
                <select name="kelas_id" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white" onchange="this.form.submit()">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama }}</option>
                    @endforeach
                </select>
                <select name="jurusan_id" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white" onchange="this.form.submit()">
                    <option value="">Semua Jurusan</option>
                    @foreach($jurusanList as $jurusan)
                        <option value="{{ $jurusan->id }}" {{ request('jurusan_id') == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
                    @endforeach
                </select>
                <select name="status" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="naik_kelas" {{ request('status') == 'naik_kelas' ? 'selected' : '' }}>Naik Kelas</option>
                    <option value="lulus" {{ request('status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                    <option value="pindah" {{ request('status') == 'pindah' ? 'selected' : '' }}>Pindah</option>
                </select>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/NISN/email..." class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                <button type="submit" class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300">Cari</button>
                @if(request()->hasAny(['tahun_ajaran_id', 'kelas_id', 'jurusan_id', 'status', 'search']))
                    <a href="{{ route('siswa.index') }}" class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300">Reset</a>
                @endif
            </form>

            <div class="flex gap-2">
                @if (auth()->user()->hasPermission('manage-siswa'))
                <a href="{{ route('kenaikan-kelas.index') }}" class="bg-green-600 hover:bg-green-700 flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-white transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="18 15 12 9 6 15"></polyline>
                    </svg>
                    Kenaikan Kelas
                </a>
                @endif
                @if (auth()->user()->hasPermission('create-siswa') || auth()->user()->hasPermission('manage-siswa'))
                <a href="{{ route('siswa.create') }}" class="bg-blue-600 hover:bg-blue-700 flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-white dark:bg-blue-600 dark:hover:bg-blue-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Tambah Siswa
                </a>
                @endif
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Siswa</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kelola data siswa</p>
            </div>

            <div class="max-w-full overflow-x-auto custom-scrollbar">
                <table class="w-full min-w-[1200px]">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Siswa</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">NISN</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Kelas</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Jurusan</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Tahun Ajaran</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Aksi</p>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswas as $siswaTahunAjaran)
                            @php $siswa = $siswaTahunAjaran->siswa; @endphp
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="px-5 py-4 sm:px-6">
                                    <div class="flex items-center gap-3">
                                        @if($siswa->photo_profile)
                                            <img src="{{ Storage::url($siswa->photo_profile) }}" alt="{{ $siswa->name }}" class="h-10 w-10 rounded-full object-cover">
                                        @else
                                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30">
                                                <span class="font-medium text-blue-800 dark:text-blue-400">{{ $siswa->initials() }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $siswa->name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $siswa->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    <p class="text-gray-900 dark:text-white">{{ $siswa->nisn ?? '-' }}</p>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    @if($siswaTahunAjaran->kelas)
                                        <span class="inline-flex rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">
                                            {{ $siswaTahunAjaran->kelas->nama }}
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-400 dark:text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    @if($siswaTahunAjaran->jurusan)
                                        <p class="text-gray-900 dark:text-white text-sm">{{ $siswaTahunAjaran->jurusan->nama }}</p>
                                    @else
                                        <span class="text-sm text-gray-400 dark:text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    @if($siswaTahunAjaran->tahunAjaran)
                                        <p class="text-gray-900 dark:text-white text-sm">{{ $siswaTahunAjaran->tahunAjaran->tahun }}</p>
                                    @else
                                        <span class="text-sm text-gray-400 dark:text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    @php
                                        $statusColors = [
                                            'aktif' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                            'naik_kelas' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                            'lulus' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
                                            'pindah' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                            'dikeluarkan' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                            'cuti' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400',
                                        ];
                                    @endphp
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-medium {{ $statusColors[$siswaTahunAjaran->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst(str_replace('_', ' ', $siswaTahunAjaran->status)) }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    <div class="flex items-center gap-2">
                                        @if (auth()->user()->hasPermission('view-siswa') || auth()->user()->hasPermission('manage-siswa'))
                                        <a href="{{ route('siswa.show', $siswa) }}"
                                            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-theme-xs transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]"
                                            title="View">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                        </a>
                                        @endif
                                        @if (auth()->user()->hasPermission('edit-siswa') || auth()->user()->hasPermission('manage-siswa'))
                                        <a href="{{ route('siswa.edit', $siswa) }}"
                                            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-theme-xs transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03]"
                                            title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                            </svg>
                                        </a>
                                        @endif
                                        @if (auth()->user()->hasPermission('delete-siswa') || auth()->user()->hasPermission('manage-siswa'))
                                        <form action="{{ route('siswa.destroy', $siswa) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')">
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
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-8 text-center sm:px-6">
                                    <p class="text-gray-500 dark:text-gray-400">Belum ada data siswa.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($siswas->hasPages())
            <div class="mt-4">
                {{ $siswas->links() }}
            </div>
        @endif
    </div>
@endsection

