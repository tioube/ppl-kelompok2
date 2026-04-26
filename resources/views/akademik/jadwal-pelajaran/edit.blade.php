@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Edit Jadwal Pelajaran" />

    <div class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <form action="{{ route('jadwal-pelajaran.update', $jadwalPelajaran) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label for="tahun_ajaran_id" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Tahun Ajaran <span class="text-red-500">*</span>
                        </label>
                        <select name="tahun_ajaran_id" id="tahun_ajaran_id"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('tahun_ajaran_id') border-red-500 @enderror">
                            <option value="">Pilih Tahun Ajaran</option>
                            @foreach($tahunAjarans as $tahun)
                                <option value="{{ $tahun->id }}" {{ old('tahun_ajaran_id', $jadwalPelajaran->tahun_ajaran_id) == $tahun->id ? 'selected' : '' }}>
                                    {{ $tahun->tahun }}
                                </option>
                            @endforeach
                        </select>
                        @error('tahun_ajaran_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="kelas_id" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Kelas <span class="text-red-500">*</span>
                        </label>
                        <select name="kelas_id" id="kelas_id"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('kelas_id') border-red-500 @enderror">
                            <option value="">Pilih Kelas</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ old('kelas_id', $jadwalPelajaran->kelas_id) == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="guru_id" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Guru
                        </label>
                        <select name="guru_id" id="guru_id"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('guru_id') border-red-500 @enderror"
                            onchange="autoFillMataPelajaran(this)">
                            <option value="">Pilih Guru</option>
                            @foreach($gurus as $guru)
                                <option value="{{ $guru->id }}"
                                    data-mapel="{{ $guru->mata_pelajaran_id }}"
                                    {{ old('guru_id', $jadwalPelajaran->guru_id) == $guru->id ? 'selected' : '' }}>
                                    {{ $guru->name }}
                                    @if($guru->mataPelajaran) ({{ $guru->mataPelajaran->nama }}) @endif
                                </option>
                            @endforeach
                        </select>
                        @error('guru_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Memilih guru akan otomatis mengisi Mata Pelajaran</p>
                    </div>

                    <div>
                        <label for="mata_pelajaran_id" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Mata Pelajaran <span class="text-red-500">*</span>
                        </label>
                        <select name="mata_pelajaran_id" id="mata_pelajaran_id"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('mata_pelajaran_id') border-red-500 @enderror">
                            <option value="">Pilih Mata Pelajaran</option>
                            @foreach($mataPelajarans as $mapel)
                                <option value="{{ $mapel->id }}" {{ old('mata_pelajaran_id', $jadwalPelajaran->mata_pelajaran_id) == $mapel->id ? 'selected' : '' }}>
                                    {{ $mapel->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('mata_pelajaran_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="time_slot_id" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Slot Waktu <span class="text-red-500">*</span>
                        </label>
                        <select name="time_slot_id" id="time_slot_id"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('time_slot_id') border-red-500 @enderror">
                            <option value="">Pilih Slot Waktu Pengajaran</option>
                            @foreach($teachingSlots->groupBy('day') as $day => $slots)
                                <optgroup label="{{ ucfirst($day) }}">
                                    @foreach($slots as $slot)
                                        <option value="{{ $slot->id }}" {{ old('time_slot_id', $selectedTimeSlotId) == $slot->id ? 'selected' : '' }}>
                                            {{ substr($slot->start_time, 0, 5) }} - {{ substr($slot->end_time, 0, 5) }} (Slot {{ $slot->slot_index }})
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('time_slot_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-3">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 rounded-lg px-5 py-2.5 text-sm font-medium text-white dark:bg-blue-600 dark:hover:bg-blue-700 transition">
                        Update
                    </button>
                    <a href="{{ route('jadwal-pelajaran.index') }}"
                        class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function autoFillMataPelajaran(guruSelect) {
            const selectedOption = guruSelect.options[guruSelect.selectedIndex];
            const mapelId = selectedOption.getAttribute('data-mapel');
            const mapelSelect = document.getElementById('mata_pelajaran_id');
            if (mapelId) {
                mapelSelect.value = mapelId;
            }
        }
    </script>
@endsection

