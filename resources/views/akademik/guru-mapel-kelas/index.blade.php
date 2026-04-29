@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Penugasan Guru" />

    <div class="space-y-6">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/30">
                            <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Penugasan</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/30">
                            <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Guru Bertugas</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['gurus_assigned'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-yellow-100 dark:bg-yellow-900/30">
                            <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Mata Pelajaran</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['mapel_assigned'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900/30">
                            <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Kelas Tercakup</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['kelas_covered'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Aksi Penugasan</h3>
                <div class="flex items-center gap-3">
                    <form action="{{ route('guru-mapel-kelas.generate') }}" method="POST" class="inline"
                        onsubmit="return confirm('Generate otomatis akan membuat penugasan untuk semua kombinasi guru-mapel-kelas. Lanjutkan?')">
                        @csrf
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 rounded-lg px-4 py-2 text-sm font-medium text-white dark:bg-blue-600 dark:hover:bg-blue-700 transition">
                            <i class="fas fa-magic mr-2"></i>Generate Otomatis
                        </button>
                    </form>
                    <form action="{{ route('guru-mapel-kelas.clear') }}" method="POST" class="inline"
                        onsubmit="return confirm('Yakin ingin menghapus SEMUA penugasan? Tindakan ini tidak dapat dibatalkan!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 rounded-lg px-4 py-2 text-sm font-medium text-white dark:bg-red-600 dark:hover:bg-red-700 transition">
                            <i class="fas fa-trash-alt mr-2"></i>Hapus Semua
                        </button>
                    </form>
                    <a href="{{ route('guru-mapel-kelas.create') }}"
                        class="bg-green-600 hover:bg-green-700 rounded-lg px-4 py-2 text-sm font-medium text-white dark:bg-green-600 dark:hover:bg-green-700 transition">
                        <i class="fas fa-plus mr-2"></i>Tambah Penugasan
                    </a>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
            <form method="GET" action="{{ route('guru-mapel-kelas.index') }}" class="space-y-4" id="filterForm">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Filter & Pencarian</h3>
                    <div class="flex gap-2">
                        @if(request()->hasAny(['search', 'guru_id', 'mata_pelajaran_id', 'kelas_id']))
                            <a href="{{ route('guru-mapel-kelas.index') }}"
                               class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Reset Filter
                            </a>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
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
                                   placeholder="Cari guru, mata pelajaran, atau kelas..."
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Guru Filter -->
                    <div>
                        <label for="guru_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Guru</label>
                        <select name="guru_id" id="guru_id" class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Guru</option>
                            @foreach($gurus as $guru)
                                <option value="{{ $guru->id }}" {{ ($filters['guru_id'] ?? '') == $guru->id ? 'selected' : '' }}>
                                    {{ $guru->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Mata Pelajaran Filter -->
                    <div>
                        <label for="mata_pelajaran_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mata Pelajaran</label>
                        <select name="mata_pelajaran_id" id="mata_pelajaran_id" class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Mapel</option>
                            @foreach($mataPelajarans as $mapel)
                                <option value="{{ $mapel->id }}" {{ ($filters['mata_pelajaran_id'] ?? '') == $mapel->id ? 'selected' : '' }}>
                                    {{ $mapel->nama }} ({{ $mapel->kode }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Kelas Filter -->
                    <div>
                        <label for="kelas_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kelas</label>
                        <select name="kelas_id" id="kelas_id" class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Kelas</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ ($filters['kelas_id'] ?? '') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <div class="flex items-center gap-4">
                        <!-- Sort Options -->
                        <div class="flex items-center gap-2">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Urutkan:</label>
                            <select name="sort" class="px-3 py-1 border border-gray-300 rounded-lg bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="kelas_id" {{ ($filters['sort'] ?? 'kelas_id') === 'kelas_id' ? 'selected' : '' }}>Kelas</option>
                                <option value="guru_id" {{ ($filters['sort'] ?? '') === 'guru_id' ? 'selected' : '' }}>Guru</option>
                                <option value="mata_pelajaran_id" {{ ($filters['sort'] ?? '') === 'mata_pelajaran_id' ? 'selected' : '' }}>Mata Pelajaran</option>
                                <option value="created_at" {{ ($filters['sort'] ?? '') === 'created_at' ? 'selected' : '' }}>Tanggal Dibuat</option>
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
        @if(request()->hasAny(['search', 'guru_id', 'mata_pelajaran_id', 'kelas_id']))
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 dark:bg-yellow-900/20 dark:border-yellow-800">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-800 dark:text-yellow-300">
                            Menampilkan {{ $assignments->count() }} dari {{ $assignments->total() }} penugasan
                            @if($filters['search'] ?? false)
                                yang mengandung "<strong>{{ $filters['search'] }}</strong>"
                            @endif
                            @if($filters['guru_id'] ?? false)
                                untuk guru "<strong>{{ $gurus->find($filters['guru_id'])->name ?? 'Unknown' }}</strong>"
                            @endif
                            @if($filters['mata_pelajaran_id'] ?? false)
                                dengan mata pelajaran "<strong>{{ $mataPelajarans->find($filters['mata_pelajaran_id'])->nama ?? 'Unknown' }}</strong>"
                            @endif
                            @if($filters['kelas_id'] ?? false)
                                di kelas "<strong>{{ $kelas->find($filters['kelas_id'])->nama ?? 'Unknown' }}</strong>"
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Table -->
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Daftar Penugasan Guru</h2>
            </div>

            @if(session('success'))
                <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-green-900/20 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-red-900/20 dark:text-red-400">
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-x-auto rounded-lg shadow-sm">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 text-xs uppercase dark:from-gray-800 dark:to-gray-900">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">No</th>
                            <th scope="col" class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">
                                <div class="flex items-center gap-1">
                                    Guru
                                    @if(($filters['sort'] ?? 'kelas_id') === 'guru_id')
                                        <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if(($filters['direction'] ?? 'asc') === 'asc')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            @endif
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">
                                <div class="flex items-center gap-1">
                                    Mata Pelajaran
                                    @if(($filters['sort'] ?? 'kelas_id') === 'mata_pelajaran_id')
                                        <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if(($filters['direction'] ?? 'asc') === 'asc')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            @endif
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">
                                <div class="flex items-center gap-1">
                                    Kelas
                                    @if(($filters['sort'] ?? 'kelas_id') === 'kelas_id')
                                        <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if(($filters['direction'] ?? 'asc') === 'asc')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            @endif
                                        </svg>
                                    @endif
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($assignments as $index => $assignment)
                            <tr class="bg-white transition-colors hover:bg-gray-50 dark:bg-gray-900 dark:hover:bg-gray-800">
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $assignments->firstItem() + $index }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                            {{ substr($assignment->guru->name, 0, 1) }}
                                        </div>
                                        <span class="font-medium text-gray-900 dark:text-white">{{ $assignment->guru->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $assignment->mataPelajaran->nama }}</div>
                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                        {{ $assignment->mataPelajaran->kode }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        {{ $assignment->kelas->nama }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('guru-mapel-kelas.edit', $assignment) }}"
                                            class="text-blue-600 transition-colors hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
                                            title="Edit">
                                            <i class="fas fa-edit text-lg"></i>
                                        </a>
                                        <form action="{{ route('guru-mapel-kelas.destroy', $assignment) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus penugasan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 transition-colors hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                                                title="Hapus">
                                                <i class="fas fa-trash text-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-600 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 dark:text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white mb-1">
                                            @if(request()->hasAny(['search', 'guru_id', 'mata_pelajaran_id', 'kelas_id']))
                                                Tidak ada penugasan yang sesuai dengan filter
                                            @else
                                                Belum ada penugasan guru
                                            @endif
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            @if(request()->hasAny(['search', 'guru_id', 'mata_pelajaran_id', 'kelas_id']))
                                                Coba ubah atau reset filter pencarian
                                            @else
                                                Gunakan tombol "Generate Otomatis" atau "Tambah Penugasan" untuk memulai
                                            @endif
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($assignments->hasPages())
                <div class="mt-4">
                    {{ $assignments->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form on select change for better UX
    const selectElements = document.querySelectorAll('#filterForm select');
    const searchInput = document.getElementById('search');

    selectElements.forEach(function(select) {
        select.addEventListener('change', function() {
            console.log('Filter changed, submitting form...');
            document.getElementById('filterForm').submit();
        });
    });

    // Optional: Auto-submit on search after typing stops
    let searchTimeout;
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                console.log('Search input changed, submitting form...');
                document.getElementById('filterForm').submit();
            }, 500); // Wait 500ms after user stops typing
        });
    }

    // Debug form submission
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        console.log('Form is being submitted');
        console.log('Form action:', this.action);
        console.log('Form method:', this.method);

        // Log form data
        const formData = new FormData(this);
        console.log('Form data:');
        for (let [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }
    });
});
</script>
@endpush

