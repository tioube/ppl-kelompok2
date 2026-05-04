@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Preview Kenaikan Kelas" />

    <div class="space-y-6">
        @session('error')
            <x-ui.alert variant="danger">
                {{ $value }}
            </x-ui.alert>
        @endsession

        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Preview Kenaikan Kelas</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Dari: <span class="font-medium">{{ $tahunAjaranLama->tahun }}</span> -
                        Kelas: <span class="font-medium">{{ $kelasLama->nama }}</span> |
                        Total: <span class="font-medium">{{ $siswaList->count() }} siswa</span>
                    </p>
                </div>
                <a href="{{ route('kenaikan-kelas.index') }}" class="text-sm text-blue-600 hover:text-blue-700">
                    ← Kembali
                </a>
            </div>

            @if($siswaList->count() > 0)
            <form action="{{ route('kenaikan-kelas.process') }}" method="POST">
                @csrf
                <input type="hidden" name="tahun_ajaran_lama_id" value="{{ $tahunAjaranLamaId }}">
                <input type="hidden" name="kelas_lama_id" value="{{ $kelasLamaId }}">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Tahun Ajaran Baru <span class="text-red-500">*</span>
                        </label>
                        <select name="tahun_ajaran_baru_id" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            @foreach($tahunAjaranList as $ta)
                                @if($ta->id != $tahunAjaranLamaId)
                                <option value="{{ $ta->id }}">{{ $ta->tahun }} {{ $ta->is_active ? '(Aktif)' : '' }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Kelas Baru <span class="text-red-500">*</span>
                        </label>
                        <select name="kelas_baru_id" required class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Jurusan Baru (Opsional)
                        </label>
                        <select name="jurusan_baru_id" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="">-- Tetap Jurusan Lama --</option>
                            @foreach($jurusanList as $jurusan)
                                <option value="{{ $jurusan->id }}">{{ $jurusan->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="px-4 py-3 text-left">
                                    <input type="checkbox" id="selectAll" checked class="rounded border-gray-300">
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Siswa</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">NISN</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Kelas Lama</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Jurusan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswaList as $sta)
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="px-4 py-3">
                                    <input type="checkbox" name="siswa_ids[]" value="{{ $sta->user_id }}" checked class="siswa-checkbox rounded border-gray-300">
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30">
                                            <span class="text-xs font-medium text-blue-800 dark:text-blue-400">{{ $sta->siswa->initials() }}</span>
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

                <div class="mt-6 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                        <strong>Catatan:</strong> Siswa yang <strong>dicentang</strong> akan dinaikkelaskan ke kelas baru.
                        Hapus centang untuk siswa yang <strong>TIDAK</strong> ingin dinaikkelaskan (akan dilewati).
                    </p>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('kenaikan-kelas.index') }}" class="rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                        Batal
                    </a>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 rounded-lg px-6 py-2.5 text-sm font-medium text-white transition" onclick="return confirm('Apakah Anda yakin ingin menaikkelaskan siswa yang dipilih?')">
                        Proses Kenaikan Kelas
                    </button>
                </div>
            </form>
            @else
            <div class="text-center py-10">
                <p class="text-gray-500 dark:text-gray-400">Tidak ada siswa aktif di kelas dan tahun ajaran yang dipilih.</p>
                <a href="{{ route('kenaikan-kelas.index') }}" class="mt-4 inline-block text-blue-600 hover:text-blue-700">
                    ← Kembali
                </a>
            </div>
            @endif
        </div>
    </div>

    <script>
        document.getElementById('selectAll')?.addEventListener('change', function() {
            document.querySelectorAll('.siswa-checkbox').forEach(cb => cb.checked = this.checked);
        });
    </script>
@endsection

