<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mataPelajaran = MataPelajaran::orderBy('kategori')->orderBy('nama')->paginate(15);

        return view('pages.mata-pelajaran.index', [
            'title' => 'List Mata Pelajaran',
            'mataPelajaran' => $mataPelajaran,
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
