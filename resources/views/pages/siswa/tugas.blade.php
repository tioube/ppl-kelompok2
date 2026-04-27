@php use Illuminate\Support\Facades\Storage; @endphp
@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tugas</h1>
    <p class="text-gray-500 dark:text-gray-400 mt-1">
        Kelas <span class="font-semibold text-primary">{{ $user->kelas?->nama ?? '-' }}</span>
    </p>
</div>

@if (session('success'))
    <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-sm text-green-700 dark:bg-green-900/30 dark:text-green-300">
        {{ session('success') }}
    </div>
@endif

{{-- Tugas Aktif --}}
<div class="mb-6">
    <h2 class="text-lg font-semibold text-black dark:text-white mb-3">📋 Tugas Aktif</h2>

    @if ($tugasAktif->isEmpty())
        <div class="rounded-lg border border-stroke bg-white p-8 text-center dark:border-strokedark dark:bg-boxdark">
            <p class="text-gray-400">Tidak ada tugas aktif saat ini</p>
        </div>
    @else
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @foreach ($tugasAktif as $tugas)
                @php $sudahKumpul = $tugas->pengumpulanSiswa($user->id); @endphp
                <div class="rounded-lg border border-stroke bg-white p-5 shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <h3 class="font-semibold text-black dark:text-white">{{ $tugas->judul }}</h3>
                        @if ($sudahKumpul)
                            <span class="shrink-0 inline-flex rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700">
                                ✅ Terkumpul
                            </span>
                        @else
                            <span class="shrink-0 inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                                Aktif
                            </span>
                        @endif
                    </div>

                    <p class="text-sm text-gray-500 mb-3">{{ $tugas->deskripsi }}</p>

                    <div class="flex items-center justify-between text-xs text-gray-500 border-t border-stroke pt-3 dark:border-strokedark">
                        <span>📚 {{ $tugas->mataPelajaran?->nama ?? '-' }}</span>
                        <span>👨‍🏫 {{ $tugas->guru?->name ?? '-' }}</span>
                    </div>
                    <div class="mt-2 text-xs font-semibold text-red-500">
                        ⏰ Deadline: {{ $tugas->deadline->translatedFormat('l, d F Y H:i') }}
                    </div>

                    {{-- Download Materi --}}
                    <div class="mt-3">
                        @if ($tugas->file_materi)
                            <a href="{{ Storage::url($tugas->file_materi) }}"
                            download
                            class="flex items-center gap-2 rounded-lg border border-primary px-3 py-2 text-xs font-semibold text-primary hover:bg-primary hover:text-white transition">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Download Materi
                            </a>
                        @else
                            <div class="flex items-center gap-2 rounded-lg border border-gray-200 px-3 py-2 text-xs text-gray-400 dark:border-strokedark">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Tidak ada materi
                            </div>
                        @endif
                    </div>
                    {{-- Upload Jawaban --}}
                    <div class="mt-4 border-t border-stroke pt-4 dark:border-strokedark">
                        @if ($sudahKumpul)
                            <div class="mb-3 rounded-lg bg-blue-50 px-3 py-2 dark:bg-blue-900/20">
                                <p class="text-xs text-blue-700 dark:text-blue-300">
                                    ✅ Dikumpulkan: {{ $sudahKumpul->dikumpulkan_at->translatedFormat('d F Y H:i') }}
                                </p>
                                @if ($sudahKumpul->catatan)
                                    <p class="text-xs text-gray-500 mt-1">📝 {{ $sudahKumpul->catatan }}</p>
                                @endif
                            </div>
                        @endif

                        <form action="{{ route('siswa.tugas.upload', $tugas->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label class="mb-2 flex cursor-pointer items-center justify-center gap-2 rounded-lg border-2 border-dashed border-stroke px-4 py-3 hover:border-primary dark:border-strokedark">
                                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                <span class="text-xs text-gray-500" id="label-{{ $tugas->id }}">Pilih file jawaban (PDF/DOC/IMG)</span>
                                <input type="file"
                                    name="file_jawaban"
                                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                    class="hidden"
                                    onchange="document.getElementById('label-{{ $tugas->id }}').textContent = this.files[0]?.name ?? 'Pilih file'">
                            </label>
                            <input type="text"
                                name="catatan"
                                placeholder="Catatan (opsional)"
                                value="{{ $sudahKumpul?->catatan }}"
                                class="mb-2 w-full rounded-lg border border-stroke px-3 py-2 text-xs dark:border-strokedark dark:bg-boxdark">
                            <button type="submit"
                                class="flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2 text-xs font-semibold text-white hover:bg-opacity-90 transition">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                {{ $sudahKumpul ? 'Kumpulkan Ulang' : 'Kumpulkan Tugas' }}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Tugas Lewat Deadline --}}
<div>
    <h2 class="text-lg font-semibold text-black dark:text-white mb-3">⏰ Tugas Lewat Deadline</h2>

    @if ($tugasLewat->isEmpty())
        <div class="rounded-lg border border-stroke bg-white p-8 text-center dark:border-strokedark dark:bg-boxdark">
            <p class="text-gray-400">Tidak ada tugas yang lewat deadline</p>
        </div>
    @else
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @foreach ($tugasLewat as $tugas)
                @php $sudahKumpul = $tugas->pengumpulanSiswa($user->id); @endphp
                <div class="rounded-lg border border-stroke bg-white p-5 shadow-default dark:border-strokedark dark:bg-boxdark opacity-70">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <h3 class="font-semibold text-black dark:text-white">{{ $tugas->judul }}</h3>
                        @if ($sudahKumpul)
                            <span class="shrink-0 inline-flex rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700">
                                ✅ Terkumpul
                            </span>
                        @else
                            <span class="shrink-0 inline-flex rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">
                                Lewat
                            </span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-500 mb-3">{{ $tugas->deskripsi }}</p>
                    <div class="flex items-center justify-between text-xs text-gray-500 border-t border-stroke pt-3 dark:border-strokedark">
                        <span>📚 {{ $tugas->mataPelajaran?->nama ?? '-' }}</span>
                        <span>👨‍🏫 {{ $tugas->guru?->name ?? '-' }}</span>
                    </div>
                    <div class="mt-2 text-xs font-semibold text-gray-400">
                        ⏰ Deadline: {{ $tugas->deadline->translatedFormat('l, d F Y H:i') }}
                    </div>

                    @if ($sudahKumpul)
                        <p class="mt-3 text-xs text-gray-500">
                            Dikumpulkan: {{ $sudahKumpul->dikumpulkan_at->translatedFormat('d F Y H:i') }}
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
