@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Input Nilai" />

    <div class="space-y-6" x-data="{
        kelasId: '{{ old('kelas_id') }}',
        mapelId: '{{ old('mata_pelajaran_id') }}',
        kategori: '{{ old('kategori') }}',
        silabusId: '{{ old('silabus_id') }}',
        silabusList: [],
        siswaList: [],
        existingNilai: {},
        loadingSiswa: false,
        loadingSilabus: false,

        async init() {
            if (this.kelasId) {
                await this.fetchSiswa();
            }
            if (this.mapelId) {
                await this.fetchSilabus();
            }
        },

        async fetchSiswa() {
            if (!this.kelasId) {
                this.siswaList = [];
                return;
            }
            this.loadingSiswa = true;
            try {
                const response = await fetch(`/api/kelas/${this.kelasId}/siswa`);
                this.siswaList = await response.json();
            } catch (e) {
                console.error('Error fetching students:', e);
            } finally {
                this.loadingSiswa = false;
            }
            this.fetchExistingNilai();
        },

        async fetchSilabus() {
            if (!this.mapelId) {
                this.silabusList = [];
                this.silabusId = '';
                return;
            }
            this.loadingSilabus = true;
            try {
                const url = `/api/mata-pelajaran/${this.mapelId}/silabus` + (this.kategori ? `?kategori=${this.kategori}` : '');
                const response = await fetch(url);
                this.silabusList = await response.json();
            } catch (e) {
                console.error('Error fetching syllabus:', e);
            } finally {
                this.loadingSilabus = false;
            }
            this.silabusId = '';
            this.fetchExistingNilai();
        },

        async fetchExistingNilai() {
            if (!this.kelasId || !this.mapelId || !this.silabusId) {
                this.existingNilai = {};
                // Clear inputs
                this.siswaList.forEach(siswa => {
                    const input = document.getElementById(`nilai_${siswa.id}`);
                    if (input) input.value = '';
                });
                return;
            }
            try {
                const response = await fetch(`/api/nilai/get-existing?kelas_id=${this.kelasId}&mata_pelajaran_id=${this.mapelId}&silabus_id=${this.silabusId}`);
                this.existingNilai = await response.json();
                
                // Populate inputs
                this.siswaList.forEach(siswa => {
                    const input = document.getElementById(`nilai_${siswa.id}`);
                    if (input) {
                        input.value = this.existingNilai[siswa.id] !== undefined ? this.existingNilai[siswa.id] : '';
                    }
                });
            } catch (e) {
                console.error('Error fetching existing grades:', e);
            }
        }
    }" x-init="init()">
        @if(session('success'))
            <div class="rounded-xl border border-green-200 bg-green-50 p-4 dark:border-green-800 dark:bg-green-900/20">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800 dark:text-green-300">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-800 dark:bg-red-900/20">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-300">Terjadi Kesalahan</h3>
                        <ul class="mt-2 list-disc list-inside text-sm text-red-700 dark:text-red-400">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 dark:bg-indigo-900/30">
                        <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Input Nilai Siswa</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Pilih Kelas, Mata Pelajaran, dan Silabus untuk menginputkan nilai siswa.</p>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('nilai.store') }}" method="POST" id="nilaiForm">
            @csrf

            <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Filter Penilaian</h3>
                </div>

                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        <!-- Dropdown Kelas + Search -->
                        <div x-data="{
                            open: false,
                            search: '',
                            selectedName: 'Pilih Kelas',
                            options: [
                                @foreach($kelasList as $kelas)
                                    { id: '{{ $kelas->id }}', name: '{{ $kelas->nama }}' },
                                @endforeach
                            ],
                            get filteredOptions() {
                                return this.options.filter(opt => opt.name.toLowerCase().includes(this.search.toLowerCase()));
                            },
                            select(opt) {
                                this.selectedName = opt.name;
                                $data.kelasId = opt.id;
                                this.open = false;
                                this.search = '';
                                $data.fetchSiswa();
                            },
                            init() {
                                const initial = this.options.find(opt => opt.id == $data.kelasId);
                                if (initial) {
                                    this.selectedName = initial.name;
                                }
                            }
                        }">
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                Kelas <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <button type="button" @click="open = !open"
                                        class="flex w-full items-center justify-between rounded-lg border border-gray-300 bg-white px-4 py-3 text-left text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                    <span x-text="selectedName"></span>
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <input type="hidden" name="kelas_id" :value="kelasId" required>

                                <div x-show="open" @click.outside="open = false" x-cloak
                                     class="absolute z-50 mt-1 w-full rounded-lg border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800">
                                    <div class="p-2 border-b border-gray-200 dark:border-gray-700">
                                        <input type="text" x-model="search" placeholder="Cari kelas..."
                                               class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    </div>
                                    <ul class="max-h-60 overflow-y-auto p-1">
                                        <template x-for="opt in filteredOptions" :key="opt.id">
                                            <li>
                                                <button type="button" @click="select(opt)"
                                                        class="w-full px-3 py-2 text-left text-sm hover:bg-indigo-50 hover:text-indigo-600 rounded-md dark:hover:bg-gray-700 dark:hover:text-white dark:text-gray-300">
                                                    <span x-text="opt.name"></span>
                                                </button>
                                            </li>
                                        </template>
                                        <template x-if="filteredOptions.length === 0">
                                            <li class="px-3 py-2 text-sm text-gray-500 dark:text-gray-400">Tidak ada hasil</li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Dropdown Mata Pelajaran + Search -->
                        <div x-data="{
                            open: false,
                            search: '',
                            selectedName: 'Pilih Mata Pelajaran',
                            options: [
                                @foreach($mataPelajaranList as $mapel)
                                    { id: '{{ $mapel->id }}', name: '{{ $mapel->nama }}' },
                                @endforeach
                            ],
                            get filteredOptions() {
                                return this.options.filter(opt => opt.name.toLowerCase().includes(this.search.toLowerCase()));
                            },
                            select(opt) {
                                this.selectedName = opt.name;
                                $data.mapelId = opt.id;
                                this.open = false;
                                this.search = '';
                                $data.fetchSilabus();
                            },
                            init() {
                                const initial = this.options.find(opt => opt.id == $data.mapelId);
                                if (initial) {
                                    this.selectedName = initial.name;
                                }
                            }
                        }">
                            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                Mata Pelajaran <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <button type="button" @click="open = !open"
                                        class="flex w-full items-center justify-between rounded-lg border border-gray-300 bg-white px-4 py-3 text-left text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                    <span x-text="selectedName"></span>
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <input type="hidden" name="mata_pelajaran_id" :value="mapelId" required>

                                <div x-show="open" @click.outside="open = false" x-cloak
                                     class="absolute z-50 mt-1 w-full rounded-lg border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800">
                                    <div class="p-2 border-b border-gray-200 dark:border-gray-700">
                                        <input type="text" x-model="search" placeholder="Cari mapel..."
                                               class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    </div>
                                    <ul class="max-h-60 overflow-y-auto p-1">
                                        <template x-for="opt in filteredOptions" :key="opt.id">
                                            <li>
                                                <button type="button" @click="select(opt)"
                                                        class="w-full px-3 py-2 text-left text-sm hover:bg-indigo-50 hover:text-indigo-600 rounded-md dark:hover:bg-gray-700 dark:hover:text-white dark:text-gray-300">
                                                    <span x-text="opt.name"></span>
                                                </button>
                                            </li>
                                        </template>
                                        <template x-if="filteredOptions.length === 0">
                                            <li class="px-3 py-2 text-sm text-gray-500 dark:text-gray-400">Tidak ada hasil</li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Dropdown Kategori -->
                        <div>
                            <label for="kategori" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select name="kategori" id="kategori" required x-model="kategori" @change="fetchSilabus()"
                                    class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                <option value="">Pilih Kategori</option>
                                <option value="formatif">Formatif</option>
                                <option value="sumatif">Sumatif</option>
                            </select>
                        </div>

                        <!-- Dropdown Silabus -->
                        <div>
                            <label for="silabus_id" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                Silabus <span class="text-red-500">*</span>
                            </label>
                            <select name="silabus_id" id="silabus_id" required x-model="silabusId" @change="fetchExistingNilai()" :disabled="!mapelId || silabusList.length === 0"
                                    class="block w-full rounded-lg border border-gray-300 px-4 py-3 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-100 disabled:cursor-not-allowed dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:disabled:bg-gray-700">
                                <option value="">Pilih Silabus</option>
                                <template x-for="silabus in silabusList" :key="silabus.id">
                                    <option :value="silabus.id" x-text="silabus.tujuan_pembelajaran.length > 80 ? silabus.tujuan_pembelajaran.substring(0, 80) + '...' : silabus.tujuan_pembelajaran" :selected="silabus.id == silabusId"></option>
                                </template>
                            </select>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400" x-show="loadingSilabus">
                                <svg class="inline-block h-4 w-4 animate-spin mr-1 text-indigo-600" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Memuat silabus...
                            </p>
                            <p class="mt-1 text-sm text-yellow-600 dark:text-yellow-400" x-show="!loadingSilabus && mapelId && silabusList.length === 0">
                                Tidak ada silabus aktif yang disetujui untuk mata pelajaran ini.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- List Siswa -->
            <div class="mt-6 rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Daftar Nilai Siswa</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Daftar siswa di kelas terpilih.</p>
                    </div>
                </div>

                <div class="p-6">
                    <div x-show="loadingSiswa" class="text-center py-12">
                        <svg class="inline-block h-8 w-8 animate-spin text-indigo-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Memuat daftar siswa...</p>
                    </div>

                    <div x-show="!loadingSiswa && siswaList.length === 0" class="flex flex-col items-center justify-center py-12 text-center">
                        <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Pilih kelas terlebih dahulu untuk memuat daftar siswa.</p>
                    </div>

                    <div x-show="!loadingSiswa && siswaList.length > 0" class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800/50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">No</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">NISN</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Nama Siswa</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Nilai (0-100)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-transparent">
                                <template x-for="(siswa, index) in siswaList" :key="siswa.id">
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                        <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-900 dark:text-white" x-text="index + 1"></td>
                                        <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-500 dark:text-gray-400" x-text="siswa.nisn"></td>
                                        <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-gray-900 dark:text-white" x-text="siswa.name"></td>
                                        <td class="px-4 py-3">
                                            <input type="number" :name="'nilai[' + siswa.id + ']'" :id="'nilai_' + siswa.id"
                                                   min="0" max="100" placeholder="0-100"
                                                   class="block w-32 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="mt-6 flex justify-end space-x-3">
                <button type="submit" :disabled="!kelasId || !mapelId || !silabusId || siswaList.length === 0"
                        class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed dark:focus:ring-offset-gray-800">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Nilai
                </button>
            </div>
        </form>
    </div>
@endsection
