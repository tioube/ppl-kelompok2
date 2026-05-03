@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Detail Guru" />

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

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Profile Photo & Basic Info -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="text-center">
                    @if($guru->photo_profile)
                        <img src="{{ Storage::url($guru->photo_profile) }}" alt="{{ $guru->name }}"
                             class="mx-auto h-32 w-32 rounded-full object-cover">
                    @else
                        <div class="mx-auto flex h-32 w-32 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30">
                            <span class="text-4xl font-medium text-green-800 dark:text-green-400">{{ substr($guru->name, 0, 1) }}</span>
                        </div>
                    @endif

                    <h3 class="mt-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $guru->name }}</h3>
                    <p class="text-gray-500 dark:text-gray-400">{{ $guru->email }}</p>

                    <div class="mt-3">
                        @foreach($guru->roles as $role)
                            <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                {{ $role->name }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex space-x-3">
                    @if (auth()->user()->hasPermission('edit-guru') || auth()->user()->hasPermission('manage-guru'))
                    <a href="{{ route('guru.edit', $guru) }}"
                       class="flex-1 rounded-lg bg-blue-600 px-4 py-2 text-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Edit
                    </a>
                    @endif

                    <a href="{{ route('guru.index') }}"
                       class="flex-1 rounded-lg border border-gray-300 bg-white px-4 py-2 text-center text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Detailed Information -->
            <div class="lg:col-span-2">
                <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                    <h4 class="mb-6 text-lg font-semibold text-gray-900 dark:text-white">Informasi Guru</h4>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- NIP -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">NIP</label>
                            <p class="text-gray-900 dark:text-white">{{ $guru->nip ?? '-' }}</p>
                        </div>

                        <!-- Gender -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Kelamin</label>
                            <p class="text-gray-900 dark:text-white">{{ $guru->gender ?? '-' }}</p>
                        </div>

                        <!-- Birth Date -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Lahir</label>
                            <p class="text-gray-900 dark:text-white">
                                {{ $guru->birth_date ? \Carbon\Carbon::parse($guru->birth_date)->format('d F Y') : '-' }}
                            </p>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Telepon</label>
                            <p class="text-gray-900 dark:text-white">{{ $guru->phone ?? '-' }}</p>
                        </div>


                        <!-- Joined Date -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Bergabung</label>
                            <p class="text-gray-900 dark:text-white">{{ $guru->created_at->format('d F Y') }}</p>
                        </div>
                    </div>

                    <!-- Address -->
                    @if($guru->address)
                    <div class="mt-6">
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
                        <p class="text-gray-900 dark:text-white">{{ $guru->address }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Danger Zone -->
        @if (auth()->user()->hasPermission('delete-guru') || auth()->user()->hasPermission('manage-guru'))
        <div class="rounded-xl border border-red-200 bg-red-50 p-6 dark:border-red-800 dark:bg-red-900/20">
            <h4 class="mb-2 text-lg font-semibold text-red-900 dark:text-red-400">Danger Zone</h4>
            <p class="mb-4 text-sm text-red-700 dark:text-red-300">
                Tindakan berikut akan menghapus data guru secara permanen dan tidak dapat dibatalkan.
            </p>

            <form action="{{ route('guru.destroy', $guru) }}" method="POST"
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus guru ini? Tindakan ini tidak dapat dibatalkan.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                    Hapus Guru
                </button>
            </form>
        </div>
        @endif
    </div>
@endsection
