<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use App\Models\PengumpulanTugas;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiswaTugasController extends Controller
{
    public function index(): View
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $tugas = Tugas::with(['mataPelajaran', 'guru'])
            ->where('kelas_id', $user->kelas_id)
            ->orderBy('deadline', 'asc')
            ->get();

        $tugasAktif = $tugas->filter(fn($t) => $t->deadline->isFuture());
        $tugasLewat = $tugas->filter(fn($t) => $t->deadline->isPast());

        return view('pages.siswa.tugas', [
            'title'      => 'Tugas',
            'tugasAktif' => $tugasAktif,
            'tugasLewat' => $tugasLewat,
            'user'       => $user,
        ]);
    }

    public function upload(Request $request, Tugas $tugas)
    {
        $request->validate([
            'file_jawaban' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'catatan'      => 'nullable|string|max:500',
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();

        $path = $request->file('file_jawaban')->store('pengumpulan_tugas/' . $user->id, 'public');

        PengumpulanTugas::updateOrCreate(
            ['tugas_id' => $tugas->id, 'siswa_id' => $user->id],
            [
                'file_jawaban'    => $path,
                'catatan'         => $request->catatan,
                'dikumpulkan_at'  => now(),
            ]
        );

        return back()->with('success', 'Tugas berhasil dikumpulkan!');
    }
}
