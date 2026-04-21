@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Penugasan Guru" />

    <div class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Daftar Penugasan Guru</h2>
                <div class="flex items-center gap-3">
                    <form action="{{ route('guru-mapel-kelas.generate') }}" method="POST" class="inline"
                        onsubmit="return confirm('Generate otomatis akan membuat penugasan untuk semua kombinasi guru-mapel-kelas. Lanjutkan?')">
                        @csrf
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 rounded-lg px-4 py-2 text-sm font-medium text-white dark:bg-blue-600 dark:hover:bg-blue-700 transition">
                            <i class="fas fa-magic mr-2"></i>Generate Otomatis
                        </button>
                    </form>
                    <form action="{{ route('guru-mapel-kelas.clear') }}" method="POST" class="inline"
                        onsubmit="return confirm('Yakin ingin menghapus SEMUA penugasan? Tindakan ini tidak dapat dibatalkan!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 rounded-lg px-4 py-2 text-sm font-medium text-white dark:bg-red-600 dark:hover:bg-red-700 transition">
                            <i class="fas fa-trash-alt mr-2"></i>Hapus Semua
                        </button>
                    </form>
                    <a href="{{ route('guru-mapel-kelas.create') }}"
                        class="bg-blue-600 hover:bg-blue-700 rounded-lg px-4 py-2 text-sm font-medium text-white dark:bg-blue-600 dark:hover:bg-blue-700 transition">
                        <i class="fas fa-plus mr-2"></i>Tambah Penugasan
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-green-900/20 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-red-900/20 dark:text-red-400">
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-x-auto rounded-lg shadow-sm">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 text-xs uppercase dark:from-gray-800 dark:to-gray-900">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">No</th>
                            <th scope="col" class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">Guru</th>
                            <th scope="col" class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">Mata Pelajaran</th>
                            <th scope="col" class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">Kelas</th>
                            <th scope="col" class="px-6 py-4 font-semibold text-gray-700 dark:text-gray-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($assignments as $index => $assignment)
                            <tr class="bg-white transition-colors hover:bg-gray-50 dark:bg-gray-900 dark:hover:bg-gray-800">
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $assignments->firstItem() + $index }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                            {{ substr($assignment->guru->name, 0, 1) }}
                                        </div>
                                        <span class="font-medium text-gray-900 dark:text-white">{{ $assignment->guru->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $assignment->mataPelajaran->nama }}</div>
                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                        {{ $assignment->mataPelajaran->kode }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        {{ $assignment->kelas->nama }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('guru-mapel-kelas.edit', $assignment) }}"
                                            class="text-blue-600 transition-colors hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
                                            title="Edit">
                                            <i class="fas fa-edit text-lg"></i>
                                        </a>
                                        <form action="{{ route('guru-mapel-kelas.destroy', $assignment) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus penugasan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 transition-colors hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                                                title="Hapus">
                                                <i class="fas fa-trash text-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-inbox mb-2 text-3xl text-gray-400"></i>
                                    <p>Belum ada penugasan guru.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($assignments->hasPages())
                <div class="mt-4">
                    {{ $assignments->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

