<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function index()
    {
        if (! auth()->user()->hasPermission('manage-guru') && ! auth()->user()->hasPermission('view-guru')) {
            abort(403, 'You do not have permission to view teachers.');
        }

        $gurus = User::whereHas('roles', function ($query) {
            $query->where('slug', 'guru');
        })
            ->with(['roles'])
            ->latest()
            ->paginate(15);

        return view('pages.guru.index', [
            'title' => 'List Guru',
            'gurus' => $gurus,
        ]);
    }

    public function create()
    {
        if (! auth()->user()->hasPermission('manage-guru') && ! auth()->user()->hasPermission('create-guru')) {
            abort(403, 'You do not have permission to create teachers.');
        }

        return view('pages.guru.create', [
            'title' => 'Tambah Guru',
        ]);
    }

    public function store(Request $request)
    {
        if (! auth()->user()->hasPermission('manage-guru') && ! auth()->user()->hasPermission('create-guru')) {
            abort(403, 'You do not have permission to create teachers.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'nip' => 'nullable|string|unique:users,nip',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'birth_date' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        if ($request->hasFile('photo_profile')) {
            $validated['photo_profile'] = $request->file('photo_profile')->store('photos/teachers', 'public');
        }

        $user = User::create($validated);

        $guruRole = Role::where('slug', 'guru')->first();
        if ($guruRole) {
            $user->roles()->attach($guruRole->id);
        }

        return redirect()->route('guru.index')
            ->with('success', 'Guru berhasil ditambahkan.');
    }

    public function show(User $guru)
    {
        if (! auth()->user()->hasPermission('manage-guru') && ! auth()->user()->hasPermission('view-guru')) {
            abort(403, 'You do not have permission to view teachers.');
        }

        $guru->load(['roles']);

        return view('pages.guru.show', [
            'title' => 'Detail Guru',
            'guru' => $guru,
        ]);
    }

    public function edit(User $guru)
    {
        if (! auth()->user()->hasPermission('manage-guru') && ! auth()->user()->hasPermission('edit-guru')) {
            abort(403, 'You do not have permission to edit teachers.');
        }

        return view('pages.guru.edit', [
            'title' => 'Edit Guru',
            'guru' => $guru,
        ]);
    }

    public function update(Request $request, User $guru)
    {
        if (! auth()->user()->hasPermission('manage-guru') && ! auth()->user()->hasPermission('edit-guru')) {
            abort(403, 'You do not have permission to edit teachers.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$guru->id,
            'password' => 'nullable|string|min:8',
            'nip' => 'nullable|string|unique:users,nip,'.$guru->id,
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
            if ($guru->photo_profile) {
                Storage::disk('public')->delete($guru->photo_profile);
            }
            $validated['photo_profile'] = $request->file('photo_profile')->store('photos/teachers', 'public');
        }

        $guru->update($validated);

        return redirect()->route('guru.index')
            ->with('success', 'Guru berhasil diperbarui.');
    }

    public function destroy(User $guru)
    {
        if (! auth()->user()->hasPermission('manage-guru') && ! auth()->user()->hasPermission('delete-guru')) {
            abort(403, 'You do not have permission to delete teachers.');
        }

        if ($guru->photo_profile) {
            Storage::disk('public')->delete($guru->photo_profile);
        }

        $guru->delete();

        return redirect()->route('guru.index')
            ->with('success', 'Guru berhasil dihapus.');
    }
}
