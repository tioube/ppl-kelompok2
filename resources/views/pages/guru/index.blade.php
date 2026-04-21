@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="List Guru" />

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

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Guru</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">List semua pengguna dengan role Guru</p>
            </div>

            <div class="max-w-full overflow-x-auto custom-scrollbar">
                <table class="w-full min-w-[1102px]">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Name</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Email</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Roles</p>
                            </th>
                            <th class="px-5 py-3 text-left sm:px-6">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Joined</p>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($gurus as $guru)
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="px-5 py-4 sm:px-6">
                                    <div class="flex items-center gap-3">
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $guru->name }}</p>
                                    </div>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $guru->email }}</p>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    <div class="flex flex-wrap gap-2">
                                        @forelse($guru->roles as $role)
                                            <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                {{ $role->name }}
                                            </span>
                                        @empty
                                            <span class="text-sm text-gray-400 dark:text-gray-500">No roles</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-5 py-4 sm:px-6">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $guru->created_at->format('d M Y') }}</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">{{ $guru->created_at->diffForHumans() }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-8 text-center sm:px-6">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        <p class="mt-4 text-sm font-medium text-gray-900 dark:text-white">Belum ada data Guru</p>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Data akan muncul setelah ada pengguna dengan role Guru</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($gurus->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-800">
                    {{ $gurus->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

