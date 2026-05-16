@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Edit Jadwal" />

    <div class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">
                Edit Jadwal: {{ $schedule->kelas->nama }}
            </h2>

            <form action="{{ route('schedules.update', $schedule->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="kelas_id" value="{{ $schedule->kelas_id }}">

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div>
                        <label for="time_slot_id" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Waktu <span class="text-red-500">*</span>
                        </label>
                        <select name="time_slot_id" id="time_slot_id"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('time_slot_id') border-red-500 @enderror">
                            @foreach($timeSlots->groupBy('day') as $day => $slots)
                                <optgroup label="{{ ucfirst($day) }}">
                                    @foreach($slots as $slot)
                                        <option value="{{ $slot->id }}"
                                            {{ old('time_slot_id', $schedule->time_slot_id) == $slot->id ? 'selected' : '' }}>
                                            {{ $slot->start_time }} - {{ $slot->end_time }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('time_slot_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="mata_pelajaran_id" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Mata Pelajaran
                        </label>
                        <select name="mata_pelajaran_id" id="mata_pelajaran_id"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            <option value="">-- Kosongkan --</option>
                            @foreach($mataPelajarans as $mapel)
                                <option value="{{ $mapel->id }}"
                                    {{ old('mata_pelajaran_id', $schedule->mata_pelajaran_id) == $mapel->id ? 'selected' : '' }}>
                                    {{ $mapel->nama }} ({{ $mapel->kode }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="guru_id" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Guru
                        </label>
                        <select name="guru_id" id="guru_id"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            <option value="">-- Kosongkan --</option>
                            @foreach($gurus as $guru)
                                <option value="{{ $guru->id }}"
                                    {{ old('guru_id', $schedule->guru_id) == $guru->id ? 'selected' : '' }}>
                                    {{ $guru->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @if(session('error'))
                    <div class="mt-4 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-red-900/20 dark:text-red-400">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="mt-6 flex items-center gap-3">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 rounded-lg px-5 py-2.5 text-sm font-medium text-white dark:bg-blue-600 dark:hover:bg-blue-700 transition">
                        Update Jadwal
                    </button>
                    <a href="{{ route('schedules.index', ['kelas_id' => $schedule->kelas_id]) }}"
                        class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

