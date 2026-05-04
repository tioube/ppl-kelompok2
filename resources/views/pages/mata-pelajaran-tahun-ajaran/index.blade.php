@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Mapping Mata Pelajaran per Tahun Ajaran" />

    <div class="space-y-6">
        @session('success')
            <x-ui.alert variant="success">{{ $value }}</x-ui.alert>
        @endsession

        @session('error')
            <x-ui.alert variant="danger">{{ $value }}</x-ui.alert>
        @endsession

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Aktif di Tahun Ini</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['active'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-900/30">
                            <svg class="h-6 w-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tidak Aktif</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['inactive'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pilih Tahun Ajaran</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Tentukan mata pelajaran mana yang aktif di setiap tahun ajaran</p>
                    </div>

                    <form action="{{ route('mata-pelajaran-tahun-ajaran.index') }}" method="GET" class="flex items-center gap-3">
                        <select name="tahun_ajaran_id" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white" onchange="this.form.submit()">
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            @foreach($tahunAjaranList as $ta)
                                <option value="{{ $ta->id }}" {{ $selectedTahunAjaran == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->tahun }} {{ $ta->is_active ? '(Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>

            @if($selectedTahunAjaran)
            <div class="p-6">
                <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-medium text-blue-800 dark:text-blue-200">Copy dari Tahun Ajaran Sebelumnya</h4>
                            <p class="text-sm text-blue-600 dark:text-blue-300">Salin mapping mata pelajaran dari tahun ajaran lain</p>
                        </div>
                        <button type="button" onclick="document.getElementById('copyModal').classList.remove('hidden')"
                            class="bg-blue-600 hover:bg-blue-700 rounded-lg px-4 py-2 text-sm font-medium text-white transition">
                            Copy dari Tahun Lain
                        </button>
                    </div>
                </div>

                <form action="{{ route('mata-pelajaran-tahun-ajaran.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tahun_ajaran_id" value="{{ $selectedTahunAjaran }}">

                    <div class="mb-4">
                        <div class="flex items-center justify-between">
                            <h4 class="text-md font-semibold text-gray-900 dark:text-white">Pilih Mata Pelajaran Aktif</h4>
                            <div class="flex gap-2">
                                <button type="button" onclick="selectAll()" class="text-sm text-blue-600 hover:text-blue-700">Pilih Semua</button>
                                <span class="text-gray-300">|</span>
                                <button type="button" onclick="deselectAll()" class="text-sm text-gray-600 hover:text-gray-700">Hapus Semua</button>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-[500px] overflow-y-auto p-2">
                        @php
                            $groupedMapel = $allMataPelajaran->groupBy('kategori');
                        @endphp

                        @foreach($groupedMapel as $kategori => $mapelList)
                        <div class="col-span-full">
                            <h5 class="font-medium text-gray-700 dark:text-gray-300 mb-2 mt-4 first:mt-0">{{ $kategori }}</h5>
                        </div>
                        @foreach($mapelList as $mapel)
                        <label class="flex items-start gap-3 p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer transition {{ in_array($mapel->id, $mappedMapelIds) ? 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800' : '' }}">
                            <input type="checkbox" name="mata_pelajaran_ids[]" value="{{ $mapel->id }}"
                                class="mapel-checkbox mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                {{ in_array($mapel->id, $mappedMapelIds) ? 'checked' : '' }}>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $mapel->nama }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $mapel->kode }} • {{ $mapel->jam_pelajaran }} JP/minggu</p>
                            </div>
                        </label>
                        @endforeach
                        @endforeach
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 rounded-lg px-6 py-2.5 text-sm font-medium text-white transition">
                            Simpan Mapping
                        </button>
                    </div>
                </form>
            </div>
            @else
            <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                <p>Pilih tahun ajaran terlebih dahulu untuk mengatur mapping mata pelajaran.</p>
            </div>
            @endif
        </div>
    </div>

    <div id="copyModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black opacity-50" onclick="document.getElementById('copyModal').classList.add('hidden')"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Copy Mapping dari Tahun Ajaran Lain</h3>
                <form action="{{ route('mata-pelajaran-tahun-ajaran.copy') }}" method="POST">
                    @csrf
                    <input type="hidden" name="target_tahun_ajaran_id" value="{{ $selectedTahunAjaran }}">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sumber Tahun Ajaran</label>
                        <select name="source_tahun_ajaran_id" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            @foreach($tahunAjaranList as $ta)
                                @if($ta->id != $selectedTahunAjaran)
                                <option value="{{ $ta->id }}">{{ $ta->tahun }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="document.getElementById('copyModal').classList.add('hidden')"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                            Batal
                        </button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 rounded-lg px-4 py-2 text-sm font-medium text-white transition">
                            Copy
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function selectAll() {
            document.querySelectorAll('.mapel-checkbox').forEach(cb => cb.checked = true);
        }
        function deselectAll() {
            document.querySelectorAll('.mapel-checkbox').forEach(cb => cb.checked = false);
        }
    </script>
@endsection

