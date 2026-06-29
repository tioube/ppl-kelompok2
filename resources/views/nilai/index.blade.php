@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Daftar Nilai Siswa" />

    <div x-data="{
        kelasId: '',
        mapelId: '',
        kategori: '',
        
        searchSiswa: '',
        
        kelasSearch: '',
        kelasOpen: false,
        kelasList: {{ json_encode($kelasList) }},
        selectedKelasName: 'Pilih Kelas',

        mapelSearch: '',
        mapelOpen: false,
        mapelList: {{ json_encode($mataPelajaranList) }},
        selectedMapelName: 'Pilih Mata Pelajaran',

        silabusList: [],
        students: [],
        isLoading: false,

        get formatifSilabus() {
            return this.silabusList.filter(s => s.kategori === 'formatif');
        },

        get sumatifSilabus() {
            return this.silabusList.filter(s => s.kategori === 'sumatif');
        },

        get filteredKelas() {
            if (this.kelasSearch === '') return this.kelasList;
            return this.kelasList.filter(k => k.nama.toLowerCase().includes(this.kelasSearch.toLowerCase()));
        },

        get filteredMapel() {
            if (this.mapelSearch === '') return this.mapelList;
            return this.mapelList.filter(m => m.nama.toLowerCase().includes(this.mapelSearch.toLowerCase()));
        },

        selectKelas(id, name) {
            this.kelasId = id;
            this.selectedKelasName = name;
            this.kelasOpen = false;
            this.kelasSearch = '';
            this.loadReportData();
        },

        selectMapel(id, name) {
            this.mapelId = id;
            this.selectedMapelName = name;
            this.mapelOpen = false;
            this.mapelSearch = '';
            this.loadReportData();
        },

        changeKategori(val) {
            this.kategori = val;
            this.loadReportData();
        },

        get filteredStudents() {
            if (this.searchSiswa === '') return this.students;
            return this.students.filter(s => s.name.toLowerCase().includes(this.searchSiswa.toLowerCase()) || s.nisn.toLowerCase().includes(this.searchSiswa.toLowerCase()));
        },

        // Statistics helper properties
        get stats() {
            const list = this.students.filter(s => s.average !== null);
            if (list.length === 0) {
                return { total: this.students.length, average: 0, passed: 0, failed: 0 };
            }
            const totalAverage = list.reduce((sum, s) => sum + s.average, 0);
            const classAvg = roundVal(totalAverage / list.length, 1);
            const passed = list.filter(s => s.average >= 75).length;
            const failed = list.filter(s => s.average < 75).length;
            return {
                total: this.students.length,
                average: classAvg,
                passed: passed,
                failed: failed
            };
        },

        loadReportData() {
            if (!this.kelasId || !this.mapelId) {
                this.silabusList = [];
                this.students = [];
                return;
            }

            this.isLoading = true;
            let url = `/api/nilai/report?kelas_id=${this.kelasId}&mata_pelajaran_id=${this.mapelId}`;
            if (this.kategori) {
                url += `&kategori=${this.kategori}`;
            }

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    this.silabusList = data.silabus;
                    this.students = data.students;
                    this.isLoading = false;
                })
                .catch(err => {
                    console.error('Error fetching grades report:', err);
                    this.isLoading = false;
                });
        }
    }" class="space-y-6">

        <!-- Selector Filter Card -->
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/[0.03]">
            <h3 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-4">Filter Kelas & Mata Pelajaran</h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <!-- Dropdown Kelas -->
                <div class="relative">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Kelas</label>
                    <button
                        type="button"
                        @click="kelasOpen = !kelasOpen; mapelOpen = false"
                        class="relative w-full rounded-lg border border-gray-300 bg-white py-3 pl-4 pr-10 text-left shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 text-sm text-gray-900 dark:text-white"
                    >
                        <span x-text="selectedKelasName" class="block truncate"></span>
                        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 10l5 5 5-5"/>
                            </svg>
                        </span>
                    </button>

                    <div
                        x-show="kelasOpen"
                        @click.away="kelasOpen = false"
                        class="absolute z-50 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-gray-800 text-sm"
                        x-transition
                    >
                        <div class="sticky top-0 z-10 bg-white px-2 py-1.5 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
                            <input
                                type="text"
                                x-model="kelasSearch"
                                placeholder="Cari kelas..."
                                class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-700 text-gray-900 dark:text-white"
                            >
                        </div>
                        <template x-for="kelas in filteredKelas" :key="kelas.id">
                            <div
                                @click="selectKelas(kelas.id, kelas.nama)"
                                class="relative cursor-pointer select-none py-2.5 pl-4 pr-9 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 text-gray-900 dark:text-white"
                            >
                                <span x-text="kelas.nama" class="block truncate"></span>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Dropdown Mata Pelajaran -->
                <div class="relative">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Mata Pelajaran</label>
                    <button
                        type="button"
                        @click="mapelOpen = !mapelOpen; kelasOpen = false"
                        class="relative w-full rounded-lg border border-gray-300 bg-white py-3 pl-4 pr-10 text-left shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 text-sm text-gray-900 dark:text-white"
                    >
                        <span x-text="selectedMapelName" class="block truncate"></span>
                        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 10l5 5 5-5"/>
                            </svg>
                        </span>
                    </button>

                    <div
                        x-show="mapelOpen"
                        @click.away="mapelOpen = false"
                        class="absolute z-50 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-gray-800 text-sm"
                        x-transition
                    >
                        <div class="sticky top-0 z-10 bg-white px-2 py-1.5 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
                            <input
                                type="text"
                                x-model="mapelSearch"
                                placeholder="Cari mata pelajaran..."
                                class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-700 text-gray-900 dark:text-white"
                            >
                        </div>
                        <template x-for="mapel in filteredMapel" :key="mapel.id">
                            <div
                                @click="selectMapel(mapel.id, mapel.nama)"
                                class="relative cursor-pointer select-none py-2.5 pl-4 pr-9 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 text-gray-900 dark:text-white"
                            >
                                <span x-text="mapel.nama" class="block truncate"></span>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Dropdown Kategori -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori</label>
                    <select
                        @change="changeKategori($el.value)"
                        class="w-full rounded-lg border border-gray-300 bg-white py-3 px-4 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 text-sm text-gray-900 dark:text-white"
                    >
                        <option value="">Semua Kategori</option>
                        <option value="formatif">Formatif Only</option>
                        <option value="sumatif">Sumatif Only</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- KPI Cards Block (Only shown when data is loaded) -->
        <div x-show="kelasId && mapelId && !isLoading && students.length > 0" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <!-- KPI Total Siswa -->
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-white/[0.03] flex items-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 dark:bg-indigo-900/20 dark:text-indigo-400">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Total Siswa</p>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white" x-text="`${stats.total} Siswa`"></h4>
                </div>
            </div>

            <!-- KPI Class Average -->
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-white/[0.03] flex items-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-teal-50 text-teal-600 dark:bg-teal-900/20 dark:text-teal-400">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Rata-rata Kelas</p>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white" x-text="stats.average"></h4>
                </div>
            </div>

            <!-- KPI Passed -->
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-white/[0.03] flex items-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-50 text-green-600 dark:bg-green-900/20 dark:text-green-400">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Siswa Tuntas KKM</p>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white" x-text="`${stats.passed} Siswa`"></h4>
                </div>
            </div>

            <!-- KPI Failed -->
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-white/[0.03] flex items-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Perlu Remedial</p>
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white" x-text="`${stats.failed} Siswa`"></h4>
                </div>
            </div>
        </div>

        <!-- Grades Report Card -->
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
            
            <!-- Loading Indicator -->
            <div x-show="isLoading" class="p-16 text-center">
                <div class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-indigo-600 border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]" role="status"></div>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Memuat laporan nilai...</p>
            </div>

            <!-- Empty Selection State -->
            <div x-show="!kelasId || !mapelId" class="p-16 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-600 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3 class="mt-4 text-md font-semibold text-gray-900 dark:text-white">Pilih Kelas & Mata Pelajaran</h3>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 max-w-xs mx-auto">Silakan tentukan kelas dan mata pelajaran di atas terlebih dahulu untuk menampilkan daftar nilai siswa.</p>
            </div>

            <!-- Main Data Table -->
            <div x-show="kelasId && mapelId && !isLoading" class="p-6 space-y-6">
                
                <!-- Table Header Tools -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-100 pb-4 dark:border-gray-800">
                    <div>
                        <h4 class="text-base font-bold text-gray-900 dark:text-white">
                            Leger Penilaian: <span class="text-indigo-600 dark:text-indigo-400" x-text="selectedKelasName"></span> - <span class="text-indigo-600 dark:text-indigo-400" x-text="selectedMapelName"></span>
                        </h4>
                    </div>
                    <div class="w-full sm:w-64">
                        <input
                            type="text"
                            x-model="searchSiswa"
                            placeholder="Cari nama atau NISN..."
                            class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 text-gray-900 dark:text-white"
                        >
                    </div>
                </div>

                <!-- Empty Student State -->
                <template x-if="students.length === 0">
                    <div class="text-center py-16 border border-dashed border-gray-200 dark:border-gray-800 rounded-xl">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada siswa terdaftar atau data nilai yang cocok di kelas ini.</p>
                    </div>
                </template>

                <!-- Data Matrix -->
                <template x-if="students.length > 0">
                    <div class="space-y-6">
                        <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-800">
                            <table class="w-full table-auto divide-y divide-gray-200 dark:divide-gray-800 text-xs">
                                <thead class="bg-gray-50/80 dark:bg-gray-800/30">
                                    <tr>
                                        <th scope="col" class="px-2 py-3 text-left font-bold text-gray-500 dark:text-gray-400 w-10">No</th>
                                        <th scope="col" class="px-2 py-3 text-left font-bold text-gray-500 dark:text-gray-400 w-24">NISN</th>
                                        <th scope="col" class="px-2 py-3 text-left font-bold text-gray-500 dark:text-gray-400 min-w-[120px]">Nama Siswa</th>
                                        
                                        <!-- Dynamic Formatif Columns -->
                                        <template x-for="(silabus, idx) in formatifSilabus" :key="silabus.id">
                                            <th scope="col" class="px-1 py-3 text-center font-bold text-gray-500 dark:text-gray-400 w-12 cursor-help border-l border-gray-100 dark:border-gray-800" :title="silabus.tujuan_pembelajaran">
                                                <span x-text="`TP ${idx + 1}`" class="block text-[10px]"></span>
                                                <span class="inline-block h-1.5 w-1.5 rounded-full mt-0.5 bg-indigo-500" title="FORMATIF"></span>
                                            </th>
                                        </template>

                                        <!-- Formatif Average Column -->
                                        <th x-show="formatifSilabus.length > 0" scope="col" class="px-2 py-3 text-center font-extrabold text-indigo-600 dark:text-indigo-400 w-20 border-l-2 border-indigo-200 dark:border-indigo-900/60 bg-indigo-50/30 dark:bg-indigo-950/10">Rerata Formatif</th>

                                        <!-- Dynamic Sumatif Columns -->
                                        <template x-for="(silabus, idx) in sumatifSilabus" :key="silabus.id">
                                            <th scope="col" class="px-1 py-3 text-center font-bold text-gray-500 dark:text-gray-400 w-12 cursor-help border-l border-gray-100 dark:border-gray-800" :title="silabus.tujuan_pembelajaran">
                                                <span x-text="`TP ${idx + 1}`" class="block text-[10px]"></span>
                                                <span class="inline-block h-1.5 w-1.5 rounded-full mt-0.5 bg-emerald-500" title="SUMATIF"></span>
                                            </th>
                                        </template>

                                        <!-- Sumatif Average Column -->
                                        <th x-show="sumatifSilabus.length > 0" scope="col" class="px-2 py-3 text-center font-extrabold text-emerald-600 dark:text-emerald-400 w-20 border-l-2 border-emerald-200 dark:border-emerald-900/60 bg-emerald-50/30 dark:bg-emerald-950/10">Rerata Sumatif</th>

                                        <!-- Nilai Akhir Column (Rata-rata dari Rata-rata) -->
                                        <th scope="col" class="px-2 py-3 text-center font-black text-gray-900 dark:text-white w-24 border-l-2 border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/40">Nilai Akhir</th>
                                        <th scope="col" class="px-2 py-3 text-center font-bold text-gray-500 dark:text-gray-400 w-24 border-l border-gray-100 dark:border-gray-800">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-800 dark:bg-transparent">
                                    <template x-for="(student, index) in filteredStudents" :key="student.id">
                                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/20 transition-colors">
                                            <td class="px-2 py-2 text-gray-500 dark:text-gray-400 font-medium" x-text="index + 1"></td>
                                            <td class="px-2 py-2 font-medium text-gray-900 dark:text-white" x-text="student.nisn"></td>
                                            <td class="px-2 py-2 font-semibold text-gray-900 dark:text-white" x-text="student.name"></td>
                                            
                                            <!-- Formatif Grade Cells -->
                                            <template x-for="silabus in formatifSilabus" :key="silabus.id">
                                                <td class="px-1 py-2 text-center border-l border-gray-100 dark:border-gray-800 font-bold">
                                                    <span
                                                        x-text="student.grades[silabus.id] !== null ? student.grades[silabus.id] : '-'"
                                                        :class="student.grades[silabus.id] !== null ? (student.grades[silabus.id] >= 75 ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400') : 'text-gray-300 dark:text-gray-600'"
                                                    ></span>
                                                </td>
                                            </template>

                                            <!-- Formatif Average Cell -->
                                            <td x-show="formatifSilabus.length > 0" class="px-2 py-2 text-center font-extrabold border-l-2 border-indigo-200 dark:border-indigo-900/60 bg-indigo-50/20 dark:bg-indigo-950/5">
                                                <span
                                                    x-text="student.avg_formatif !== null ? student.avg_formatif : '-'"
                                                    :class="student.avg_formatif !== null ? (student.avg_formatif >= 75 ? 'text-indigo-600 dark:text-indigo-400' : 'text-amber-600 dark:text-amber-400') : 'text-gray-300 dark:text-gray-600'"
                                                ></span>
                                            </td>

                                            <!-- Sumatif Grade Cells -->
                                            <template x-for="silabus in sumatifSilabus" :key="silabus.id">
                                                <td class="px-1 py-2 text-center border-l border-gray-100 dark:border-gray-800 font-bold">
                                                    <span
                                                        x-text="student.grades[silabus.id] !== null ? student.grades[silabus.id] : '-'"
                                                        :class="student.grades[silabus.id] !== null ? (student.grades[silabus.id] >= 75 ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400') : 'text-gray-300 dark:text-gray-600'"
                                                    ></span>
                                                </td>
                                            </template>

                                            <!-- Sumatif Average Cell -->
                                            <td x-show="sumatifSilabus.length > 0" class="px-2 py-2 text-center font-extrabold border-l-2 border-emerald-200 dark:border-emerald-900/60 bg-emerald-50/20 dark:bg-emerald-950/5">
                                                <span
                                                    x-text="student.avg_sumatif !== null ? student.avg_sumatif : '-'"
                                                    :class="student.avg_sumatif !== null ? (student.avg_sumatif >= 75 ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400') : 'text-gray-300 dark:text-gray-600'"
                                                ></span>
                                            </td>

                                            <!-- Final Average (Nilai Akhir) Cell -->
                                            <td class="px-2 py-2 text-center font-black border-l-2 border-gray-300 dark:border-gray-700 bg-gray-50/40 dark:bg-gray-800/10">
                                                <span
                                                    x-text="student.average !== null ? student.average : '-'"
                                                    :class="student.average !== null ? (student.average >= 75 ? 'text-indigo-600 dark:text-indigo-400' : 'text-rose-600 dark:text-rose-400') : 'text-gray-300 dark:text-gray-600'"
                                                ></span>
                                            </td>

                                            <!-- Status Cell -->
                                            <td class="px-2 py-2 text-center">
                                                <template x-if="student.average !== null">
                                                    <span
                                                        :class="student.average >= 75 ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400'"
                                                        class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-medium"
                                                        x-text="student.status"
                                                    ></span>
                                                </template>
                                                <template x-if="student.average === null">
                                                    <span class="text-gray-400 font-normal">-</span>
                                                </template>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>

                        <!-- Legend Table (Daftar Keterangan TP) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 rounded-xl border border-gray-200 bg-gray-50/50 p-6 dark:border-gray-800 dark:bg-gray-900/20">
                            <!-- Formatif Legend -->
                            <div>
                                <h5 class="flex items-center gap-1.5 text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-4">
                                    <span class="inline-block h-2 w-2 rounded-full bg-indigo-500"></span> Keterangan TP Formatif
                                </h5>
                                <div class="space-y-3">
                                    <template x-for="(silabus, idx) in formatifSilabus" :key="silabus.id">
                                        <div class="flex items-start gap-2.5 text-xs text-gray-700 dark:text-gray-300">
                                            <span class="font-bold text-indigo-600 dark:text-indigo-400 w-10 flex-shrink-0" x-text="`TP ${idx + 1}`"></span>
                                            <span x-text="silabus.tujuan_pembelajaran" class="text-gray-900 dark:text-gray-100"></span>
                                        </div>
                                    </template>
                                    <template x-if="formatifSilabus.length === 0">
                                        <p class="text-xs text-gray-400">Tidak ada tujuan pembelajaran formatif.</p>
                                    </template>
                                </div>
                            </div>
                            
                            <!-- Sumatif Legend -->
                            <div class="border-t pt-6 md:border-t-0 md:pt-0 md:border-l md:pl-6 border-gray-200 dark:border-gray-800">
                                <h5 class="flex items-center gap-1.5 text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider mb-4">
                                    <span class="inline-block h-2 w-2 rounded-full bg-emerald-500"></span> Keterangan TP Sumatif
                                </h5>
                                <div class="space-y-3">
                                    <template x-for="(silabus, idx) in sumatifSilabus" :key="silabus.id">
                                        <div class="flex items-start gap-2.5 text-xs text-gray-700 dark:text-gray-300">
                                            <span class="font-bold text-emerald-600 dark:text-emerald-400 w-10 flex-shrink-0" x-text="`TP ${idx + 1}`"></span>
                                            <span x-text="silabus.tujuan_pembelajaran" class="text-gray-900 dark:text-gray-100"></span>
                                        </div>
                                    </template>
                                    <template x-if="sumatifSilabus.length === 0">
                                        <p class="text-xs text-gray-400">Tidak ada tujuan pembelajaran sumatif.</p>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

            </div>
        </div>

    </div>

    <script>
        // Inline math rounding helper for Alpine
        function roundVal(value, decimals) {
            return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
        }
    </script>
@endsection
