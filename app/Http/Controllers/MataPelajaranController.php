<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $query = MataPelajaran::query();

        // Search functionality
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Filter by kategori
        if ($kategori = $request->get('kategori')) {
            $query->where('kategori', $kategori);
        }

        // Filter by jam_pelajaran range
        if ($minJam = $request->get('min_jam')) {
            $query->where('jam_pelajaran', '>=', $minJam);
        }
        if ($maxJam = $request->get('max_jam')) {
            $query->where('jam_pelajaran', '<=', $maxJam);
        }

        // Sorting
        $sortBy = $request->get('sort', 'kategori');
        $sortDirection = $request->get('direction', 'asc');

        $allowedSorts = ['kode', 'nama', 'kategori', 'jam_pelajaran'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDirection);
        }

        // Secondary sort
        if ($sortBy !== 'nama') {
            $query->orderBy('nama');
        }

        $mataPelajaran = $query->paginate(15)->withQueryString();

        // Get statistics for filters
        $stats = [
            'total' => MataPelajaran::count(),
            'wajib' => MataPelajaran::where('kategori', 'Wajib')->count(),
            'peminatan' => MataPelajaran::where('kategori', 'Peminatan')->count(),
            'lintas_minat' => MataPelajaran::where('kategori', 'Lintas Minat')->count(),
        ];

        return view('pages.mata-pelajaran.index', [
            'title' => 'List Mata Pelajaran',
            'mataPelajaran' => $mataPelajaran,
            'stats' => $stats,
            'filters' => $request->only(['search', 'kategori', 'min_jam', 'max_jam', 'sort', 'direction']),
        ]);
    }

    public function create()
    {
        return view('pages.mata-pelajaran.create', ['title' => 'Tambah Mata Pelajaran']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:20|unique:mata_pelajaran,kode',
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:Wajib,Peminatan,Lintas Minat',
            'jam_pelajaran' => 'required|integer|min:1|max:20',
            'preferred_block' => 'required|integer|min:1|max:3',
            'max_per_day' => 'required|integer|min:1|max:5',
            'deskripsi' => 'nullable|string',
        ]);

        MataPelajaran::create($validated);

        return redirect()->route('mata-pelajaran.index')
            ->with('success', 'Mata Pelajaran berhasil ditambahkan.');
    }

    public function edit(MataPelajaran $mataPelajaran)
    {
        return view('pages.mata-pelajaran.edit', [
            'title' => 'Edit Mata Pelajaran',
            'mataPelajaran' => $mataPelajaran,
        ]);
    }

    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:20|unique:mata_pelajaran,kode,'.$mataPelajaran->id,
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:Wajib,Peminatan,Lintas Minat',
            'jam_pelajaran' => 'required|integer|min:1|max:20',
            'preferred_block' => 'required|integer|min:1|max:3',
            'max_per_day' => 'required|integer|min:1|max:5',
            'deskripsi' => 'nullable|string',
        ]);

        $mataPelajaran->update($validated);

        return redirect()->route('mata-pelajaran.index')
            ->with('success', 'Mata Pelajaran berhasil diperbarui.');
    }

    public function destroy(MataPelajaran $mataPelajaran)
    {
        $mataPelajaran->delete();

        return redirect()->route('mata-pelajaran.index')
            ->with('success', 'Mata Pelajaran berhasil dihapus.');
    }
}
