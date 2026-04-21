<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $tahunAjarans = TahunAjaran::latest()->paginate(10);

        return view('akademik.tahun-ajaran.index', compact('tahunAjarans'));
    }

    public function create()
    {
        return view('akademik.tahun-ajaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|string|max:255|unique:tahun_ajaran,tahun',
            'is_active' => 'boolean',
        ]);

        if (! empty($validated['is_active'])) {
            TahunAjaran::where('is_active', true)->update(['is_active' => false]);
        }

        TahunAjaran::create($validated);

        return redirect()->route('tahun-ajaran.index')
            ->with('success', 'Tahun Ajaran berhasil ditambahkan.');
    }

    public function edit(TahunAjaran $tahunAjaran)
    {
        return view('akademik.tahun-ajaran.edit', compact('tahunAjaran'));
    }

    public function update(Request $request, TahunAjaran $tahunAjaran)
    {
        $validated = $request->validate([
            'tahun' => 'required|string|max:255|unique:tahun_ajaran,tahun,'.$tahunAjaran->id,
            'is_active' => 'boolean',
        ]);

        if (! empty($validated['is_active'])) {
            TahunAjaran::where('is_active', true)
                ->where('id', '!=', $tahunAjaran->id)
                ->update(['is_active' => false]);
        }

        $tahunAjaran->update($validated);

        return redirect()->route('tahun-ajaran.index')
            ->with('success', 'Tahun Ajaran berhasil diperbarui.');
    }

    public function destroy(TahunAjaran $tahunAjaran)
    {
        $tahunAjaran->delete();

        return redirect()->route('tahun-ajaran.index')
            ->with('success', 'Tahun Ajaran berhasil dihapus.');
    }
}
