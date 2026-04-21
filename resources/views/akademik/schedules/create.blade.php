@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Tambah Jadwal Manual" />

    <div class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Tambah Jadwal ke Slot Kosong</h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Pilih guru dan mata pelajaran untuk mengisi slot waktu yang kosong
                </p>
            </div>

            <div class="mb-6 rounded-lg bg-blue-50 p-4 dark:bg-blue-900/20">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div>
                        <p class="text-xs font-medium text-blue-700 dark:text-blue-400">Kelas</p>
                        <p class="mt-1 text-lg font-bold text-blue-900 dark:text-blue-300">{{ $kelas->nama }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-blue-700 dark:text-blue-400">Hari</p>
                        <p class="mt-1 text-lg font-bold text-blue-900 dark:text-blue-300">{{ ucfirst($timeSlot->day) }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-blue-700 dark:text-blue-400">Waktu</p>
                        <p class="mt-1 text-lg font-bold text-blue-900 dark:text-blue-300">{{ $timeSlot->start_time }} - {{ $timeSlot->end_time }}</p>
                    </div>
                </div>
            </div>

            @if(session('error'))
                <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-red-900/20 dark:text-red-400">
                    {{ session('error') }}
                </div>
            @endif

            @if($assignments->isEmpty())
                <div class="rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 p-8 text-center dark:border-gray-700 dark:bg-gray-800/50">
                    <i class="fas fa-exclamation-triangle mb-3 text-4xl text-yellow-500"></i>
                    <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Tidak Ada Penugasan Guru</h3>
                    <p class="mb-4 text-gray-600 dark:text-gray-400">
                        Belum ada guru yang ditugaskan untuk kelas <strong>{{ $kelas->nama }}</strong>.
                    </p>
                    <a href="{{ route('guru-mapel-kelas.index') }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 transition">
                        <i class="fas fa-plus"></i>
                        Tambah Penugasan Guru
                    </a>
                </div>
            @else
                <form action="{{ route('schedules.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                    <input type="hidden" name="time_slot_id" value="{{ $timeSlot->id }}">

                    <div class="mb-6">
                        <label for="guru_mapel_kelas_id" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Pilih Guru & Mata Pelajaran <span class="text-red-500">*</span>
                        </label>
                        <select name="guru_mapel_kelas_id" id="guru_mapel_kelas_id" required
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-blue-500">
                            <option value="">-- Pilih Guru & Mata Pelajaran --</option>
                            @foreach($assignments as $assignment)
                                <option value="{{ $assignment->id }}">
                                    {{ $assignment->mataPelajaran->nama }} - {{ $assignment->guru->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('guru_mapel_kelas_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            <i class="fas fa-info-circle mr-1"></i>
                            Hanya guru yang sudah ditugaskan untuk kelas ini yang muncul di daftar
                        </p>
                    </div>

                    <div class="flex items-center justify-between gap-3 border-t border-gray-200 pt-6 dark:border-gray-700">
                        <a href="{{ route('schedules.index', ['kelas_id' => $kelas->id]) }}"
                            class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <i class="fas fa-save"></i>
                            Simpan Jadwal
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection

