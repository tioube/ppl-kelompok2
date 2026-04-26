@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Time Slots" />

    <div class="space-y-6">
        @session('success')
            <x-ui.alert variant="success">
                {{ $value }}
            </x-ui.alert>
        @endsession

        @session('error')
            <x-ui.alert variant="error">
                {{ $value }}
            </x-ui.alert>
        @endsession

        <div class="flex items-center justify-end">
            <a href="{{ route('time-slots.create') }}"
                class="bg-blue-600 hover:bg-blue-700 rounded-lg px-4 py-2 text-sm font-medium text-white transition">
                Tambah Time Slot
            </a>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="max-w-full overflow-x-auto custom-scrollbar">
                <table class="w-full min-w-[900px]">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50 dark:border-gray-800 dark:bg-gray-900/50">
                            <th class="px-5 py-3 text-left sm:px-6">Hari</th>
                            <th class="px-5 py-3 text-left sm:px-6">Slot</th>
                            <th class="px-5 py-3 text-left sm:px-6">Tipe</th>
                            <th class="px-5 py-3 text-left sm:px-6">Waktu</th>
                            <th class="px-5 py-3 text-left sm:px-6">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($timeSlots as $slot)
                            <tr class="border-b border-gray-100 transition hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-900/30">
                                <td class="px-5 py-4 sm:px-6">{{ ucfirst($slot->day) }}</td>
                                <td class="px-5 py-4 sm:px-6">{{ $slot->slot_index }}</td>
                                <td class="px-5 py-4 sm:px-6">{{ ucfirst($slot->type) }}</td>
                                <td class="px-5 py-4 sm:px-6">{{ substr($slot->start_time, 0, 5) }} - {{ substr($slot->end_time, 0, 5) }}</td>
                                <td class="px-5 py-4 sm:px-6">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('time-slots.edit', $slot) }}"
                                            class="inline-flex rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                                            Edit
                                        </a>
                                        <form action="{{ route('time-slots.destroy', $slot) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus time slot ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex rounded-lg border border-red-300 bg-white px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50 dark:border-red-700 dark:bg-gray-800 dark:text-red-400">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-sm text-gray-500 sm:px-6">Belum ada time slot.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($timeSlots->hasPages())
            <div>
                {{ $timeSlots->links() }}
            </div>
        @endif
    </div>
@endsection
