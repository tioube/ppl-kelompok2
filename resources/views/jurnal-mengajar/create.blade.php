@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Tambah Jurnal Mengajar" />

    <div class="space-y-6">
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Membuat Jurnal Mengajar Baru</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Isi data jurnal dan lakukan absensi siswa</p>
                    </div>
                </div>
                <a href="{{ route('jurnal-mengajar.index') }}"
                   class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <form action="{{ route('jurnal-mengajar.store') }}" method="POST" id="jurnalForm">
            @csrf

            <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Informasi Jurnal</h3>
                </div>

                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        <div class="lg:col-span-2">
                            <label for="guru_mapel_kelas_id" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                Kelas & Mata Pelajaran <span class="text-red-500">*</span>
                            </label>
                            <select name="guru_mapel_kelas_id" id="guru_mapel_kelas_id" required
                                    class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                <option value="">Pilih Kelas & Mata Pelajaran</option>
                                @foreach($guruMapelKelas as $gmk)
                                    <option value="{{ $gmk->id }}" {{ old('guru_mapel_kelas_id') == $gmk->id ? 'selected' : '' }}>
                                        {{ $gmk->kelas->nama }} - {{ $gmk->mataPelajaran->nama }}
                                        @if(isset($gmk->guru))
                                            ({{ $gmk->guru->name }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('guru_mapel_kelas_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="lg:col-span-2">
                            <label for="silabus_id" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                Silabus / Tujuan Pembelajaran <span class="text-red-500">*</span>
                            </label>
                            <select name="silabus_id" id="silabus_id" required disabled
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-3 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                                <option value="">Pilih Kelas & Mapel terlebih dahulu</option>
                            </select>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400" id="silabus-loading" style="display:none;">
                                <svg class="inline-block h-4 w-4 animate-spin mr-1" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Memuat silabus...
                            </p>
                            @error('silabus_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tanggal" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                Tanggal <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal" id="tanggal" required
                                   value="{{ old('tanggal', date('Y-m-d')) }}"
                                   class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            @error('tanggal')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="waktu_mulai" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                    Jam Mulai <span class="text-red-500">*</span>
                                </label>
                                <input type="time" name="waktu_mulai" id="waktu_mulai" required
                                       value="{{ old('waktu_mulai', '08:00') }}"
                                       class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                @error('waktu_mulai')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="waktu_selesai" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                    Jam Selesai <span class="text-red-500">*</span>
                                </label>
                                <input type="time" name="waktu_selesai" id="waktu_selesai" required
                                       value="{{ old('waktu_selesai', '09:30') }}"
                                       class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                @error('waktu_selesai')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="lg:col-span-2">
                            <label for="catatan" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                Catatan
                            </label>
                            <textarea name="catatan" id="catatan" rows="3"
                                      class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                      placeholder="Catatan tambahan untuk jurnal ini...">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Absensi Siswa</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Pilih kelas terlebih dahulu untuk menampilkan daftar siswa</p>
                        </div>
                        <div class="flex space-x-2" id="quick-actions" style="display:none;">
                            <button type="button" onclick="setAllStatus('hadir')"
                                    class="inline-flex items-center rounded-lg bg-green-100 px-3 py-1.5 text-sm font-medium text-green-800 hover:bg-green-200 dark:bg-green-900/30 dark:text-green-400 dark:hover:bg-green-900/50">
                                <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Semua Hadir
                            </button>
                            <button type="button" onclick="setAllStatus('alfa')"
                                    class="inline-flex items-center rounded-lg bg-red-100 px-3 py-1.5 text-sm font-medium text-red-800 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50">
                                <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Semua Alfa
                            </button>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div id="absensi-container">
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Pilih kelas dan mata pelajaran untuk menampilkan daftar siswa</p>
                        </div>
                    </div>
                    <p id="siswa-loading" class="text-center text-sm text-gray-500 dark:text-gray-400" style="display:none;">
                        <svg class="inline-block h-5 w-5 animate-spin mr-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Memuat daftar siswa...
                    </p>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('jurnal-mengajar.index') }}"
                   class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    Batal
                </a>
                <button type="submit" id="submit-btn" disabled
                        class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed dark:focus:ring-offset-gray-800">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Jurnal & Absensi
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const guruMapelKelasSelect = document.getElementById('guru_mapel_kelas_id');
            const silabusSelect = document.getElementById('silabus_id');
            const absensiContainer = document.getElementById('absensi-container');
            const quickActions = document.getElementById('quick-actions');
            const submitBtn = document.getElementById('submit-btn');
            const silabusLoading = document.getElementById('silabus-loading');
            const siswaLoading = document.getElementById('siswa-loading');

            guruMapelKelasSelect.addEventListener('change', async function() {
                const guruMapelKelasId = this.value;

                silabusSelect.innerHTML = '<option value="">Pilih Silabus</option>';
                silabusSelect.disabled = true;
                silabusSelect.classList.add('bg-gray-100', 'dark:bg-gray-700');
                silabusSelect.classList.remove('bg-white', 'dark:bg-gray-800');

                absensiContainer.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Pilih kelas dan mata pelajaran untuk menampilkan daftar siswa</p>
                    </div>
                `;
                quickActions.style.display = 'none';
                submitBtn.disabled = true;

                if (!guruMapelKelasId) {
                    return;
                }

                silabusLoading.style.display = 'block';
                siswaLoading.style.display = 'block';
                absensiContainer.innerHTML = '';

                try {
                    const [silabusResponse, siswaResponse] = await Promise.all([
                        fetch(`/api/guru-mapel-kelas/${guruMapelKelasId}/silabus`),
                        fetch(`/api/guru-mapel-kelas/${guruMapelKelasId}/siswa`)
                    ]);

                    const silabusList = await silabusResponse.json();
                    const siswaList = await siswaResponse.json();

                    silabusLoading.style.display = 'none';
                    siswaLoading.style.display = 'none';

                    if (silabusList.length > 0) {
                        silabusSelect.innerHTML = '<option value="">Pilih Silabus</option>';
                        silabusList.forEach(silabus => {
                            const option = document.createElement('option');
                            option.value = silabus.id;
                            const tujuan = silabus.tujuan_pembelajaran.length > 80
                                ? silabus.tujuan_pembelajaran.substring(0, 80) + '...'
                                : silabus.tujuan_pembelajaran;
                            option.textContent = `${tujuan} (${silabus.kategori.charAt(0).toUpperCase() + silabus.kategori.slice(1)})`;
                            silabusSelect.appendChild(option);
                        });
                        silabusSelect.disabled = false;
                        silabusSelect.classList.remove('bg-gray-100', 'dark:bg-gray-700');
                        silabusSelect.classList.add('bg-white', 'dark:bg-gray-800');
                    } else {
                        silabusSelect.innerHTML = '<option value="">Tidak ada silabus tersedia untuk mata pelajaran ini</option>';
                    }

                    renderAbsensiTable(siswaList);
                } catch (error) {
                    console.error('Error:', error);
                    silabusLoading.style.display = 'none';
                    siswaLoading.style.display = 'none';
                    absensiContainer.innerHTML = `
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <svg class="h-12 w-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="mt-2 text-sm text-red-500">Gagal memuat data. Silakan coba lagi.</p>
                        </div>
                    `;
                }
            });

            function renderAbsensiTable(siswaList) {
                if (siswaList.length === 0) {
                    absensiContainer.innerHTML = `
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <svg class="h-12 w-12 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Tidak ada siswa di kelas ini</p>
                        </div>
                    `;
                    quickActions.style.display = 'none';
                    submitBtn.disabled = true;
                    return;
                }

                let html = `
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800/50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">No</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">NISN</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Nama Siswa</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-transparent">
                `;

                siswaList.forEach((siswa, index) => {
                    html += `
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                            <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-900 dark:text-white">${index + 1}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-500 dark:text-gray-400">${siswa.nisn || '-'}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">${siswa.name}</td>
                            <td class="whitespace-nowrap px-4 py-3">
                                <input type="hidden" name="absensi[${index}][siswa_id]" value="${siswa.id}">
                                <select name="absensi[${index}][status]"
                                        class="absensi-status rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                    <option value="hadir" selected>Hadir</option>
                                    <option value="sakit">Sakit</option>
                                    <option value="izin">Izin</option>
                                    <option value="alfa">Alfa</option>
                                </select>
                            </td>
                            <td class="px-4 py-3">
                                <input type="text" name="absensi[${index}][keterangan]"
                                       class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                       placeholder="Keterangan (opsional)">
                            </td>
                        </tr>
                    `;
                });

                html += `
                            </tbody>
                        </table>
                    </div>
                `;

                absensiContainer.innerHTML = html;
                quickActions.style.display = 'flex';
                submitBtn.disabled = false;
            }
        });

        function setAllStatus(status) {
            document.querySelectorAll('.absensi-status').forEach(select => {
                select.value = status;
            });
        }
    </script>
@endsection

