<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\MataPelajaranTahunAjaran;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MataPelajaranTahunAjaranController extends Controller
{
    public function index(Request $request)
    {
        if (! auth()->user()->hasPermission('manage-mata-pelajaran')) {
            abort(403, 'You do not have permission to manage subject mappings.');
        }

        $tahunAjaranAktif = TahunAjaran::getAktif();
        $selectedTahunAjaran = $request->input('tahun_ajaran_id', $tahunAjaranAktif?->id);

        $tahunAjaranList = TahunAjaran::orderBy('tahun', 'desc')->get();
        $allMataPelajaran = MataPelajaran::orderBy('kategori')->orderBy('nama')->get();

        $mappedMapelIds = [];
        if ($selectedTahunAjaran) {
            $mappedMapelIds = MataPelajaranTahunAjaran::where('tahun_ajaran_id', $selectedTahunAjaran)
                ->where('is_active', true)
                ->pluck('mata_pelajaran_id')
                ->toArray();
        }

        $mappings = MataPelajaranTahunAjaran::with(['mataPelajaran', 'tahunAjaran'])
            ->when($selectedTahunAjaran, fn ($q) => $q->where('tahun_ajaran_id', $selectedTahunAjaran))
            ->orderBy('is_active', 'desc')
            ->get();

        $stats = [
            'total' => $allMataPelajaran->count(),
            'active' => count($mappedMapelIds),
            'inactive' => $allMataPelajaran->count() - count($mappedMapelIds),
        ];

        return view('pages.mata-pelajaran-tahun-ajaran.index', [
            'title' => 'Mapping Mata Pelajaran per Tahun Ajaran',
            'tahunAjaranList' => $tahunAjaranList,
            'selectedTahunAjaran' => $selectedTahunAjaran,
            'allMataPelajaran' => $allMataPelajaran,
            'mappedMapelIds' => $mappedMapelIds,
            'mappings' => $mappings,
            'stats' => $stats,
        ]);
    }

    public function store(Request $request)
    {
        if (! auth()->user()->hasPermission('manage-mata-pelajaran')) {
            abort(403, 'You do not have permission to manage subject mappings.');
        }

        $validated = $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'mata_pelajaran_ids' => 'nullable|array',
            'mata_pelajaran_ids.*' => 'exists:mata_pelajaran,id',
        ]);

        $tahunAjaranId = $validated['tahun_ajaran_id'];
        $selectedMapelIds = $validated['mata_pelajaran_ids'] ?? [];

        DB::beginTransaction();

        try {
            MataPelajaranTahunAjaran::where('tahun_ajaran_id', $tahunAjaranId)
                ->whereNotIn('mata_pelajaran_id', $selectedMapelIds)
                ->update(['is_active' => false]);

            foreach ($selectedMapelIds as $mapelId) {
                MataPelajaranTahunAjaran::updateOrCreate(
                    [
                        'tahun_ajaran_id' => $tahunAjaranId,
                        'mata_pelajaran_id' => $mapelId,
                    ],
                    [
                        'is_active' => true,
                    ]
                );
            }

            DB::commit();

            return redirect()->route('mata-pelajaran-tahun-ajaran.index', ['tahun_ajaran_id' => $tahunAjaranId])
                ->with('success', 'Mapping mata pelajaran berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Gagal memperbarui mapping: '.$e->getMessage());
        }
    }

    public function copyFromPrevious(Request $request)
    {
        if (! auth()->user()->hasPermission('manage-mata-pelajaran')) {
            abort(403, 'You do not have permission to manage subject mappings.');
        }

        $validated = $request->validate([
            'source_tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'target_tahun_ajaran_id' => 'required|exists:tahun_ajaran,id|different:source_tahun_ajaran_id',
        ]);

        DB::beginTransaction();

        try {
            $sourceMappings = MataPelajaranTahunAjaran::where('tahun_ajaran_id', $validated['source_tahun_ajaran_id'])
                ->where('is_active', true)
                ->get();

            $copied = 0;
            foreach ($sourceMappings as $mapping) {
                $exists = MataPelajaranTahunAjaran::where('tahun_ajaran_id', $validated['target_tahun_ajaran_id'])
                    ->where('mata_pelajaran_id', $mapping->mata_pelajaran_id)
                    ->exists();

                if (! $exists) {
                    MataPelajaranTahunAjaran::create([
                        'tahun_ajaran_id' => $validated['target_tahun_ajaran_id'],
                        'mata_pelajaran_id' => $mapping->mata_pelajaran_id,
                        'is_active' => true,
                        'jam_pelajaran_override' => $mapping->jam_pelajaran_override,
                        'catatan' => $mapping->catatan,
                    ]);
                    $copied++;
                }
            }

            DB::commit();

            return redirect()->route('mata-pelajaran-tahun-ajaran.index', ['tahun_ajaran_id' => $validated['target_tahun_ajaran_id']])
                ->with('success', "Berhasil menyalin {$copied} mapping mata pelajaran dari tahun ajaran sebelumnya.");

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Gagal menyalin mapping: '.$e->getMessage());
        }
    }

    public function toggle(Request $request, MataPelajaranTahunAjaran $mapping)
    {
        if (! auth()->user()->hasPermission('manage-mata-pelajaran')) {
            abort(403, 'You do not have permission to manage subject mappings.');
        }

        $mapping->update(['is_active' => ! $mapping->is_active]);

        $status = $mapping->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()
            ->with('success', "Mata pelajaran berhasil {$status} untuk tahun ajaran ini.");
    }
}
