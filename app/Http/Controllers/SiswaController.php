<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Role;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index()
    {
        if (! auth()->user()->hasPermission('manage-siswa') && ! auth()->user()->hasPermission('view-siswa')) {
            abort(403, 'You do not have permission to view students.');
        }

        $siswas = User::whereHas('roles', function ($query) {
            $query->where('slug', 'siswa');
        })
            ->with(['roles', 'kelas', 'jurusan', 'tahunAjaran'])
            ->latest()
            ->paginate(15);

        return view('pages.siswa.index', [
            'title' => 'List Siswa',
            'siswas' => $siswas,
        ]);
    }

    public function create()
    {
        if (! auth()->user()->hasPermission('manage-siswa') && ! auth()->user()->hasPermission('create-siswa')) {
            abort(403, 'You do not have permission to create students.');
        }

        $kelasList = Kelas::all();
        $jurusanList = Jurusan::all();
        $tahunAjaranList = TahunAjaran::all();

        return view('pages.siswa.create', [
            'title' => 'Tambah Siswa',
            'kelasList' => $kelasList,
            'jurusanList' => $jurusanList,
            'tahunAjaranList' => $tahunAjaranList,
        ]);
    }

    public function store(Request $request)
    {
        if (! auth()->user()->hasPermission('manage-siswa') && ! auth()->user()->hasPermission('create-siswa')) {
            abort(403, 'You do not have permission to create students.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'nisn' => 'nullable|string|unique:users,nisn',
            'kelas_id' => 'nullable|exists:kelas,id',
            'jurusan_id' => 'nullable|exists:jurusan,id',
            'tahun_ajaran_id' => 'nullable|exists:tahun_ajaran,id',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'birth_date' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        if ($request->hasFile('photo_profile')) {
            $validated['photo_profile'] = $request->file('photo_profile')->store('photos/students', 'public');
        }

        $user = User::create($validated);

        $siswaRole = Role::where('slug', 'siswa')->first();
        if ($siswaRole) {
            $user->roles()->attach($siswaRole->id);
        }

        return redirect()->route('siswa.index')
            ->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function show(User $siswa)
    {
        if (! auth()->user()->hasPermission('manage-siswa') && ! auth()->user()->hasPermission('view-siswa')) {
            abort(403, 'You do not have permission to view students.');
        }

        $siswa->load(['roles', 'kelas', 'jurusan', 'tahunAjaran']);

        return view('pages.siswa.show', [
            'title' => 'Detail Siswa',
            'siswa' => $siswa,
        ]);
    }

    public function edit(User $siswa)
    {
        if (! auth()->user()->hasPermission('manage-siswa') && ! auth()->user()->hasPermission('edit-siswa')) {
            abort(403, 'You do not have permission to edit students.');
        }

        $kelasList = Kelas::all();
        $jurusanList = Jurusan::all();
        $tahunAjaranList = TahunAjaran::all();

        return view('pages.siswa.edit', [
            'title' => 'Edit Siswa',
            'siswa' => $siswa,
            'kelasList' => $kelasList,
            'jurusanList' => $jurusanList,
            'tahunAjaranList' => $tahunAjaranList,
        ]);
    }

    public function update(Request $request, User $siswa)
    {
        if (! auth()->user()->hasPermission('manage-siswa') && ! auth()->user()->hasPermission('edit-siswa')) {
            abort(403, 'You do not have permission to edit students.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$siswa->id,
            'password' => 'nullable|string|min:8',
            'nisn' => 'nullable|string|unique:users,nisn,'.$siswa->id,
            'kelas_id' => 'nullable|exists:kelas,id',
            'jurusan_id' => 'nullable|exists:jurusan,id',
            'tahun_ajaran_id' => 'nullable|exists:tahun_ajaran,id',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'birth_date' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        if ($request->hasFile('photo_profile')) {
            if ($siswa->photo_profile) {
                Storage::disk('public')->delete($siswa->photo_profile);
            }
            $validated['photo_profile'] = $request->file('photo_profile')->store('photos/students', 'public');
        }

        $siswa->update($validated);

        return redirect()->route('siswa.index')
            ->with('success', 'Siswa berhasil diperbarui.');
    }

    public function destroy(User $siswa)
    {
        if (! auth()->user()->hasPermission('manage-siswa') && ! auth()->user()->hasPermission('delete-siswa')) {
            abort(403, 'You do not have permission to delete students.');
        }

        if ($siswa->photo_profile) {
            Storage::disk('public')->delete($siswa->photo_profile);
        }

        $siswa->delete();

        return redirect()->route('siswa.index')
            ->with('success', 'Siswa berhasil dihapus.');
    }
}
