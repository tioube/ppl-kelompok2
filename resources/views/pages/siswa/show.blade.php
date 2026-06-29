@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Detail Siswa" />

    <div class="space-y-6">
        <div class="flex justify-end gap-2">
            <a href="{{ route('siswa.edit', $siswa) }}"
                class="bg-blue-600 hover:bg-blue-700 flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-white dark:bg-blue-600 dark:hover:bg-blue-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                </svg>
                Edit
            </a>
            <a href="{{ route('siswa.index') }}"
                class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-1">
                <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="flex flex-col items-center">
                        @if($siswa->photo_profile)
                            <img src="{{ Storage::url($siswa->photo_profile) }}" alt="Foto {{ $siswa->name }}"
                                class="h-32 w-32 rounded-full object-cover border-4 border-gray-100 dark:border-gray-700"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="hidden h-32 w-32 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700 border-4 border-gray-100 dark:border-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12 12a5 5 0 100-10 5 5 0 000 10zm-7 9a7 7 0 1114 0H5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        @else
                            <div class="flex h-32 w-32 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700 border-4 border-gray-100 dark:border-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12 12a5 5 0 100-10 5 5 0 000 10zm-7 9a7 7 0 1114 0H5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        @endif

                        <h2 class="mt-4 text-xl font-bold text-gray-900 dark:text-white text-center">{{ $siswa->name }}</h2>

                        @if($siswa->nisn)
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">NISN: {{ $siswa->nisn }}</p>
                        @endif

                        <div class="mt-4 flex flex-wrap gap-2 justify-center">
                            @foreach($siswa->roles as $role)
                                <span class="inline-flex rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </div>

                        @if($currentSiswaTahunAjaran)
                        <div class="mt-4 w-full pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="text-center">
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium
                                    @if($currentSiswaTahunAjaran->status === 'aktif') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                    @elseif($currentSiswaTahunAjaran->status === 'lulus') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400
                                    @elseif($currentSiswaTahunAjaran->status === 'naik_kelas') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $currentSiswaTahunAjaran->status)) }}
                                </span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">
                <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Siswa</h3>
                    </div>

                    <div class="p-6">
                        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $siswa->email }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jenis Kelamin</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $siswa->gender ?? '-' }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Lahir</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    @if($siswa->birth_date)
                                        {{ \Carbon\Carbon::parse($siswa->birth_date)->format('d F Y') }}
                                        ({{ \Carbon\Carbon::parse($siswa->birth_date)->age }} tahun)
                                    @else
                                        -
                                    @endif
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nomor Telepon</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $siswa->phone ?? '-' }}</dd>
                            </div>

                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Alamat</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $siswa->address ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                @if($currentSiswaTahunAjaran)
                <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Akademik Saat Ini</h3>
                    </div>

                    <div class="p-6">
                        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tahun Ajaran</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        {{ $currentSiswaTahunAjaran->tahunAjaran->tahun }}
                                        @if($currentSiswaTahunAjaran->tahunAjaran->is_active)
                                            (Aktif)
                                        @endif
                                    </span>
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kelas</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    @if($currentSiswaTahunAjaran->kelas)
                                        <span class="inline-flex rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">
                                            {{ $currentSiswaTahunAjaran->kelas->nama }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jurusan</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $currentSiswaTahunAjaran->jurusan->nama ?? '-' }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">NIS</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $currentSiswaTahunAjaran->nomor_induk_sekolah ?? '-' }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium
                                        @if($currentSiswaTahunAjaran->status === 'aktif') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                        @elseif($currentSiswaTahunAjaran->status === 'lulus') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400
                                        @elseif($currentSiswaTahunAjaran->status === 'naik_kelas') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                        @elseif($currentSiswaTahunAjaran->status === 'pindah') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $currentSiswaTahunAjaran->status)) }}
                                    </span>
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Terdaftar Sejak</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $siswa->created_at->format('d F Y') }}
                                </dd>
                            </div>
                        </dl>

                        @if($currentSiswaTahunAjaran->catatan)
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Catatan</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $currentSiswaTahunAjaran->catatan }}</dd>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                @if($riwayatAkademik && $riwayatAkademik->count() > 0)
                <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Riwayat Akademik</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Riwayat kelas dan tahun ajaran siswa</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tahun Ajaran</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kelas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jurusan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">NIS</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($riwayatAkademik as $riwayat)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm text-gray-900 dark:text-white">{{ $riwayat->tahunAjaran->tahun }}</span>
                                            @if($riwayat->tahunAjaran->is_active)
                                                <span class="inline-flex rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900/30 dark:text-green-400">Aktif</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900 dark:text-white">{{ $riwayat->kelas->nama ?? '-' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $riwayat->jurusan->nama ?? '-' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $riwayat->nomor_induk_sekolah ?? '-' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                            @if($riwayat->status === 'aktif') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                            @elseif($riwayat->status === 'lulus') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400
                                            @elseif($riwayat->status === 'naik_kelas') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                            @elseif($riwayat->status === 'pindah') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                            @else bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400
                                            @endif">
                                            {{ ucfirst(str_replace('_', ' ', $riwayat->status)) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Mini Raport Tahunan (Ringkasan Hasil Belajar) -->
                @if(isset($raportByYear) && count($raportByYear) > 0)
                <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800 bg-gray-50/20 dark:bg-gray-800/10">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ringkasan Hasil Belajar (Mini Rapor)</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Ringkasan nilai per tahun ajaran</p>
                    </div>

                    <div class="p-6 space-y-6">
                        @foreach($riwayatAkademik as $riwayat)
                            @php
                                $yearId = $riwayat->tahun_ajaran_id;
                                $yearRaport = $raportByYear[$yearId] ?? null;
                            @endphp

                            @if($yearRaport)
                            <div class="border border-gray-200 dark:border-gray-800 rounded-xl p-4 space-y-4">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-b border-gray-100 dark:border-gray-800 pb-3">
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-900 dark:text-white">
                                            Tahun Ajaran: {{ $riwayat->tahunAjaran->tahun }} 
                                            <span class="text-gray-400 font-normal">| Kelas {{ $riwayat->kelas->nama ?? '-' }}</span>
                                        </h4>
                                    </div>
                                    @if($yearRaport['overall_average'] !== null)
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-semibold text-gray-500">Rata-rata Umum:</span>
                                        <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-bold text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400">
                                            {{ $yearRaport['overall_average'] }}
                                        </span>
                                    </div>
                                    @endif
                                </div>

                                <div class="overflow-x-auto">
                                    <table class="w-full text-xs text-left">
                                        <thead>
                                            <tr class="border-b border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 font-bold uppercase tracking-wider">
                                                <th class="py-2 w-12">No</th>
                                                <th class="py-2">Mata Pelajaran</th>
                                                <th class="py-2 text-center w-32">Rerata Formatif</th>
                                                <th class="py-2 text-center w-32">Rerata Sumatif</th>
                                                <th class="py-2 text-center w-28">Nilai Akhir</th>
                                                <th class="py-2 text-center w-32">Ketuntasan</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800/50">
                                            @foreach($yearRaport['subjects'] as $index => $subject)
                                            <tr class="hover:bg-gray-50/30 dark:hover:bg-gray-800/10">
                                                <td class="py-2.5 font-medium text-gray-500">{{ $index + 1 }}</td>
                                                <td class="py-2.5 font-semibold text-gray-900 dark:text-white">{{ $subject['name'] }}</td>
                                                <td class="py-2.5 text-center font-medium text-gray-700 dark:text-gray-300">
                                                    {{ $subject['avg_formatif'] ?? '-' }}
                                                </td>
                                                <td class="py-2.5 text-center font-medium text-gray-700 dark:text-gray-300">
                                                    {{ $subject['avg_sumatif'] ?? '-' }}
                                                </td>
                                                <td class="py-2.5 text-center font-bold">
                                                    <span class="{{ $subject['final_score'] !== null ? ($subject['final_score'] >= 75 ? 'text-green-600 dark:text-green-400' : 'text-rose-600 dark:text-rose-400') : 'text-gray-400' }}">
                                                        {{ $subject['final_score'] ?? '-' }}
                                                    </span>
                                                </td>
                                                <td class="py-2.5 text-center">
                                                    @if($subject['final_score'] !== null)
                                                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-bold
                                                            {{ $subject['final_score'] >= 75 ? 'bg-green-50 text-green-700 dark:bg-green-950/20 dark:text-green-400' : 'bg-red-50 text-red-700 dark:bg-red-950/20 dark:text-red-400' }}">
                                                            {{ $subject['final_score'] >= 75 ? 'TUNTAS' : 'REMEDIAL' }}
                                                        </span>
                                                    @else
                                                        <span class="text-gray-400">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

