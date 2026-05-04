@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Jadwal Pelajaran (Sistem Baru)" />

    <div class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="mb-6">
                <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Generate Jadwal Otomatis</h2>

                <form action="{{ route('schedules.index') }}" method="GET" class="mb-4">
                    <div class="flex flex-wrap items-end gap-3">
                        <div class="flex-1 min-w-[200px]">
                            <label for="tahun_ajaran_id" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                Tahun Ajaran
                            </label>
                            <select name="tahun_ajaran_id" id="tahun_ajaran_id"
                                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                <option value="">-- Pilih Tahun Ajaran --</option>
                                @foreach($tahunAjaranList as $ta)
                                    <option value="{{ $ta->id }}" {{ $selectedTahunAjaran == $ta->id ? 'selected' : '' }}>
                                        {{ $ta->tahun }} {{ $ta->is_active ? '(Aktif)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-1 min-w-[200px]">
                            <label for="kelas_id" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                Pilih Kelas
                            </label>
                            <select name="kelas_id" id="kelas_id"
                                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-primary focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}" {{ $selectedKelasId == $kelas->id ? 'selected' : '' }}>
                                        {{ $kelas->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 rounded-lg px-5 py-2.5 text-sm font-medium text-white transition">
                            Lihat Jadwal
                        </button>
                    </div>
                </form>

                @if($selectedKelasId)
                    <div class="flex flex-wrap items-center gap-3">
                        @if (auth()->user()->hasPermission('generate-schedules') || auth()->user()->hasPermission('manage-schedules'))
                        <form action="{{ route('schedules.generate') }}" method="POST">
                            @csrf
                            <input type="hidden" name="kelas_id" value="{{ $selectedKelasId }}">
                            <input type="hidden" name="tahun_ajaran_id" value="{{ $selectedTahunAjaran }}">
                            <button type="submit"
                                onclick="return confirm('Generate ulang jadwal? Jadwal lama akan dihapus!')"
                                class="bg-blue-600 hover:bg-blue-700 rounded-lg px-5 py-2.5 text-sm font-medium text-white dark:bg-blue-600 dark:hover:bg-blue-700 transition">
                                <i class="fas fa-magic mr-2"></i>Generate Jadwal
                            </button>
                        </form>
                        @endif

                        @if($schedules && $schedules->count() > 0)
                            @if (auth()->user()->hasPermission('edit-schedules') || auth()->user()->hasPermission('manage-schedules'))
                            <button type="button" id="toggleEditMode"
                                class="rounded-lg border border-blue-300 bg-white px-5 py-2.5 text-sm font-medium text-blue-700 transition hover:bg-blue-50 dark:border-blue-700 dark:bg-gray-800 dark:text-blue-400">
                                <i class="fas fa-edit mr-2"></i>Mode Edit
                            </button>
                            @endif

                            @if (auth()->user()->hasPermission('delete-schedules') || auth()->user()->hasPermission('manage-schedules'))
                            <form action="{{ route('schedules.destroy') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="kelas_id" value="{{ $selectedKelasId }}">
                                <input type="hidden" name="tahun_ajaran_id" value="{{ $selectedTahunAjaran }}">
                                <button type="submit"
                                    onclick="return confirm('Yakin ingin menghapus semua jadwal kelas ini?')"
                                    class="rounded-lg border border-red-300 bg-white px-5 py-2.5 text-sm font-medium text-red-700 transition hover:bg-red-50 dark:border-red-700 dark:bg-gray-800 dark:text-red-400">
                                    <i class="fas fa-trash mr-2"></i>Hapus Jadwal
                                </button>
                            </form>
                            @endif
                        @endif
                    </div>
                @endif
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

            @if($selectedKelasId && $timeSlotsByDay)
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-sm shadow-sm">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                            <th class="border border-gray-300 px-4 py-3 text-left font-semibold text-gray-700 dark:border-gray-700 dark:text-gray-300">Waktu</th>
                            @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat'] as $day)
                                <th class="border border-gray-300 px-4 py-3 text-center font-semibold text-gray-700 dark:border-gray-700 dark:text-gray-300">
                                    {{ ucfirst($day) }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                            @php
                                $maxSlots = $timeSlotsByDay->max(function($slots) {
                                    return $slots->count();
                                });
                            @endphp

                            @for($i = 0; $i < $maxSlots; $i++)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                    <td class="border border-gray-300 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-700 dark:border-gray-700 dark:bg-gray-800/50 dark:text-gray-300">
                                        @if(isset($timeSlotsByDay['senin'][$i]))
                                            {{ $timeSlotsByDay['senin'][$i]->start_time }} - {{ $timeSlotsByDay['senin'][$i]->end_time }}
                                        @endif
                                    </td>
                                    @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat'] as $day)
                                        <td class="border border-gray-300 px-4 py-3 dark:border-gray-700">
                                            @if(isset($timeSlotsByDay[$day][$i]))
                                                @php
                                                    $slot = $timeSlotsByDay[$day][$i];
                                                    $schedule = $schedules ? $schedules->get($slot->id) : null;
                                                @endphp

                                                @if($slot->type === 'ceremony')
                                                    <div class="rounded-lg bg-gradient-to-br from-purple-100 to-purple-200 p-3 text-center shadow-sm dark:from-purple-900/30 dark:to-purple-800/20">
                                                        <i class="fas fa-flag text-purple-600 dark:text-purple-400"></i>
                                                        <div class="mt-1 text-sm font-semibold text-purple-800 dark:text-purple-300">Upacara</div>
                                                    </div>
                                                @elseif($slot->type === 'break')
                                                    <div class="rounded-lg bg-gradient-to-br from-yellow-100 to-amber-200 p-3 text-center shadow-sm dark:from-yellow-900/30 dark:to-amber-800/20">
                                                        <i class="fas fa-coffee text-amber-600 dark:text-amber-400"></i>
                                                        <div class="mt-1 text-sm font-semibold text-amber-800 dark:text-amber-300">Istirahat</div>
                                                    </div>
                                                @elseif($schedule)
                                                    <div class="schedule-cell rounded-lg bg-gradient-to-br from-blue-100 to-blue-200 p-3 shadow-sm transition-all dark:from-blue-900/30 dark:to-blue-800/20"
                                                         data-schedule-id="{{ $schedule->id }}"
                                                         data-slot-id="{{ $slot->id }}"
                                                         data-has-schedule="true">
                                                        <div class="font-bold text-blue-900 dark:text-blue-300">
                                                            {{ $schedule->mataPelajaran->nama }}
                                                        </div>
                                                        <div class="mt-1 flex items-center text-xs text-blue-700 dark:text-blue-400">
                                                            <i class="fas fa-user-tie mr-1"></i>
                                                            {{ $schedule->guru->name }}
                                                        </div>
                                                        <div class="edit-actions mt-2 hidden">
                                                            <a href="{{ route('schedules.edit', $schedule->id) }}"
                                                               class="inline-block rounded-md bg-white px-3 py-1.5 text-xs font-medium text-blue-700 shadow-sm hover:bg-blue-50 dark:bg-blue-900/50 dark:text-blue-300 dark:hover:bg-blue-800/50">
                                                                <i class="fas fa-edit mr-1"></i> Edit
                                                            </a>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="schedule-cell empty-slot rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 p-3 text-center transition-all dark:border-gray-600 dark:bg-gray-800/30"
                                                         data-schedule-id=""
                                                         data-slot-id="{{ $slot->id }}"
                                                         data-has-schedule="false">
                                                        <div class="empty-indicator hidden">
                                                            <div class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                                                                <i class="fas fa-plus-circle mr-1"></i>Kosong
                                                            </div>
                                                            @if (auth()->user()->hasPermission('create-schedules') || auth()->user()->hasPermission('manage-schedules'))
                                                            <a href="{{ route('schedules.create', ['kelas_id' => $selectedKelasId, 'slot_id' => $slot->id]) }}"
                                                               class="inline-block rounded-md bg-blue-600 px-3 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-700">
                                                                <i class="fas fa-plus mr-1"></i>Tambah
                                                            </a>
                                                            @endif
                                                        </div>
                                                        <div class="normal-indicator text-gray-400 dark:text-gray-600">-</div>
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>

                @if(!$schedules || $schedules->count() === 0)
                    <div class="mt-6 text-center">
                        <i class="fas fa-calendar-times mb-3 text-4xl text-gray-400 dark:text-gray-600"></i>
                        <p class="text-gray-700 dark:text-gray-400">Belum ada jadwal. Klik "Generate Jadwal" untuk membuat jadwal otomatis.</p>
                    </div>
                @endif
            @elseif(!$selectedKelasId)
                <div class="text-center">
                    <i class="fas fa-hand-pointer mb-3 text-4xl text-gray-400 dark:text-gray-600"></i>
                    <p class="text-gray-700 dark:text-gray-400">Pilih kelas terlebih dahulu untuk melihat jadwal.</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let editMode = false;
    let selectedSchedule = null;
    const toggleBtn = document.getElementById('toggleEditMode');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            editMode = !editMode;
            const scheduleCells = document.querySelectorAll('.schedule-cell');

            console.log('Edit mode:', editMode);
            console.log('Found cells:', scheduleCells.length);

            if (editMode) {
                toggleBtn.classList.add('bg-blue-600', 'text-white');
                toggleBtn.classList.remove('bg-white', 'text-blue-700', 'border-blue-300');
                toggleBtn.innerHTML = '<i class="fas fa-times mr-2"></i>Keluar Mode Edit';

                scheduleCells.forEach(cell => {
                    cell.classList.add('cursor-pointer', 'hover:ring-2', 'hover:ring-blue-500', 'transition');
                    const editActions = cell.querySelector('.edit-actions');
                    if (editActions) {
                        editActions.classList.remove('hidden');
                    }

                    const emptyIndicator = cell.querySelector('.empty-indicator');
                    const normalIndicator = cell.querySelector('.normal-indicator');
                    if (emptyIndicator && normalIndicator) {
                        emptyIndicator.classList.remove('hidden');
                        normalIndicator.classList.add('hidden');
                    }
                });

                showNotification('Mode Edit Aktif - Klik jadwal, lalu klik slot tujuan (bisa kosong atau isi)');
            } else {
                toggleBtn.classList.remove('bg-blue-600', 'text-white');
                toggleBtn.classList.add('bg-white', 'text-blue-700', 'border-blue-300');
                toggleBtn.innerHTML = '<i class="fas fa-edit mr-2"></i>Mode Edit';

                scheduleCells.forEach(cell => {
                    cell.classList.remove('cursor-pointer', 'hover:ring-2', 'hover:ring-blue-500', 'ring-4', 'ring-green-500');
                    const editActions = cell.querySelector('.edit-actions');
                    if (editActions) {
                        editActions.classList.add('hidden');
                    }

                    const emptyIndicator = cell.querySelector('.empty-indicator');
                    const normalIndicator = cell.querySelector('.normal-indicator');
                    if (emptyIndicator && normalIndicator) {
                        emptyIndicator.classList.add('hidden');
                        normalIndicator.classList.remove('hidden');
                    }
                });

                selectedSchedule = null;
            }
        });

        document.addEventListener('click', function(e) {
            const cell = e.target.closest('.schedule-cell');

            if (!cell || !editMode) return;

            if (e.target.closest('.edit-actions') || e.target.closest('.empty-indicator a')) return;

            const scheduleId = cell.dataset.scheduleId;
            const slotId = cell.dataset.slotId;
            const hasSchedule = cell.dataset.hasSchedule === 'true';

            console.log('Clicked cell - Schedule ID:', scheduleId, 'Slot ID:', slotId, 'Has Schedule:', hasSchedule);

            if (!selectedSchedule) {
                if (!hasSchedule) {
                    showNotification('Pilih jadwal yang berisi terlebih dahulu!');
                    return;
                }

                selectedSchedule = {
                    id: scheduleId,
                    slotId: slotId,
                    element: cell
                };
                cell.classList.add('ring-4', 'ring-green-500');
                showNotification('Jadwal dipilih! Klik slot tujuan (kosong/isi) untuk memindahkan');
            } else {
                if (selectedSchedule.slotId === slotId) {
                    selectedSchedule.element.classList.remove('ring-4', 'ring-green-500');
                    selectedSchedule = null;
                    showNotification('Pilihan dibatalkan');
                    return;
                }

                const action = hasSchedule ? 'menukar' : 'memindahkan ke slot kosong';

                if (confirm(`Yakin ${action}?`)) {
                    if (hasSchedule && scheduleId) {
                        swapSchedules(selectedSchedule.id, scheduleId);
                    } else {
                        moveToSlot(selectedSchedule.id, slotId);
                    }
                } else {
                    selectedSchedule.element.classList.remove('ring-4', 'ring-green-500');
                    selectedSchedule = null;
                }
            }
        });
    }

    function swapSchedules(id1, id2) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("schedules.swap") }}';

        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';

        const schedule1 = document.createElement('input');
        schedule1.type = 'hidden';
        schedule1.name = 'schedule1_id';
        schedule1.value = id1;

        const schedule2 = document.createElement('input');
        schedule2.type = 'hidden';
        schedule2.name = 'schedule2_id';
        schedule2.value = id2;

        const kelasId = document.createElement('input');
        kelasId.type = 'hidden';
        kelasId.name = 'kelas_id';
        kelasId.value = '{{ $selectedKelasId }}';

        form.appendChild(csrf);
        form.appendChild(schedule1);
        form.appendChild(schedule2);
        form.appendChild(kelasId);

        document.body.appendChild(form);
        form.submit();
    }

    function moveToSlot(scheduleId, targetSlotId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("schedules.move") }}';

        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';

        const schedule = document.createElement('input');
        schedule.type = 'hidden';
        schedule.name = 'schedule_id';
        schedule.value = scheduleId;

        const targetSlot = document.createElement('input');
        targetSlot.type = 'hidden';
        targetSlot.name = 'target_slot_id';
        targetSlot.value = targetSlotId;

        const kelasId = document.createElement('input');
        kelasId.type = 'hidden';
        kelasId.name = 'kelas_id';
        kelasId.value = '{{ $selectedKelasId }}';

        form.appendChild(csrf);
        form.appendChild(schedule);
        form.appendChild(targetSlot);
        form.appendChild(kelasId);

        document.body.appendChild(form);
        form.submit();
    }

    function showNotification(message) {
        const existing = document.querySelector('.schedule-notification');
        if (existing) {
            existing.remove();
        }

        const notification = document.createElement('div');
        notification.className = 'schedule-notification fixed top-4 right-4 z-50 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-5 py-3 text-white shadow-2xl animate-fade-in';
        notification.innerHTML = `
            <div class="flex items-center gap-2">
                <i class="fas fa-info-circle"></i>
                <span class="font-medium">${message}</span>
            </div>
        `;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateY(-20px)';
            notification.style.transition = 'all 0.3s ease-out';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
});
</script>
@endpush
