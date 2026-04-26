@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Tambah Jadwal" />

    <div class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">
                Tambah Jadwal: {{ $kelas->nama }}
            </h2>

            @if(session('error'))
                <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-red-900/20 dark:text-red-400">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('schedules.store') }}" method="POST">
                @csrf
                <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                <input type="hidden" name="time_slot_id" value="{{ $timeSlot->id }}">

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Waktu <span class="text-red-500">*</span>
                        </label>
                        <div class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2.5 text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                            {{ ucfirst($timeSlot->day) }} - {{ $timeSlot->start_time }} - {{ $timeSlot->end_time }}
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Waktu ditentukan dari slot kosong yang dipilih di tabel jadwal.</p>
                    </div>

                    <div>
                        <label for="mata_pelajaran_id" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Mata Pelajaran <span class="text-red-500">*</span>
                        </label>
                        <select name="mata_pelajaran_id" id="mata_pelajaran_id" required
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('mata_pelajaran_id') border-red-500 @enderror">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($mataPelajarans as $mapel)
                                <option value="{{ $mapel->id }}" {{ old('mata_pelajaran_id') == $mapel->id ? 'selected' : '' }}>
                                    {{ $mapel->nama }} ({{ $mapel->kode }})
                                </option>
                            @endforeach
                        </select>
                        @error('mata_pelajaran_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="guru_id" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Guru <span class="text-red-500">*</span>
                        </label>
                        <select name="guru_id" id="guru_id" required
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('guru_id') border-red-500 @enderror">
                            <option value="">-- Pilih Guru --</option>
                            @foreach($gurus as $guru)
                                <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
                                    {{ $guru->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('guru_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Guru dan mata pelajaran harus sesuai penugasan kelas.</p>
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-3">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 rounded-lg px-5 py-2.5 text-sm font-medium text-white transition">
                        Simpan Jadwal
                    </button>
                    <a href="{{ route('schedules.index', ['kelas_id' => $kelas->id]) }}"
                        class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

