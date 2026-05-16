@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Kenaikan Kelas Massal" />

    <div class="space-y-6">
        @session('success')
            <x-ui.alert variant="success">
                {{ $value }}
            </x-ui.alert>
        @endsession

        @session('error')
            <x-ui.alert variant="danger">
                {{ $value }}
            </x-ui.alert>
        @endsession

        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pilih Sumber Data</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Pilih tahun ajaran dan kelas sumber untuk melihat daftar siswa yang akan dinaikkelaskan.</p>

            <form action="{{ route('kenaikan-kelas.preview') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Tahun Ajaran Lama <span class="text-red-500">*</span>
                        </label>
                        <select name="tahun_ajaran_lama_id" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            @foreach($tahunAjaranList as $ta)
                                <option value="{{ $ta->id }}">{{ $ta->tahun }} {{ $ta->is_active ? '(Aktif)' : '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Kelas Lama <span class="text-red-500">*</span>
                        </label>
                        <select name="kelas_lama_id" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 rounded-lg px-6 py-2.5 text-sm font-medium text-white transition">
                        Lihat Preview
                    </button>
                </div>
            </form>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Kelulusan Massal (Kelas XII)</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Untuk siswa kelas akhir (XII), gunakan fitur ini untuk meluluskan atau menandai tinggal kelas secara massal.</p>

            <form action="{{ route('kenaikan-kelas.preview-luluskan') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Tahun Ajaran <span class="text-red-500">*</span>
                        </label>
                        <select name="tahun_ajaran_id" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            @foreach($tahunAjaranList as $ta)
                                <option value="{{ $ta->id }}">{{ $ta->tahun }} {{ $ta->is_active ? '(Aktif)' : '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Kelas XII <span class="text-red-500">*</span>
                        </label>
                        <select name="kelas_id" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelasList as $kelas)
                                @if(str_starts_with($kelas->nama, 'XII') || str_starts_with($kelas->nama, '12'))
                                <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 rounded-lg px-6 py-2.5 text-sm font-medium text-white transition">
                        Lihat Preview Kelulusan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

