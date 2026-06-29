@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Audit Logs" />

    <div class="space-y-6">
        <!-- Filter Card -->
        <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <form action="{{ route('audit-logs.index') }}" method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-5 items-end">
                <div>
                    <label class="mb-2 block text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">Pencarian</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari user, email, detail..."
                           class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                </div>

                <div>
                    <label class="mb-2 block text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">Aktivitas</label>
                    <select name="activity" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                        <option value="">Semua Aktivitas</option>
                        <option value="login" {{ request('activity') == 'login' ? 'selected' : '' }}>Login</option>
                        <option value="logout" {{ request('activity') == 'logout' ? 'selected' : '' }}>Logout</option>
                        <option value="create" {{ request('activity') == 'create' ? 'selected' : '' }}>Create (Tambah)</option>
                        <option value="update" {{ request('activity') == 'update' ? 'selected' : '' }}>Update (Edit)</option>
                        <option value="delete" {{ request('activity') == 'delete' ? 'selected' : '' }}>Delete (Hapus)</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                           class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                </div>

                <div>
                    <label class="mb-2 block text-xs font-semibold text-gray-500 uppercase dark:text-gray-400">Tanggal Selesai</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                           class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 rounded-lg px-4 py-2.5 text-sm font-medium text-white transition">
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'activity', 'start_date', 'end_date']))
                        <a href="{{ route('audit-logs.index') }}" class="w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg px-4 py-2.5 text-sm font-medium dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table Card -->
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="w-full">
                <table class="w-full table-fixed">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50 dark:border-gray-800 dark:bg-gray-900/50">
                            <th class="w-[15%] px-4 py-3 text-left">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Waktu</p>
                            </th>
                            <th class="w-[18%] px-4 py-3 text-left">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Pengguna</p>
                            </th>
                            <th class="w-[12%] px-4 py-3 text-left">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Aktivitas</p>
                            </th>
                            <th class="w-[40%] px-4 py-3 text-left">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Detail Deskripsi</p>
                            </th>
                            <th class="w-[15%] px-4 py-3 text-left">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">IP & Perangkat</p>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($auditLogs as $log)
                            <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50/50 dark:hover:bg-white/[0.01] transition-colors">
                                <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $log->created_at->format('d M Y, H:i') }}
                                    <span class="block text-xs text-gray-400 mt-0.5">{{ $log->created_at->diffForHumans() }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    @if($log->user)
                                        <div class="min-w-0">
                                            <p class="truncate font-medium text-gray-900 dark:text-white text-sm">{{ $log->user->name }}</p>
                                            <p class="truncate text-xs text-gray-400">{{ $log->user->email }}</p>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400 italic">Sistem / Tamu</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    @php
                                        $badges = [
                                            'login'  => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300',
                                            'logout' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300',
                                            'create' => 'bg-green-50 text-green-700 border-green-200 dark:bg-green-900/10 dark:text-green-400 dark:border-green-800',
                                            'update' => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-900/10 dark:text-blue-400 dark:border-blue-800',
                                            'delete' => 'bg-red-50 text-red-700 border-red-200 dark:bg-red-900/10 dark:text-red-400 dark:border-red-800',
                                        ];
                                        $badgeClass = $badges[$log->activity] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex rounded-full border px-2 py-0.5 text-xs font-semibold capitalize {{ $badgeClass }}">
                                        {{ $log->activity }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-300">
                                    <p class="font-medium text-gray-900 dark:text-white break-words">{{ $log->description }}</p>
                                    @if($log->old_values || $log->new_values)
                                        <div class="mt-2 text-xs bg-gray-50 dark:bg-gray-900/50 p-2 rounded-lg border border-gray-100 dark:border-gray-800 space-y-1">
                                            @if($log->old_values)
                                                <p class="break-all whitespace-normal"><span class="font-semibold text-red-500 dark:text-red-400">Sebelum:</span> <code>{{ json_encode($log->old_values, JSON_UNESCAPED_UNICODE) }}</code></p>
                                            @endif
                                            @if($log->new_values)
                                                <p class="break-all whitespace-normal"><span class="font-semibold text-green-500 dark:text-green-400">Sesudah:</span> <code>{{ json_encode($log->new_values, JSON_UNESCAPED_UNICODE) }}</code></p>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    <p class="font-mono text-xs">{{ $log->ip_address ?? '-' }}</p>
                                    <p class="text-xs text-gray-400 truncate max-w-full" title="{{ $log->user_agent }}">
                                        {{ $log->user_agent ?? '-' }}
                                    </p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center">
                                    <p class="text-gray-500 dark:text-gray-400">Belum ada data audit log.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($auditLogs->hasPages())
            <div class="mt-4">
                {{ $auditLogs->links() }}
            </div>
        @endif
    </div>
@endsection
