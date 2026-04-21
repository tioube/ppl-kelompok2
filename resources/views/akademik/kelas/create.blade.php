@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Tambah Kelas" />

    <div class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <form action="{{ route('kelas.store') }}" method="POST">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label for="nama" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Nama Kelas <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                            placeholder="Contoh: X, XI IPA 1, XII Bahasa 1"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder-gray-400 @error('nama') border-red-500 @enderror">
                        @error('nama')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jurusan_id" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Jurusan
                        </label>
                        <select name="jurusan_id" id="jurusan_id"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('jurusan_id') border-red-500 @enderror">
                            <option value="">Pilih Jurusan (Opsional)</option>
                            @foreach($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}" {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                                    {{ $jurusan->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('jurusan_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-3">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 rounded-lg px-5 py-2.5 text-sm font-medium text-white dark:bg-blue-600 dark:hover:bg-blue-700 transition">
                        Simpan
                    </button>
                    <a href="{{ route('kelas.index') }}"
                        class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

