@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Tambah Mata Pelajaran" />

    <div class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <form action="{{ route('mata-pelajaran.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div>
                        <label for="kode" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Kode <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="kode" id="kode" value="{{ old('kode') }}"
                            placeholder="Contoh: MTK, BIND, FIS"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 font-mono text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('kode') border-red-500 @enderror">
                        @error('kode')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nama" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Nama Mata Pelajaran <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                            placeholder="Contoh: Matematika"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('nama') border-red-500 @enderror">
                        @error('nama')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="kategori" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="kategori" id="kategori"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('kategori') border-red-500 @enderror">
                            <option value="">Pilih Kategori</option>
                            <option value="Wajib" {{ old('kategori') == 'Wajib' ? 'selected' : '' }}>Wajib</option>
                            <option value="Peminatan" {{ old('kategori') == 'Peminatan' ? 'selected' : '' }}>Peminatan</option>
                            <option value="Lintas Minat" {{ old('kategori') == 'Lintas Minat' ? 'selected' : '' }}>Lintas Minat</option>
                        </select>
                        @error('kategori')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jam_pelajaran" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Jam Pelajaran / Minggu <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="jam_pelajaran" id="jam_pelajaran" value="{{ old('jam_pelajaran', 2) }}"
                            min="1" max="20"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('jam_pelajaran') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Maksimal slot jadwal per minggu per kelas (1–20)</p>
                        @error('jam_pelajaran')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="preferred_block" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Blok Berurutan <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="preferred_block" id="preferred_block" value="{{ old('preferred_block', 1) }}"
                            min="1" max="3"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('preferred_block') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Jumlah slot berurutan yang diinginkan (1–3)</p>
                        @error('preferred_block')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="max_per_day" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Maksimal Per Hari <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="max_per_day" id="max_per_day" value="{{ old('max_per_day', 2) }}"
                            min="1" max="5"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('max_per_day') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Maksimal slot per hari (1–5)</p>
                        @error('max_per_day')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="deskripsi" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Deskripsi
                        </label>
                        <textarea name="deskripsi" id="deskripsi" rows="3"
                            placeholder="Deskripsi singkat mata pelajaran..."
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-3">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 rounded-lg px-5 py-2.5 text-sm font-medium text-white dark:bg-blue-600 dark:hover:bg-blue-700 transition">
                        Simpan
                    </button>
                    <a href="{{ route('mata-pelajaran.index') }}"
                        class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

