@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Hasil Kelulusan Massal" />

    <div class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Hasil Proses Kelulusan</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Tahun Ajaran: <span class="font-medium">{{ $tahunAjaran->tahun }}</span> |
                        Kelas: <span class="font-medium">{{ $kelas->nama }}</span>
                    </p>
                </div>
                <a href="{{ route('kenaikan-kelas.index') }}" class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400">
                    ← Kembali ke Kenaikan Kelas
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="rounded-lg bg-purple-50 dark:bg-purple-900/20 p-4 text-center">
                    <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $result['success'] }}</p>
                    <p class="text-sm text-purple-700 dark:text-purple-300">Berhasil Diluluskan</p>
                </div>
                <div class="rounded-lg bg-orange-50 dark:bg-orange-900/20 p-4 text-center">
                    <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">{{ $result['tinggal_kelas'] ?? 0 }}</p>
                    <p class="text-sm text-orange-700 dark:text-orange-300">Tinggal Kelas</p>
                </div>
                <div class="rounded-lg bg-gray-50 dark:bg-gray-900/20 p-4 text-center">
                    <p class="text-3xl font-bold text-gray-600 dark:text-gray-400">{{ $result['excluded'] ?? 0 }}</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300">Tidak Diproses</p>
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

            @if($result['success'] > 0 && isset($graduatedSiswa) && count($graduatedSiswa) > 0)
            <div class="mb-6">
                <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-4">Siswa yang Berhasil Diluluskan</h4>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">No</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Nama Siswa</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">NISN</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Kelas</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($graduatedSiswa as $index => $sta)
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-purple-100 dark:bg-purple-900/30">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                            </svg>
                                        </div>
                                        <span class="text-sm text-gray-900 dark:text-white">{{ $sta->siswa->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $sta->siswa->nisn ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $sta->kelas->nama ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center rounded-full bg-purple-100 px-2.5 py-0.5 text-xs font-medium text-purple-800 dark:bg-purple-900/30 dark:text-purple-300">
                                        Lulus
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            @if(isset($tinggalKelasSiswa) && count($tinggalKelasSiswa) > 0)
            <div class="mb-6">
                <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-4">Siswa Tinggal Kelas</h4>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">No</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Nama Siswa</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">NISN</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Kelas</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tinggalKelasSiswa as $index => $sta)
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-orange-100 dark:bg-orange-900/30">
                                            <span class="text-xs font-medium text-orange-800 dark:text-orange-400">{{ $sta->siswa->initials() }}</span>
                                        </div>
                                        <span class="text-sm text-gray-900 dark:text-white">{{ $sta->siswa->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $sta->siswa->nisn ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $sta->kelas->nama ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center rounded-full bg-orange-100 px-2.5 py-0.5 text-xs font-medium text-orange-800 dark:bg-orange-900/30 dark:text-orange-300">
                                        Tinggal Kelas
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('siswa.index', ['tahun_ajaran_id' => $tahunAjaran->id, 'status' => 'lulus']) }}" class="bg-purple-600 hover:bg-purple-700 rounded-lg px-6 py-2.5 text-sm font-medium text-white transition">
                    Lihat Daftar Alumni
                </a>
                <a href="{{ route('kenaikan-kelas.index') }}" class="rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                    Proses Kelas Lain
                </a>
            </div>
        </div>
    </div>
@endsection

