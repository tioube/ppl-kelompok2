@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Tambah Silabus Baru" />

    <div class="space-y-6">
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
                        <div class="mt-1 text-sm text-red-700 dark:text-red-400">
                            {{ $value }}
                        </div>
                    </div>
                </div>
            </div>
        @endsession

        <!-- Journey Progress -->
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Membuat Silabus Baru</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Isi informasi silabus sesuai standar Kemendikbud</p>
                    </div>
                </div>
                <div class="hidden sm:block">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 text-xs font-medium text-white">1</div>
                            <span class="ml-2 text-sm font-medium text-blue-600 dark:text-blue-400">Input Data</span>
                        </div>
                        <svg class="h-5 w-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        <div class="flex items-center">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-200 text-xs font-medium text-gray-500 dark:bg-gray-700 dark:text-gray-400">2</div>
                            <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">Review</span>
                        </div>
                        <svg class="h-5 w-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        <div class="flex items-center">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-200 text-xs font-medium text-gray-500 dark:bg-gray-700 dark:text-gray-400">3</div>
                            <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">Approval</span>
                        </div>
                    </div>
                </div>
                <a href="{{ route('silabus.index') }}"
                   class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Main Form -->
        <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Informasi Silabus</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Masukkan detail silabus dengan mengikuti format tujuan pembelajaran ABCD (Audience, Behavior, Condition, Degree)
                </p>
            </div>

            <form action="{{ route('silabus.store') }}" method="POST" class="p-6 space-y-6" id="silabusForm">
                @csrf

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <!-- Tahun Ajaran Selection -->
                    <div>
                        <label for="tahun_ajaran_id" class="mb-3 block text-sm font-medium text-gray-900 dark:text-white">
                            <div class="flex items-center">
                                <svg class="mr-2 h-5 w-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Tahun Ajaran <span class="text-red-500">*</span>
                            </div>
                        </label>
                        <select name="tahun_ajaran_id"
                                id="tahun_ajaran_id"
                                required
                                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('tahun_ajaran_id') border-red-500 dark:border-red-500 @enderror">
                            <option value="">Pilih Tahun Ajaran</option>
                            @foreach($tahunAjaranList as $ta)
                                <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id', $tahunAjaranAktif?->id) == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->tahun }} {{ $ta->is_active ? '(Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('tahun_ajaran_id')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mata Pelajaran Selection -->
                    <div>
                        <label for="mata_pelajaran_id" class="mb-3 block text-sm font-medium text-gray-900 dark:text-white">
                            <div class="flex items-center">
                                <svg class="mr-2 h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                Mata Pelajaran <span class="text-red-500">*</span>
                            </div>
                        </label>
                        <select name="mata_pelajaran_id"
                                id="mata_pelajaran_id"
                                required
                                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('mata_pelajaran_id') border-red-500 dark:border-red-500 @enderror">
                            <option value="">Pilih Mata Pelajaran</option>
                            @foreach($mataPelajaran as $mapel)
                                <option value="{{ $mapel->id }}"
                                        data-kategori="{{ $mapel->kategori }}"
                                        {{ (old('mata_pelajaran_id', $selectedMataPelajaranId ?? null) == $mapel->id) ? 'selected' : '' }}>
                                    {{ $mapel->nama }} ({{ $mapel->kode }}) - {{ $mapel->kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('mata_pelajaran_id')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori Assessment -->
                    <div>
                        <label for="kategori" class="mb-3 block text-sm font-medium text-gray-900 dark:text-white">
                            <div class="flex items-center">
                                <svg class="mr-2 h-5 w-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h2m-1-9l3 3 3-3m-3-3v12"/>
                                </svg>
                                Kategori Penilaian <span class="text-red-500">*</span>
                            </div>
                        </label>
                        <select name="kategori"
                                id="kategori"
                                required
                                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-purple-500 focus:ring-purple-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('kategori') border-red-500 dark:border-red-500 @enderror">
                            <option value="">Pilih Kategori</option>
                            <option value="formatif" {{ old('kategori') == 'formatif' ? 'selected' : '' }}>
                                📝 Formatif (Penilaian Harian)
                            </option>
                            <option value="sumatif" {{ old('kategori') == 'sumatif' ? 'selected' : '' }}>
                                📊 Sumatif (Penilaian Akhir)
                            </option>
                        </select>
                        @error('kategori')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror

                        <!-- Dynamic Category Info -->
                        <div id="kategoriInfo" class="mt-3 hidden">
                            <div id="formatifInfo" class="hidden rounded-lg bg-blue-50 p-3 dark:bg-blue-900/20">
                                <h4 class="text-sm font-medium text-blue-900 dark:text-blue-300">Penilaian Formatif</h4>
                                <p class="mt-1 text-xs text-blue-800 dark:text-blue-400">
                                    Untuk mengidentifikasi, menjelaskan, membandingkan, mengklasifikasikan konsep pembelajaran
                                </p>
                                <div class="mt-2">
                                    <p class="text-xs font-medium text-blue-900 dark:text-blue-300">Kata Kerja Operasional:</p>
                                    <p class="text-xs text-blue-800 dark:text-blue-400">mengidentifikasi, menjelaskan, membandingkan, mengklasifikasikan, mencontohkan</p>
                                </div>
                            </div>

                            <div id="sumatifInfo" class="hidden rounded-lg bg-purple-50 p-3 dark:bg-purple-900/20">
                                <h4 class="text-sm font-medium text-purple-900 dark:text-purple-300">Penilaian Sumatif</h4>
                                <p class="mt-1 text-xs text-purple-800 dark:text-purple-400">
                                    Untuk menganalisis, mengevaluasi, mencipta, merancang solusi kompleks
                                </p>
                                <div class="mt-2">
                                    <p class="text-xs font-medium text-purple-900 dark:text-purple-300">Kata Kerja Operasional:</p>
                                    <p class="text-xs text-purple-800 dark:text-purple-400">menganalisis, mengevaluasi, mencipta, merancang, mengkritik</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Urutan -->
                    <div>
                        <label for="urutan" class="mb-3 block text-sm font-medium text-gray-900 dark:text-white">
                            <div class="flex items-center">
                                <svg class="mr-2 h-5 w-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                                Urutan Silabus
                            </div>
                        </label>
                        <input type="number"
                               name="urutan"
                               id="urutan"
                               min="0"
                               value="{{ old('urutan', 0) }}"
                               placeholder="Contoh: 1, 2, 3..."
                               class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-green-500 focus:ring-green-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('urutan') border-red-500 dark:border-red-500 @enderror">
                        @error('urutan')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            Nomor urutan untuk pengurutan silabus. Kosongkan atau isi 0 untuk urutan terakhir.
                        </p>
                    </div>
                </div>

                <!-- Tujuan Pembelajaran -->
                <div>
                    <label for="tujuan_pembelajaran" class="mb-3 block text-sm font-medium text-gray-900 dark:text-white">
                        <div class="flex items-center">
                            <svg class="mr-2 h-5 w-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Tujuan Pembelajaran <span class="text-red-500">*</span>
                        </div>
                    </label>

                    <div class="relative">
                        <textarea name="tujuan_pembelajaran"
                                  id="tujuan_pembelajaran"
                                  rows="5"
                                  required
                                  placeholder="Tuliskan tujuan pembelajaran mengikuti format ABCD...

Contoh: Setelah mengikuti pembelajaran, peserta didik mampu menganalisis struktur teks eksposisi dengan tepat berdasarkan kaidah kebahasaan yang berlaku dengan akurasi minimal 80%."
                                  class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-yellow-500 focus:ring-yellow-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('tujuan_pembelajaran') border-red-500 dark:border-red-500 @enderror">{{ old('tujuan_pembelajaran') }}</textarea>

                        <!-- Character counter -->
                        <div class="absolute bottom-2 right-2 text-xs text-gray-400 dark:text-gray-500">
                            <span id="charCount">{{ strlen(old('tujuan_pembelajaran', '')) }}</span> karakter
                        </div>
                    </div>

                    @error('tujuan_pembelajaran')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror

                    <div class="mt-2 flex justify-between text-xs text-gray-500 dark:text-gray-400">
                        <span>Minimum 10 karakter</span>
                        <span>Menggunakan format ABCD Kemendikbud</span>
                    </div>
                </div>

                <!-- ABCD Format Guide -->
                <div class="rounded-lg border border-amber-200 bg-amber-50 p-4 dark:border-amber-800 dark:bg-amber-900/20">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-amber-800 dark:text-amber-300">
                                Panduan Format ABCD (Kemendikbud)
                            </h4>
                            <div class="mt-2 text-sm text-amber-700 dark:text-amber-400">
                                <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                                    <div>
                                        <p class="font-medium">📍 A (Audience):</p>
                                        <p class="text-xs">"Setelah mengikuti pembelajaran, peserta didik..."</p>
                                    </div>
                                    <div>
                                        <p class="font-medium">🎯 B (Behavior):</p>
                                        <p class="text-xs">Kata kerja operasional yang terukur</p>
                                    </div>
                                    <div>
                                        <p class="font-medium">🏫 C (Condition):</p>
                                        <p class="text-xs">Kondisi/situasi pembelajaran</p>
                                    </div>
                                    <div>
                                        <p class="font-medium">📊 D (Degree):</p>
                                        <p class="text-xs">Kriteria keberhasilan yang terukur</p>
                                    </div>
                                </div>

                                <div class="mt-3 rounded bg-amber-100 p-2 dark:bg-amber-900/30">
                                    <p class="text-xs font-medium">✨ Contoh Lengkap:</p>
                                    <p class="mt-1 text-xs italic">
                                        "Setelah mengikuti pembelajaran, peserta didik mampu menganalisis struktur teks eksposisi dengan tepat berdasarkan kaidah kebahasaan yang berlaku dengan akurasi minimal 80%."
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col-reverse gap-3 border-t border-gray-200 pt-6 sm:flex-row sm:justify-end dark:border-gray-800">
                    <a href="{{ route('silabus.index') }}"
                       class="inline-flex w-full justify-center items-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 sm:w-auto">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex w-full justify-center items-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 sm:w-auto">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Simpan Draft Silabus
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Character counter
            const textarea = document.getElementById('tujuan_pembelajaran');
            const charCount = document.getElementById('charCount');

            if (textarea && charCount) {
                textarea.addEventListener('input', function() {
                    charCount.textContent = this.value.length;

                    // Color change based on length
                    if (this.value.length < 10) {
                        charCount.className = 'text-red-500';
                    } else if (this.value.length < 50) {
                        charCount.className = 'text-yellow-500';
                    } else {
                        charCount.className = 'text-green-500';
                    }
                });
            }

            // Auto-resize textarea
            if (textarea) {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });
            }

            // Category selection handler
            const kategoriSelect = document.getElementById('kategori');
            const kategoriInfo = document.getElementById('kategoriInfo');
            const formatifInfo = document.getElementById('formatifInfo');
            const sumatifInfo = document.getElementById('sumatifInfo');

            if (kategoriSelect) {
                kategoriSelect.addEventListener('change', function() {
                    const value = this.value;

                    if (value) {
                        kategoriInfo.classList.remove('hidden');

                        if (value === 'formatif') {
                            formatifInfo.classList.remove('hidden');
                            sumatifInfo.classList.add('hidden');
                        } else if (value === 'sumatif') {
                            sumatifInfo.classList.remove('hidden');
                            formatifInfo.classList.add('hidden');
                        }
                    } else {
                        kategoriInfo.classList.add('hidden');
                        formatifInfo.classList.add('hidden');
                        sumatifInfo.classList.add('hidden');
                    }
                });

                // Trigger on page load if there's an old value
                if (kategoriSelect.value) {
                    kategoriSelect.dispatchEvent(new Event('change'));
                }
            }

            // Mata pelajaran selection enhancement
            const mataPelajaranSelect = document.getElementById('mata_pelajaran_id');

            if (mataPelajaranSelect) {
                mataPelajaranSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    if (selectedOption.value) {
                        const kategoriMapel = selectedOption.getAttribute('data-kategori');

                        // Could add some visual feedback here
                        console.log('Mata Pelajaran selected:', selectedOption.text);
                        console.log('Kategori:', kategoriMapel);
                    }
                });
            }

            // Form validation enhancement
            const form = document.getElementById('silabusForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const tujuanPembelajaran = document.getElementById('tujuan_pembelajaran').value;

                    if (tujuanPembelajaran.length < 10) {
                        e.preventDefault();
                        alert('Tujuan pembelajaran harus minimal 10 karakter.');
                        return false;
                    }

                    // Show loading state
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = `
                            <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Menyimpan...
                        `;
                    }
                });
            }
        });
    </script>
    @endpush
@endsection
