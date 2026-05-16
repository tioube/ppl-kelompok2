@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Edit Tahun Ajaran" />

    <div class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <form action="{{ route('tahun-ajaran.update', $tahunAjaran) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label for="tahun" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Tahun Ajaran <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="tahun" id="tahun" value="{{ old('tahun', $tahunAjaran->tahun) }}"
                            placeholder="Contoh: 2024-2025"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder-gray-400 @error('tahun') border-red-500 @enderror">
                        @error('tahun')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                            {{ old('is_active', $tahunAjaran->is_active) ? 'checked' : '' }}
                            class="h-4 w-4 rounded border-gray-300 bg-white text-primary focus:ring-2 focus:ring-primary dark:border-gray-700 dark:bg-gray-800">
                        <label for="is_active" class="ml-2 text-sm font-medium text-gray-900 dark:text-white">
                            Aktif
                        </label>
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-3">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 rounded-lg px-5 py-2.5 text-sm font-medium text-white dark:bg-blue-600 dark:hover:bg-blue-700 transition">
                        Update
                    </button>
                    <a href="{{ route('tahun-ajaran.index') }}"
                        class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

