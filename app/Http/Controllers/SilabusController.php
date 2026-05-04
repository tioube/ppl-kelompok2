<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\Silabus;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class SilabusController extends Controller
{
    public function index(Request $request)
    {
        $tahunAjaranAktif = TahunAjaran::getAktif();
        $selectedTahunAjaran = $request->input('tahun_ajaran_id', $tahunAjaranAktif?->id);

        $query = Silabus::with(['mataPelajaran', 'tahunAjaran', 'createdBy', 'approvedBy']);

        if ($selectedTahunAjaran) {
            $query->where('tahun_ajaran_id', $selectedTahunAjaran);
        }

        if (auth()->user()->hasRole('guru')) {
            $query->where('created_by', auth()->id());
        } elseif (! auth()->user()->hasRole(['super-admin', 'akademik'])) {
            $query->approved()->active();
        }

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('tujuan_pembelajaran', 'like', "%{$search}%")
                    ->orWhereHas('mataPelajaran', function ($q2) use ($search) {
                        $q2->where('nama', 'like', "%{$search}%")
                            ->orWhere('kode', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->mata_pelajaran_id) {
            $query->where('mata_pelajaran_id', $request->mata_pelajaran_id);
        }

        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->approval_status) {
            $query->where('approval_status', $request->approval_status);
        }

        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $allowedSorts = ['urutan', 'kategori', 'status', 'approval_status', 'created_at'];

        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDirection);
        } else {
            $query->orderBy('urutan')->orderBy('created_at', 'desc');
        }

        $silabus = $query->paginate(15)->withQueryString();
        $mataPelajaran = MataPelajaran::orderBy('nama')->get();
        $tahunAjaranList = TahunAjaran::orderBy('tahun', 'desc')->get();

        $baseStatsQuery = Silabus::query();
        if ($selectedTahunAjaran) {
            $baseStatsQuery->where('tahun_ajaran_id', $selectedTahunAjaran);
        }
        if (auth()->user()->hasRole('guru')) {
            $baseStatsQuery->where('created_by', auth()->id());
        } elseif (! auth()->user()->hasRole(['super-admin', 'akademik'])) {
            $baseStatsQuery->approved()->active();
        }

        $stats = [
            'total' => $baseStatsQuery->count(),
            'draft' => (clone $baseStatsQuery)->where('approval_status', 'draft')->count(),
            'pending' => (clone $baseStatsQuery)->where('approval_status', 'pending_approval')->count(),
            'approved' => (clone $baseStatsQuery)->where('approval_status', 'approved')->count(),
            'rejected' => (clone $baseStatsQuery)->where('approval_status', 'rejected')->count(),
            'formatif' => (clone $baseStatsQuery)->where('kategori', 'formatif')->count(),
            'sumatif' => (clone $baseStatsQuery)->where('kategori', 'sumatif')->count(),
            'aktif' => (clone $baseStatsQuery)->where('status', 'aktif')->count(),
        ];

        return view('silabus.index', compact('silabus', 'mataPelajaran', 'tahunAjaranList', 'selectedTahunAjaran', 'stats'));
    }

    public function create(Request $request)
    {
        $mataPelajaran = MataPelajaran::orderBy('nama')->get();
        $tahunAjaranList = TahunAjaran::orderBy('tahun', 'desc')->get();
        $tahunAjaranAktif = TahunAjaran::getAktif();
        $selectedMataPelajaranId = $request->mata_pelajaran_id;

        return view('silabus.create', compact('mataPelajaran', 'tahunAjaranList', 'tahunAjaranAktif', 'selectedMataPelajaranId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'tujuan_pembelajaran' => 'required|string|min:10',
            'kategori' => 'required|in:formatif,sumatif',
            'urutan' => 'nullable|integer|min:0',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['updated_by'] = auth()->id();
        $validated['status'] = 'pending';
        $validated['approval_status'] = 'draft';

        $silabus = Silabus::create($validated);

        return redirect()->route('silabus.index')
            ->with('success', 'Silabus berhasil dibuat. Status: Draft');
    }

    public function show(Silabus $silabus)
    {
        $silabus->load(['mataPelajaran', 'tahunAjaran', 'createdBy', 'approvedBy']);

        return view('silabus.show', compact('silabus'));
    }

    public function edit(Silabus $silabus)
    {
        if (! $silabus->canBeEdited()) {
            return redirect()->route('silabus.index')
                ->with('error', 'Silabus yang sudah disetujui tidak dapat diedit.');
        }

        $mataPelajaran = MataPelajaran::orderBy('nama')->get();
        $tahunAjaranList = TahunAjaran::orderBy('tahun', 'desc')->get();

        return view('silabus.edit', compact('silabus', 'mataPelajaran', 'tahunAjaranList'));
    }

    public function update(Request $request, Silabus $silabus)
    {
        if (! $silabus->canBeEdited()) {
            return redirect()->route('silabus.index')
                ->with('error', 'Silabus yang sudah disetujui tidak dapat diedit.');
        }

        $validated = $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'tujuan_pembelajaran' => 'required|string|min:10',
            'kategori' => 'required|in:formatif,sumatif',
            'urutan' => 'nullable|integer|min:0',
        ]);

        $validated['updated_by'] = auth()->id();

        // Reset approval if content changed
        if ($silabus->approval_status === 'rejected') {
            $validated['approval_status'] = 'draft';
            $validated['rejection_reason'] = null;
        }

        $silabus->update($validated);

        return redirect()->route('silabus.index')
            ->with('success', 'Silabus berhasil diperbarui.');
    }

    public function destroy(Silabus $silabus)
    {
        if (! $silabus->canBeDeleted()) {
            return redirect()->route('silabus.index')
                ->with('error', 'Silabus yang sudah aktif tidak dapat dihapus.');
        }

        $silabus->delete();

        return redirect()->route('silabus.index')
            ->with('success', 'Silabus berhasil dihapus.');
    }

    public function submitForApproval(Silabus $silabus)
    {

        if ($silabus->approval_status !== 'draft') {
            return back()->with('error', 'Hanya silabus dengan status draft yang bisa diajukan.');
        }

        $silabus->update([
            'approval_status' => 'pending_approval',
        ]);

        return back()->with('success', 'Silabus berhasil diajukan untuk persetujuan.');
    }

    public function approve(Silabus $silabus)
    {
        $silabus->update([
            'approval_status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => null,
        ]);

        return back()->with('success', 'Silabus berhasil disetujui.');
    }

    public function reject(Request $request, Silabus $silabus)
    {

        $request->validate([
            'rejection_reason' => 'required|string|min:10',
        ]);

        $silabus->update([
            'approval_status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'status' => 'non_aktif',
        ]);

        return back()->with('success', 'Silabus berhasil ditolak.');
    }

    public function toggleStatus(Silabus $silabus)
    {

        if ($silabus->approval_status !== 'approved') {
            return back()->with('error', 'Hanya silabus yang sudah disetujui yang bisa diaktifkan/nonaktifkan.');
        }

        $newStatus = $silabus->status === 'aktif' ? 'non_aktif' : 'aktif';

        $silabus->update(['status' => $newStatus]);

        $statusText = $newStatus === 'aktif' ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Silabus berhasil {$statusText}.");
    }
}
