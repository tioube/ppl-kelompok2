@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Preview Kelulusan" />

    <div class="space-y-6">
        @session('error')
            <x-ui.alert variant="danger">
                {{ $value }}
            </x-ui.alert>
        @endsession

        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Preview Kelulusan Siswa</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Tahun Ajaran: <span class="font-medium">{{ $tahunAjaran->tahun }}</span> -
                        Kelas: <span class="font-medium">{{ $kelas->nama }}</span> |
                        Total: <span class="font-medium">{{ $siswaList->count() }} siswa</span>
                    </p>
                </div>
                <a href="{{ route('kenaikan-kelas.index') }}" class="text-sm text-blue-600 hover:text-blue-700">
                    ← Kembali
                </a>
            </div>

            @if($siswaList->count() > 0)
            <form action="{{ route('kenaikan-kelas.luluskan') }}" method="POST">
                @csrf
                <input type="hidden" name="tahun_ajaran_id" value="{{ $tahunAjaranId }}">
                <input type="hidden" name="kelas_id" value="{{ $kelasId }}">

                <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <p class="text-sm text-blue-800 dark:text-blue-200">
                        <strong>Petunjuk:</strong> Pilih status untuk setiap siswa menggunakan radio button di bawah.
                    </p>
                    <ul class="mt-2 text-sm text-blue-700 dark:text-blue-300 list-disc list-inside">
                        <li><span class="font-medium text-green-600 dark:text-green-400">Lulus</span> - Siswa dinyatakan lulus dan menyelesaikan pendidikan</li>
                        <li><span class="font-medium text-red-600 dark:text-red-400">Tinggal Kelas</span> - Siswa harus mengulang di kelas yang sama tahun depan</li>
                        <li><span class="font-medium text-gray-600 dark:text-gray-400">Tidak Diproses</span> - Status siswa tidak berubah (tetap aktif)</li>
                    </ul>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">No</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Siswa</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">NISN</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-500 dark:text-gray-400">Jurusan</th>
                                <th class="px-4 py-3 text-center text-sm font-medium text-gray-500 dark:text-gray-400">Status Kelulusan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswaList as $index => $sta)
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-purple-100 dark:bg-purple-900/30">
                                            <span class="text-xs font-medium text-purple-800 dark:text-purple-400">{{ $sta->siswa->initials() }}</span>
                                        </div>
                                        <span class="text-sm text-gray-900 dark:text-white">{{ $sta->siswa->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $sta->siswa->nisn ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $sta->jurusan->nama ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <select name="siswa_status[{{ $sta->user_id }}]" class="rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                        <option value="lulus" selected>Lulus</option>
                                        <option value="tinggal_kelas">Tinggal Kelas</option>
                                        <option value="skip">Tidak Diproses</option>
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <div class="flex gap-4">
                        <button type="button" onclick="setAllStatus('lulus')" class="text-sm text-green-600 hover:text-green-700 font-medium">
                            ✓ Pilih Semua Lulus
                        </button>
                        <button type="button" onclick="setAllStatus('tinggal_kelas')" class="text-sm text-red-600 hover:text-red-700 font-medium">
                            ✗ Pilih Semua Tinggal Kelas
                        </button>
                        <button type="button" onclick="setAllStatus('skip')" class="text-sm text-gray-600 hover:text-gray-700 font-medium">
                            ○ Pilih Semua Tidak Diproses
                        </button>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('kenaikan-kelas.index') }}" class="rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                        Batal
                    </a>
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 rounded-lg px-6 py-2.5 text-sm font-medium text-white transition" onclick="return confirm('Apakah Anda yakin ingin memproses kelulusan siswa?')">
                        Proses Kelulusan
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
        function setAllStatus(status) {
            document.querySelectorAll('select[name^="siswa_status"]').forEach(select => {
                select.value = status;
            });
        }
    </script>
@endsection

