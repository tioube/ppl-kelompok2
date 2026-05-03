{{-- Approval Status Badge --}}
<div class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-xs font-medium
    @if($approvalStatus === 'draft')
        bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
    @elseif($approvalStatus === 'pending_approval')
        bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
    @elseif($approvalStatus === 'approved')
        bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
    @elseif($approvalStatus === 'rejected')
        bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
    @endif">
    <span class="mr-1">
        @if($approvalStatus === 'draft') 📝
        @elseif($approvalStatus === 'pending_approval') ⏳
        @elseif($approvalStatus === 'approved') ✅
        @elseif($approvalStatus === 'rejected') ❌
        @endif
    </span>
    @if($approvalStatus === 'draft') Draft
    @elseif($approvalStatus === 'pending_approval') Menunggu
    @elseif($approvalStatus === 'approved') Disetujui
    @elseif($approvalStatus === 'rejected') Ditolak
    @endif
</div>

{{-- Active Status Badge (only if approved) --}}
@if($approvalStatus === 'approved')
    <div class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-xs font-medium
        {{ $status === 'aktif' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
        <span class="mr-1">{{ $status === 'aktif' ? '🟢' : '🔘' }}</span>
        {{ $status === 'aktif' ? 'Aktif' : 'Non-aktif' }}
    </div>
@endif

{{-- Category Badge --}}
<div class="inline-flex items-center rounded-lg px-2.5 py-1.5 text-xs font-medium
    {{ $kategori === 'formatif' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' }}">
    <span class="mr-1">{{ $kategori === 'formatif' ? '📝' : '📊' }}</span>
    {{ ucfirst($kategori) }}
</div>
