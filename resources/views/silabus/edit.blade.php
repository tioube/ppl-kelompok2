@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Edit Silabus" />

    <div class="space-y-6">
        @session('error')
            <x-ui.alert variant="error">{{ $value }}</x-ui.alert>
        @endsession

        <!-- Main Content Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            Edit Silabus
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Perbarui silabus untuk {{ $silabus->mataPelajaran->nama }}
                        </p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <!-- Status Badges -->
                        <div class="flex flex-wrap gap-1">
                            @include('silabus.partials.status-badges', [
                                'approvalStatus' => $silabus->approval_status,
                                'status' => $silabus->status,
                                'kategori' => $silabus->kategori
                            ])
                        </div>

                        <a href="{{ route('silabus.index') }}"
                           class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md shadow-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Rejection Notice -->
            @if($silabus->approval_status === 'rejected' && $silabus->rejection_reason)
                <div class="px-6 py-4 bg-red-50 dark:bg-red-900/20 border-b border-red-200 dark:border-red-800">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800 dark:text-red-300">
                                Silabus Ditolak
                            </h3>
                            <div class="mt-1 text-sm text-red-700 dark:text-red-400">
                                <p><strong>Alasan:</strong> {{ $silabus->rejection_reason }}</p>
                                <p class="mt-1 text-xs">Silakan perbaiki dan ajukan kembali untuk persetujuan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('silabus.update', $silabus) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <!-- Tahun Ajaran -->
                    <div>
                        <label for="tahun_ajaran_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tahun Ajaran <span class="text-red-500">*</span>
                        </label>
                        <select name="tahun_ajaran_id"
                                id="tahun_ajaran_id"
                                required
                                class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('tahun_ajaran_id') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                            <option value="">Pilih Tahun Ajaran</option>
                            @foreach($tahunAjaranList as $ta)
                                <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id', $silabus->tahun_ajaran_id) == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->tahun }} {{ $ta->is_active ? '(Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('tahun_ajaran_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mata Pelajaran -->
                    <div>
                        <label for="mata_pelajaran_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mata Pelajaran <span class="text-red-500">*</span>
                        </label>
                        <select name="mata_pelajaran_id"
                                id="mata_pelajaran_id"
                                required
                                class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('mata_pelajaran_id') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                            <option value="">Pilih Mata Pelajaran</option>
                            @foreach($mataPelajaran as $mapel)
                                <option value="{{ $mapel->id }}" {{ (old('mata_pelajaran_id', $silabus->mata_pelajaran_id) == $mapel->id) ? 'selected' : '' }}>
                                    {{ $mapel->nama }} ({{ $mapel->kode }})
                                </option>
                            @endforeach
                        </select>
                        @error('mata_pelajaran_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Kategori -->
                <div>
                    <label for="kategori" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori"
                            id="kategori"
                            required
                            class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('kategori') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                        <option value="">Pilih Kategori</option>
                        <option value="formatif" {{ old('kategori', $silabus->kategori) == 'formatif' ? 'selected' : '' }}>Formatif</option>
                        <option value="sumatif" {{ old('kategori', $silabus->kategori) == 'sumatif' ? 'selected' : '' }}>Sumatif</option>
                    </select>
                    @error('kategori')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror

                    <!-- Category Help Text -->
                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        <p><strong>Formatif:</strong> Penilaian untuk mengidentifikasi, menjelaskan, membandingkan, mengklasifikasikan</p>
                        <p><strong>Sumatif:</strong> Penilaian untuk menganalisis, mengevaluasi, mencipta, merancang</p>
                    </div>
                </div>

                <!-- Tujuan Pembelajaran -->
                <div>
                    <label for="tujuan_pembelajaran" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Tujuan Pembelajaran <span class="text-red-500">*</span>
                    </label>
                    <textarea name="tujuan_pembelajaran"
                              id="tujuan_pembelajaran"
                              rows="6"
                              required
                              placeholder="Masukkan tujuan pembelajaran sesuai format ABCD (Audience, Behavior, Condition, Degree)..."
                              class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('tujuan_pembelajaran') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">{{ old('tujuan_pembelajaran', $silabus->tujuan_pembelajaran) }}</textarea>
                    @error('tujuan_pembelajaran')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror

                    <!-- Character Counter -->
                    <div class="mt-1 flex justify-between text-sm text-gray-500 dark:text-gray-400">
                        <div>
                            <span id="char-count">{{ strlen(old('tujuan_pembelajaran', $silabus->tujuan_pembelajaran)) }}</span> karakter
                        </div>
                        <div class="text-right">
                            Minimum 10 karakter
                        </div>
                    </div>

                    <!-- Format Guide -->
                    <div class="mt-3 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <h4 class="text-sm font-medium text-blue-900 dark:text-blue-300 mb-2">
                            Format Tujuan Pembelajaran (ABCD):
                        </h4>
                        <ul class="text-sm text-blue-800 dark:text-blue-400 space-y-1">
                            <li><strong>A (Audience):</strong> "Setelah mengikuti pembelajaran, peserta didik..."</li>
                            <li><strong>B (Behavior):</strong> Kata kerja operasional yang terukur</li>
                            <li><strong>C (Condition):</strong> Kondisi/situasi pembelajaran</li>
                            <li><strong>D (Degree):</strong> Kriteria keberhasilan</li>
                        </ul>

                        <div class="mt-3">
                            <p class="text-sm font-medium text-blue-900 dark:text-blue-300">Contoh:</p>
                            <p class="text-sm text-blue-800 dark:text-blue-400 italic">
                                "Setelah mengikuti pembelajaran, peserta didik mampu menganalisis struktur teks eksposisi dengan tepat berdasarkan kaidah kebahasaan yang berlaku dengan akurasi minimal 80%."
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Urutan (Optional) -->
                <div>
                    <label for="urutan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Urutan (Opsional)
                    </label>
                    <input type="number"
                           name="urutan"
                           id="urutan"
                           min="0"
                           value="{{ old('urutan', $silabus->urutan) }}"
                           placeholder="0"
                           class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('urutan') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                    @error('urutan')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Nomor urutan untuk pengurutan silabus (0 = urutan terakhir)
                    </p>
                </div>

                <!-- Metadata Info -->
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Informasi Silabus</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500 dark:text-gray-400">Dibuat oleh:</span>
                            <span class="text-gray-900 dark:text-white ml-2">{{ $silabus->createdBy->name }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 dark:text-gray-400">Tanggal dibuat:</span>
                            <span class="text-gray-900 dark:text-white ml-2">{{ $silabus->created_at->format('d M Y H:i') }}</span>
                        </div>
                        @if($silabus->updated_at != $silabus->created_at)
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Terakhir diubah:</span>
                                <span class="text-gray-900 dark:text-white ml-2">{{ $silabus->updated_at->format('d M Y H:i') }}</span>
                            </div>
                        @endif
                        @if($silabus->approvedBy)
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Disetujui oleh:</span>
                                <span class="text-gray-900 dark:text-white ml-2">{{ $silabus->approvedBy->name }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('silabus.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md shadow-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Character counter
        const textarea = document.getElementById('tujuan_pembelajaran');
        const charCount = document.getElementById('char-count');

        if (textarea && charCount) {
            textarea.addEventListener('input', function() {
                charCount.textContent = this.value.length;
            });
        }

        // Auto-resize textarea
        if (textarea) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            });

            // Set initial height
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        }
    </script>
    @endpush
@endsection
