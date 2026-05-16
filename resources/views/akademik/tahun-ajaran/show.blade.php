@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Detail Tahun Ajaran" />

    <div class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Tahun Ajaran</h3>
                <a href="{{ route('tahun-ajaran.index') }}" class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">
                    ← Kembali
                </a>
            </div>

            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Tahun Ajaran</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $tahunAjaran->tahun }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                        <p class="mt-1">
                            @if($tahunAjaran->is_active)
                                <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                    Tidak Aktif
                                </span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Dibuat</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $tahunAjaran->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Terakhir Diubah</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $tahunAjaran->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-3">
                <a href="{{ route('tahun-ajaran.edit', $tahunAjaran) }}"
                    class="bg-blue-600 hover:bg-blue-700 rounded-lg px-5 py-2.5 text-sm font-medium text-white transition">
                    Edit
                </a>
                <a href="{{ route('tahun-ajaran.index') }}"
                    class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                    Kembali
                </a>
            </div>
        </div>
    </div>
@endsection

