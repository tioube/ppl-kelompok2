@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Edit Siswa" />

    <div class="space-y-6">
        @if($currentSiswaTahunAjaran && in_array($currentSiswaTahunAjaran->status, ['tinggal_kelas', 'cuti']))
        <div class="rounded-xl border border-orange-200 bg-orange-50 p-6 dark:border-orange-800 dark:bg-orange-900/20">
            <h3 class="text-lg font-semibold text-orange-800 dark:text-orange-200 mb-2">
                @if($currentSiswaTahunAjaran->status === 'tinggal_kelas')
                    Siswa Tinggal Kelas
                @else
                    Siswa Cuti
                @endif
            </h3>
            <p class="text-sm text-orange-700 dark:text-orange-300 mb-4">
                Siswa ini memiliki status <strong>{{ str_replace('_', ' ', $currentSiswaTahunAjaran->status) }}</strong>
                di tahun ajaran {{ $currentSiswaTahunAjaran->tahunAjaran?->tahun }}.
                Untuk mengaktifkan kembali siswa ini di tahun ajaran baru, gunakan form di bawah.
            </p>

            <form action="{{ route('siswa.reaktivasi', $siswa) }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                @csrf
                <div>
                    <label class="mb-2 block text-sm font-medium text-orange-800 dark:text-orange-200">
                        Tahun Ajaran Baru <span class="text-red-500">*</span>
                    </label>
                    <select name="tahun_ajaran_baru_id" required class="w-full rounded-lg border border-orange-300 bg-white px-4 py-2.5 dark:border-orange-700 dark:bg-gray-800 dark:text-white">
                        <option value="">-- Pilih Tahun Ajaran --</option>
                        @foreach($tahunAjaranList as $ta)
                            @if($ta->id != $currentSiswaTahunAjaran->tahun_ajaran_id)
                            <option value="{{ $ta->id }}" {{ $ta->is_active ? 'selected' : '' }}>
                                {{ $ta->tahun }} {{ $ta->is_active ? '(Aktif)' : '' }}
                            </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-orange-800 dark:text-orange-200">
                        Kelas Baru <span class="text-red-500">*</span>
                    </label>
                    <select name="kelas_baru_id" required class="w-full rounded-lg border border-orange-300 bg-white px-4 py-2.5 dark:border-orange-700 dark:bg-gray-800 dark:text-white">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ $currentSiswaTahunAjaran->kelas_id == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-medium text-orange-800 dark:text-orange-200">
                        Jurusan
                    </label>
                    <select name="jurusan_baru_id" class="w-full rounded-lg border border-orange-300 bg-white px-4 py-2.5 dark:border-orange-700 dark:bg-gray-800 dark:text-white">
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach($jurusanList as $jurusan)
                            <option value="{{ $jurusan->id }}" {{ $currentSiswaTahunAjaran->jurusan_id == $jurusan->id ? 'selected' : '' }}>
                                {{ $jurusan->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 rounded-lg px-5 py-2.5 text-sm font-medium text-white transition" onclick="return confirm('Apakah Anda yakin ingin mengaktifkan kembali siswa ini di tahun ajaran baru?')">
                        Aktifkan di Tahun Baru
                    </button>
                </div>
            </form>
        </div>
        @endif

        @if($riwayatAkademik && $riwayatAkademik->count() > 1)
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Riwayat Akademik</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="px-4 py-2 text-left text-gray-500">Tahun Ajaran</th>
                            <th class="px-4 py-2 text-left text-gray-500">Kelas</th>
                            <th class="px-4 py-2 text-left text-gray-500">Jurusan</th>
                            <th class="px-4 py-2 text-left text-gray-500">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayatAkademik as $riwayat)
                        <tr class="border-b border-gray-100 dark:border-gray-800 {{ $riwayat->tahunAjaran?->is_active ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                            <td class="px-4 py-2">{{ $riwayat->tahunAjaran?->tahun ?? '-' }} {{ $riwayat->tahunAjaran?->is_active ? '(Aktif)' : '' }}</td>
                            <td class="px-4 py-2">{{ $riwayat->kelas?->nama ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $riwayat->jurusan?->nama ?? '-' }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium
                                    {{ $riwayat->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
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

        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Edit Data Siswa</h3>
            <form action="{{ route('siswa.update', $siswa) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label for="photo_profile" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Foto Profil
                        </label>
                        @if($siswa->photo_profile)
                            <div class="mb-3">
                                <img src="{{ Storage::url($siswa->photo_profile) }}" alt="{{ $siswa->name }}" class="h-24 w-24 rounded-full object-cover">
                            </div>
                        @endif
                        <input type="file" name="photo_profile" id="photo_profile" accept="image/*"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('photo_profile') border-red-500 @enderror">
                        @error('photo_profile')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $siswa->name) }}"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nisn" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            NISN
                        </label>
                        <input type="text" name="nisn" id="nisn" value="{{ old('nisn', $siswa->nisn) }}"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('nisn') border-red-500 @enderror">
                        @error('nisn')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $siswa->email) }}"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Password
                        </label>
                        <input type="password" name="password" id="password"
                            placeholder="Kosongkan jika tidak ingin mengubah"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="gender" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Jenis Kelamin
                        </label>
                        <select name="gender" id="gender"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('gender') border-red-500 @enderror">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('gender', $siswa->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender', $siswa->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="birth_date" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Tanggal Lahir
                        </label>
                        <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $siswa->birth_date) }}"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('birth_date') border-red-500 @enderror">
                        @error('birth_date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Nomor Telepon
                        </label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $siswa->phone) }}"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <hr class="my-4 border-gray-200 dark:border-gray-700">
                        <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4">Data Tahun Ajaran</h4>
                    </div>

                    <div>
                        <label for="tahun_ajaran_id" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Tahun Ajaran <span class="text-red-500">*</span>
                        </label>
                        <select name="tahun_ajaran_id" id="tahun_ajaran_id" required
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('tahun_ajaran_id') border-red-500 @enderror">
                            <option value="">Pilih Tahun Ajaran</option>
                            @foreach($tahunAjaranList as $ta)
                                <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id', $currentSiswaTahunAjaran?->tahun_ajaran_id) == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->tahun }} {{ $ta->is_active ? '(Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('tahun_ajaran_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nomor_induk_sekolah" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Nomor Induk Sekolah (NIS)
                        </label>
                        <input type="text" name="nomor_induk_sekolah" id="nomor_induk_sekolah" value="{{ old('nomor_induk_sekolah', $currentSiswaTahunAjaran?->nomor_induk_sekolah) }}"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('nomor_induk_sekolah') border-red-500 @enderror">
                        @error('nomor_induk_sekolah')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jurusan_id" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Jurusan
                        </label>
                        <select name="jurusan_id" id="jurusan_id"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('jurusan_id') border-red-500 @enderror">
                            <option value="">Pilih Jurusan</option>
                            @foreach($jurusanList as $jurusan)
                                <option value="{{ $jurusan->id }}" {{ old('jurusan_id', $currentSiswaTahunAjaran?->jurusan_id) == $jurusan->id ? 'selected' : '' }}>
                                    {{ $jurusan->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('jurusan_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="kelas_id" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Kelas
                        </label>
                        <select name="kelas_id" id="kelas_id"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('kelas_id') border-red-500 @enderror">
                            <option value="">Pilih Kelas</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" {{ old('kelas_id', $currentSiswaTahunAjaran?->kelas_id) == $kelas->id ? 'selected' : '' }}>
                                    {{ $kelas->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Status
                        </label>
                        <select name="status" id="status"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('status') border-red-500 @enderror">
                            <option value="aktif" {{ old('status', $currentSiswaTahunAjaran?->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="naik_kelas" {{ old('status', $currentSiswaTahunAjaran?->status) == 'naik_kelas' ? 'selected' : '' }}>Naik Kelas</option>
                            <option value="tinggal_kelas" {{ old('status', $currentSiswaTahunAjaran?->status) == 'tinggal_kelas' ? 'selected' : '' }}>Tinggal Kelas</option>
                            <option value="lulus" {{ old('status', $currentSiswaTahunAjaran?->status) == 'lulus' ? 'selected' : '' }}>Lulus</option>
                            <option value="pindah" {{ old('status', $currentSiswaTahunAjaran?->status) == 'pindah' ? 'selected' : '' }}>Pindah</option>
                            <option value="dikeluarkan" {{ old('status', $currentSiswaTahunAjaran?->status) == 'dikeluarkan' ? 'selected' : '' }}>Dikeluarkan</option>
                            <option value="cuti" {{ old('status', $currentSiswaTahunAjaran?->status) == 'cuti' ? 'selected' : '' }}>Cuti</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="address" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Alamat
                        </label>
                        <textarea name="address" id="address" rows="3"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white @error('address') border-red-500 @enderror">{{ old('address', $siswa->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-3">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 rounded-lg px-5 py-2.5 text-sm font-medium text-white dark:bg-blue-600 dark:hover:bg-blue-700 transition">
                        Update
                    </button>
                    <a href="{{ route('siswa.index') }}"
                        class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
