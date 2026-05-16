@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Detail Silabus" />

    <div class="space-y-6">
        @session('success')
            <x-ui.alert variant="success">{{ $value }}</x-ui.alert>
        @endsession

        @session('error')
            <x-ui.alert variant="error">{{ $value }}</x-ui.alert>
        @endsession

        <!-- Main Content Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                    <div class="flex-1">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            Detail Silabus
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ $silabus->mataPelajaran->nama }} ({{ $silabus->mataPelajaran->kode }})
                        </p>
                    </div>

                    <!-- Status Badges -->
                    <div class="flex flex-wrap gap-1">
                        @include('silabus.partials.status-badges', [
                            'approvalStatus' => $silabus->approval_status,
                            'status' => $silabus->status,
                            'kategori' => $silabus->kategori
                        ])
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center space-x-3">
                        @can('update', $silabus)
                            @if($silabus->canBeEdited())
                                <a href="{{ route('silabus.edit', $silabus) }}"
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                            @endif
                        @endcan

                        <a href="{{ route('silabus.index') }}"
                           class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md shadow-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Rejection Notice -->
            @if($silabus->approval_status === 'rejected' && $silabus->rejection_reason)
                <div class="px-6 py-4 bg-red-50 dark:bg-red-900/20 border-b border-red-200 dark:border-red-800">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800 dark:text-red-300">
                                Silabus Ditolak
                            </h3>
                            <div class="mt-1 text-sm text-red-700 dark:text-red-400">
                                <p><strong>Alasan:</strong> {{ $silabus->rejection_reason }}</p>
                                @can('update', $silabus)
                                    <p class="mt-1">
                                        <a href="{{ route('silabus.edit', $silabus) }}" class="font-medium underline hover:no-underline">
                                            Perbaiki silabus ini →
                                        </a>
                                    </p>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Content -->
            <div class="p-6 space-y-8">
                <!-- Mata Pelajaran Info -->
                <div>
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Mata Pelajaran</h4>
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama:</span>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $silabus->mataPelajaran->nama }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Kode:</span>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $silabus->mataPelajaran->kode }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Kategori:</span>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $silabus->mataPelajaran->kategori }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Jam Pelajaran:</span>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $silabus->mataPelajaran->jam_pelajaran }} JP</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tujuan Pembelajaran -->
                <div>
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Tujuan Pembelajaran</h4>
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6 border border-blue-200 dark:border-blue-800">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                @if($silabus->kategori === 'formatif')
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/30">
                                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                @else
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900/30">
                                        <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="flex items-center mb-2">
                                    <h5 class="text-lg font-medium {{ $silabus->kategori === 'formatif' ? 'text-blue-900 dark:text-blue-300' : 'text-purple-900 dark:text-purple-300' }}">
                                        Kategori {{ ucfirst($silabus->kategori) }}
                                    </h5>
                                </div>
                                <div class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                    {{ $silabus->tujuan_pembelajaran }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Workflow Actions -->
                @can('update', $silabus)
                    @if($silabus->approval_status === 'draft')
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-4 border border-yellow-200 dark:border-yellow-800">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-300">
                                        Silabus Masih Draft
                                    </h3>
                                    <div class="mt-1 text-sm text-yellow-700 dark:text-yellow-400">
                                        <p>Silabus ini masih dalam status draft. Ajukan untuk persetujuan jika sudah selesai.</p>
                                    </div>
                                    <div class="mt-4">
                                        <form action="{{ route('silabus.submit-approval', $silabus) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500"
                                                    onclick="return confirm('Ajukan silabus untuk persetujuan?')">
                                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                                </svg>
                                                Ajukan untuk Persetujuan
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($silabus->approval_status === 'pending_approval')
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">
                                        Menunggu Persetujuan
                                    </h3>
                                    <div class="mt-1 text-sm text-blue-700 dark:text-blue-400">
                                        <p>Silabus telah diajukan dan sedang menunggu persetujuan dari akademik.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endcan

                <!-- Approval Actions for Akademik/Super-admin -->
                @can('approve', $silabus)
                    @if($silabus->approval_status === 'pending_approval')
                        <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-200 dark:border-green-800">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <h3 class="text-sm font-medium text-green-800 dark:text-green-300">
                                        Tindakan Persetujuan
                                    </h3>
                                    <div class="mt-1 text-sm text-green-700 dark:text-green-400">
                                        <p>Silabus ini siap untuk ditinjau dan disetujui.</p>
                                    </div>
                                    <div class="mt-4 flex space-x-3">
                                        <form action="{{ route('silabus.approve', $silabus) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                                    onclick="return confirm('Setujui silabus ini?')">
                                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Setujui
                                            </button>
                                        </form>

                                        <button type="button"
                                                onclick="showRejectModal()"
                                                class="inline-flex items-center px-4 py-2 border border-red-300 text-sm font-medium rounded-md shadow-sm text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Tolak
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($silabus->approval_status === 'approved')
                        <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-lg p-4 border border-emerald-200 dark:border-emerald-800">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <h3 class="text-sm font-medium text-emerald-800 dark:text-emerald-300">
                                        Status Aktivasi
                                    </h3>
                                    <div class="mt-1 text-sm text-emerald-700 dark:text-emerald-400">
                                        <p>Silabus sudah disetujui. Anda dapat mengaktifkan atau menonaktifkan silabus ini.</p>
                                    </div>
                                    <div class="mt-4">
                                        <form action="{{ route('silabus.toggle-status', $silabus) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white {{ $silabus->status === 'aktif' ? 'bg-gray-600 hover:bg-gray-700' : 'bg-emerald-600 hover:bg-emerald-700' }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500"
                                                    onclick="return confirm('{{ $silabus->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }} silabus ini?')">
                                                @if($silabus->status === 'aktif')
                                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L5.636 5.636"/>
                                                    </svg>
                                                    Nonaktifkan Silabus
                                                @else
                                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                    </svg>
                                                    Aktifkan Silabus
                                                @endif
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endcan

                <!-- Metadata -->
                <div>
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Silabus</h4>
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="font-medium text-gray-500 dark:text-gray-400">Urutan:</span>
                                <span class="text-gray-900 dark:text-white ml-2">{{ $silabus->urutan ?: 'Tidak diatur' }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-500 dark:text-gray-400">Dibuat oleh:</span>
                                <span class="text-gray-900 dark:text-white ml-2">{{ $silabus->createdBy->name }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-500 dark:text-gray-400">Tanggal dibuat:</span>
                                <span class="text-gray-900 dark:text-white ml-2">{{ $silabus->created_at->format('d M Y H:i') }}</span>
                            </div>
                            @if($silabus->updated_at != $silabus->created_at)
                                <div>
                                    <span class="font-medium text-gray-500 dark:text-gray-400">Terakhir diubah:</span>
                                    <span class="text-gray-900 dark:text-white ml-2">{{ $silabus->updated_at->format('d M Y H:i') }}</span>
                                </div>
                            @endif
                            @if($silabus->approvedBy)
                                <div>
                                    <span class="font-medium text-gray-500 dark:text-gray-400">Disetujui oleh:</span>
                                    <span class="text-gray-900 dark:text-white ml-2">{{ $silabus->approvedBy->name }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-500 dark:text-gray-400">Tanggal disetujui:</span>
                                    <span class="text-gray-900 dark:text-white ml-2">{{ $silabus->approved_at->format('d M Y H:i') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="hideRejectModal()"></div>

            <div class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-gray-800 shadow-xl rounded-2xl">
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4">
                    Tolak Silabus
                </h3>

                <form action="{{ route('silabus.reject', $silabus) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Alasan Penolakan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="rejection_reason"
                                  id="rejection_reason"
                                  rows="4"
                                  required
                                  placeholder="Berikan alasan penolakan yang jelas..."
                                  class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"></textarea>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button"
                                onclick="hideRejectModal()"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md shadow-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            Batal
                        </button>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700">
                            Tolak Silabus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function showRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
            document.getElementById('rejection_reason').focus();
        }

        function hideRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('rejection_reason').value = '';
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                hideRejectModal();
            }
        });
    </script>
    @endpush
@endsection
