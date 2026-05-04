@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Edit Jurnal Mengajar" />

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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Edit Jurnal Mengajar</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $jurnalMengajar->guruMapelKelas->kelas->nama }} - {{ $jurnalMengajar->guruMapelKelas->mataPelajaran->nama }}
                        </p>
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

        <form action="{{ route('jurnal-mengajar.update', $jurnalMengajar) }}" method="POST">
            @csrf
            @method('PUT')

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
                                @foreach($guruMapelKelas as $gmk)
                                    <option value="{{ $gmk->id }}" {{ old('guru_mapel_kelas_id', $jurnalMengajar->guru_mapel_kelas_id) == $gmk->id ? 'selected' : '' }}>
                                        {{ $gmk->kelas->nama }} - {{ $gmk->mataPelajaran->nama }}
                                        @if(isset($gmk->guru))
                                            ({{ $gmk->guru->name }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="lg:col-span-2">
                            <label for="silabus_id" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                Silabus / Tujuan Pembelajaran <span class="text-red-500">*</span>
                            </label>
                            <select name="silabus_id" id="silabus_id" required
                                    class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                @foreach($silabusList as $silabus)
                                    <option value="{{ $silabus->id }}" {{ old('silabus_id', $jurnalMengajar->silabus_id) == $silabus->id ? 'selected' : '' }}>
                                        {{ Str::limit($silabus->tujuan_pembelajaran, 80) }} ({{ ucfirst($silabus->kategori) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="tanggal" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                Tanggal <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal" id="tanggal" required
                                   value="{{ old('tanggal', $jurnalMengajar->tanggal->format('Y-m-d')) }}"
                                   class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="waktu_mulai" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                    Jam Mulai <span class="text-red-500">*</span>
                                </label>
                                <input type="time" name="waktu_mulai" id="waktu_mulai" required
                                       value="{{ old('waktu_mulai', \Carbon\Carbon::parse($jurnalMengajar->waktu_mulai)->format('H:i')) }}"
                                       class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            </div>

                            <div>
                                <label for="waktu_selesai" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                    Jam Selesai <span class="text-red-500">*</span>
                                </label>
                                <input type="time" name="waktu_selesai" id="waktu_selesai" required
                                       value="{{ old('waktu_selesai', \Carbon\Carbon::parse($jurnalMengajar->waktu_selesai)->format('H:i')) }}"
                                       class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            </div>
                        </div>

                        <div class="lg:col-span-2">
                            <label for="catatan" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                Catatan
                            </label>
                            <textarea name="catatan" id="catatan" rows="3"
                                      class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                      placeholder="Catatan tambahan untuk jurnal ini...">{{ old('catatan', $jurnalMengajar->catatan) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Absensi Siswa</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Update status kehadiran siswa</p>
                        </div>
                        <div class="flex space-x-2">
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
                                @foreach($siswaList as $index => $siswa)
                                    @php
                                        $absensi = $existingAbsensi->get($siswa->id);
                                    @endphp
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                        <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $index + 1 }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $siswa->nisn ?? '-' }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ $siswa->name }}</td>
                                        <td class="whitespace-nowrap px-4 py-3">
                                            <input type="hidden" name="absensi[{{ $index }}][siswa_id]" value="{{ $siswa->id }}">
                                            <select name="absensi[{{ $index }}][status]"
                                                    class="absensi-status rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                                <option value="hadir" {{ ($absensi?->status ?? 'hadir') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                                <option value="sakit" {{ ($absensi?->status ?? '') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                                <option value="izin" {{ ($absensi?->status ?? '') == 'izin' ? 'selected' : '' }}>Izin</option>
                                                <option value="alfa" {{ ($absensi?->status ?? '') == 'alfa' ? 'selected' : '' }}>Alfa</option>
                                            </select>
                                        </td>
                                        <td class="px-4 py-3">
                                            <input type="text" name="absensi[{{ $index }}][keterangan]"
                                                   value="{{ $absensi?->keterangan ?? '' }}"
                                                   class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                                   placeholder="Keterangan (opsional)">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('jurnal-mengajar.index') }}"
                   class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Jurnal & Absensi
                </button>
            </div>
        </form>
    </div>

    <script>
        function setAllStatus(status) {
            document.querySelectorAll('.absensi-status').forEach(select => {
                select.value = status;
            });
        }
    </script>
@endsection

