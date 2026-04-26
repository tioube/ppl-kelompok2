@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Tambah Time Slot" />

    <div class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <form action="{{ route('time-slots.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label for="day" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Hari <span class="text-red-500">*</span></label>
                        <select name="day" id="day"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('day') border-red-500 @enderror">
                            <option value="">Pilih Hari</option>
                            @foreach($days as $day)
                                <option value="{{ $day }}" {{ old('day') === $day ? 'selected' : '' }}>{{ ucfirst($day) }}</option>
                            @endforeach
                        </select>
                        @error('day')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="slot_index" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Slot Index <span class="text-red-500">*</span></label>
                        <input type="number" name="slot_index" id="slot_index" min="1" value="{{ old('slot_index') }}"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('slot_index') border-red-500 @enderror">
                        @error('slot_index')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="type" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Tipe <span class="text-red-500">*</span></label>
                        <select name="type" id="type"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('type') border-red-500 @enderror">
                            <option value="">Pilih Tipe</option>
                            @foreach($types as $type)
                                <option value="{{ $type }}" {{ old('type') === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="start_time" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Jam Mulai <span class="text-red-500">*</span></label>
                        <input type="time" name="start_time" id="start_time" value="{{ old('start_time') }}"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('start_time') border-red-500 @enderror">
                        @error('start_time')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_time" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Jam Selesai <span class="text-red-500">*</span></label>
                        <input type="time" name="end_time" id="end_time" value="{{ old('end_time') }}"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('end_time') border-red-500 @enderror">
                        @error('end_time')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-3">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 rounded-lg px-5 py-2.5 text-sm font-medium text-white transition">
                        Simpan
                    </button>
                    <a href="{{ route('time-slots.index') }}"
                        class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
