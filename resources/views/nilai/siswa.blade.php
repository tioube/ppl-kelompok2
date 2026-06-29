@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Daftar Nilai" />

    <div x-data="{
        selectedSubject: null,
        subjects: {{ json_encode($nilaiGrouped) }},
        hasSubjects() {
            return Object.keys(this.subjects).length > 0;
        }
    }" class="space-y-6">

        <!-- Top Header Card -->
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center">
                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Laporan Hasil Belajar</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Tahun Ajaran: <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $tahunAjaranAktif?->tahun ?? '-' }}</span>
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-400 dark:text-gray-500">Nilai Kelulusan KKM: <span class="font-bold text-green-600 dark:text-green-400">75</span></span>
                </div>
            </div>
        </div>

        <template x-if="!hasSubjects()">
            <div class="flex flex-col items-center justify-center rounded-xl border border-gray-200 bg-white py-16 text-center dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-50 dark:bg-gray-800/50 mb-4">
                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Belum Ada Nilai</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 max-w-sm">Data nilai Anda belum diinputkan oleh guru untuk mata pelajaran di tahun ajaran aktif ini.</p>
            </div>
        </template>

        <template x-if="hasSubjects()">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
                <!-- Left Panel: Subject List -->
                <div class="lg:col-span-4 space-y-4">
                    <div class="flex items-center justify-between">
                        <h4 class="text-sm font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Pilih Mata Pelajaran</h4>
                        <span class="text-xs text-gray-500" x-text="`${Object.keys(subjects).length} Mata Pelajaran`"></span>
                    </div>

                    <div class="space-y-3 overflow-y-auto max-h-[600px] pr-1">
                        <template x-for="(data, name) in subjects" :key="name">
                            <button
                                @click="selectedSubject = name"
                                :class="selectedSubject === name ? 'border-indigo-600 ring-2 ring-indigo-500/10 dark:ring-indigo-400/20 bg-indigo-50/50 dark:bg-indigo-950/20' : 'border-gray-200 dark:border-gray-800 bg-white dark:bg-white/[0.02] hover:bg-gray-50/50 dark:hover:bg-gray-800/30'"
                                class="w-full text-left p-4 rounded-xl border shadow-sm transition-all duration-200 flex items-center justify-between gap-4"
                            >
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-gray-900 dark:text-white truncate" x-text="name"></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-0.5" x-text="`Guru: ${data.guru}`"></p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span
                                        :class="data.average >= 75 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400'"
                                        class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-xs font-bold"
                                        x-text="data.average"
                                    ></span>
                                </div>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Right Panel: Grades Detail -->
                <div class="lg:col-span-8">
                    <!-- Empty State (No Subject Selected) -->
                    <template x-if="!selectedSubject">
                        <div class="h-full flex flex-col items-center justify-center rounded-xl border border-dashed border-gray-300 dark:border-gray-700 bg-white/50 p-12 text-center dark:bg-transparent min-h-[400px]">
                            <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                            </svg>
                            <h3 class="mt-4 text-md font-semibold text-gray-900 dark:text-white">Lihat Detail Nilai</h3>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 max-w-xs mx-auto">Silakan pilih salah satu mata pelajaran di sebelah kiri untuk melihat rincian nilai formatif & sumatif Anda.</p>
                        </div>
                    </template>

                    <!-- Details Displayed -->
                    <template x-if="selectedSubject">
                        <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
                            <!-- Card Header Info -->
                            <div class="bg-gray-50/50 px-6 py-5 dark:bg-gray-800/40 border-b border-gray-200 dark:border-gray-700 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div>
                                    <h4 class="text-xl font-bold text-gray-900 dark:text-white" x-text="selectedSubject"></h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" x-text="`Guru Pengajar: ${subjects[selectedSubject].guru}`"></p>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="text-right">
                                        <p class="text-xs text-gray-400 uppercase tracking-wider">Rata-rata Nilai</p>
                                        <p class="text-2xl font-black mt-0.5 text-indigo-600 dark:text-indigo-400" x-text="subjects[selectedSubject].average"></p>
                                    </div>
                                    <div class="h-10 w-px bg-gray-200 dark:bg-gray-700"></div>
                                    <div>
                                        <span
                                            :class="subjects[selectedSubject].average >= 75 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'"
                                            class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wider"
                                            x-text="subjects[selectedSubject].average >= 75 ? 'Tuntas KKM' : 'Perlu Remedial'"
                                        ></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Grades Tables -->
                            <div class="p-6 space-y-6">
                                <!-- Formatif Section -->
                                <div>
                                    <h5 class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-3 flex items-center">
                                        <span class="inline-block h-1.5 w-1.5 rounded-full bg-indigo-600 dark:bg-indigo-400 mr-2"></span>
                                        Penilaian Formatif
                                    </h5>
                                    
                                    <template x-if="!subjects[selectedSubject].grades.formatif || subjects[selectedSubject].grades.formatif.length === 0">
                                        <p class="text-sm text-gray-500 dark:text-gray-400 italic bg-gray-50 dark:bg-gray-800/20 p-4 rounded-lg border border-gray-100 dark:border-gray-800">Belum ada nilai formatif yang diinputkan.</p>
                                    </template>

                                    <template x-if="subjects[selectedSubject].grades.formatif && subjects[selectedSubject].grades.formatif.length > 0">
                                        <div class="overflow-x-auto rounded-xl border border-gray-100 dark:border-gray-800">
                                            <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-800">
                                                <thead class="bg-gray-50/50 dark:bg-gray-800/10">
                                                    <tr>
                                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Tujuan Pembelajaran (Silabus)</th>
                                                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 w-28">Nilai</th>
                                                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 w-32">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-800 dark:bg-transparent">
                                                    <template x-for="grade in subjects[selectedSubject].grades.formatif">
                                                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/20 transition-colors">
                                                            <td class="px-4 py-3.5 text-sm text-gray-900 dark:text-white" x-text="grade.tujuan_pembelajaran"></td>
                                                            <td class="px-4 py-3.5 text-center text-sm font-bold text-gray-900 dark:text-white" x-text="grade.nilai"></td>
                                                            <td class="px-4 py-3.5 text-center">
                                                                <span
                                                                    :class="grade.nilai >= 75 ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400'"
                                                                    class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"
                                                                    x-text="grade.nilai >= 75 ? 'Tuntas' : 'Remedial'"
                                                                ></span>
                                                            </td>
                                                        </tr>
                                                    </template>
                                                </tbody>
                                            </table>
                                        </div>
                                    </template>
                                </div>

                                <!-- Sumatif Section -->
                                <div>
                                    <h5 class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider mb-3 flex items-center">
                                        <span class="inline-block h-1.5 w-1.5 rounded-full bg-emerald-600 dark:bg-emerald-400 mr-2"></span>
                                        Penilaian Sumatif
                                    </h5>

                                    <template x-if="!subjects[selectedSubject].grades.sumatif || subjects[selectedSubject].grades.sumatif.length === 0">
                                        <p class="text-sm text-gray-500 dark:text-gray-400 italic bg-gray-50 dark:bg-gray-800/20 p-4 rounded-lg border border-gray-100 dark:border-gray-800">Belum ada nilai sumatif yang diinputkan.</p>
                                    </template>

                                    <template x-if="subjects[selectedSubject].grades.sumatif && subjects[selectedSubject].grades.sumatif.length > 0">
                                        <div class="overflow-x-auto rounded-xl border border-gray-100 dark:border-gray-800">
                                            <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-800">
                                                <thead class="bg-gray-50/50 dark:bg-gray-800/10">
                                                    <tr>
                                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Tujuan Pembelajaran (Silabus)</th>
                                                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 w-28">Nilai</th>
                                                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 w-32">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-800 dark:bg-transparent">
                                                    <template x-for="grade in subjects[selectedSubject].grades.sumatif">
                                                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/20 transition-colors">
                                                            <td class="px-4 py-3.5 text-sm text-gray-900 dark:text-white" x-text="grade.tujuan_pembelajaran"></td>
                                                            <td class="px-4 py-3.5 text-center text-sm font-bold text-gray-900 dark:text-white" x-text="grade.nilai"></td>
                                                            <td class="px-4 py-3.5 text-center">
                                                                <span
                                                                    :class="grade.nilai >= 75 ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400'"
                                                                    class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"
                                                                    x-text="grade.nilai >= 75 ? 'Tuntas' : 'Remedial'"
                                                                ></span>
                                                            </td>
                                                        </tr>
                                                    </template>
                                                </tbody>
                                            </table>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </template>

    </div>
@endsection
