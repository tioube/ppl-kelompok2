@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Hasil Kenaikan Kelas" />

    <div class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Hasil Proses Kenaikan Kelas</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $tahunAjaranLama->tahun }} → {{ $tahunAjaranBaru->tahun }} |
                        {{ $kelasLama->nama }} → {{ $kelasBaru->nama }}
                    </p>
                </div>
                <a href="{{ route('kenaikan-kelas.index') }}" class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">
                    ← Kembali ke Kenaikan Kelas
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="rounded-lg bg-green-50 dark:bg-green-900/20 p-4 text-center">
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $result['success'] }}</p>
                    <p class="text-sm text-green-700 dark:text-green-300">Berhasil Naik Kelas</p>
                </div>
                <div class="rounded-lg bg-yellow-50 dark:bg-yellow-900/20 p-4 text-center">
                    <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $result['skipped'] }}</p>
                    <p class="text-sm text-yellow-700 dark:text-yellow-300">Dilewati (Sudah Ada)</p>
                </div>
                <div class="rounded-lg bg-blue-50 dark:bg-blue-900/20 p-4 text-center">
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $result['excluded'] }}</p>
                    <p class="text-sm text-blue-700 dark:text-blue-300">Dikecualikan</p>
                </div>
                <div class="rounded-lg bg-red-50 dark:bg-red-900/20 p-4 text-center">
                    <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $result['failed'] }}</p>
                    <p class="text-sm text-red-700 dark:text-red-300">Gagal</p>
                </div>
            </div>

            @if(count($result['errors']) > 0)
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
                <h4 class="text-sm font-semibold text-red-800 dark:text-red-200 mb-2">Error:</h4>
                <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-300">
                    @foreach($result['errors'] as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if($result['success'] > 0 && isset($processedSiswa) && count($processedSiswa) > 0)
            <div>
                <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-4">Siswa yang Berhasil Naik Kelas</h4>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">No</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Nama Siswa</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">NISN</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Kelas Baru</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Jurusan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($processedSiswa as $index => $sta)
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <span class="text-sm text-gray-900 dark:text-white">{{ $sta->siswa->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $sta->siswa->nisn ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $sta->kelas->nama ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $sta->jurusan->nama ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('siswa.index', ['tahun_ajaran_id' => $tahunAjaranBaru->id]) }}" class="bg-blue-600 hover:bg-blue-700 rounded-lg px-6 py-2.5 text-sm font-medium text-white transition">
                    Lihat Siswa di Tahun Ajaran Baru
                </a>
                <a href="{{ route('kenaikan-kelas.index') }}" class="rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                    Proses Kelas Lain
                </a>
            </div>
        </div>
    </div>
@endsection

