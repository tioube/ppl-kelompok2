<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Role;
use App\Models\SiswaTahunAjaran;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        if (! auth()->user()->hasPermission('manage-siswa') && ! auth()->user()->hasPermission('view-siswa')) {
            abort(403, 'You do not have permission to view students.');
        }

        $tahunAjaranAktif = TahunAjaran::getAktif();
        $selectedTahunAjaran = $request->input('tahun_ajaran_id', $tahunAjaranAktif?->id);

        $query = SiswaTahunAjaran::with(['siswa', 'kelas', 'jurusan', 'tahunAjaran']);

        if ($selectedTahunAjaran) {
            $query->where('tahun_ajaran_id', $selectedTahunAjaran);
        }

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('jurusan_id')) {
            $query->where('jurusan_id', $request->jurusan_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $siswas = $query->latest()->paginate(15)->withQueryString();

        $tahunAjaranList = TahunAjaran::orderBy('tahun', 'desc')->get();
        $kelasList = Kelas::orderBy('nama')->get();
        $jurusanList = Jurusan::orderBy('nama')->get();

        return view('pages.siswa.index', [
            'title' => 'List Siswa',
            'siswas' => $siswas,
            'tahunAjaranList' => $tahunAjaranList,
            'kelasList' => $kelasList,
            'jurusanList' => $jurusanList,
            'selectedTahunAjaran' => $selectedTahunAjaran,
        ]);
    }

    public function create()
    {
        if (! auth()->user()->hasPermission('manage-siswa') && ! auth()->user()->hasPermission('create-siswa')) {
            abort(403, 'You do not have permission to create students.');
        }

        $kelasList = Kelas::orderBy('nama')->get();
        $jurusanList = Jurusan::orderBy('nama')->get();
        $tahunAjaranList = TahunAjaran::orderBy('tahun', 'desc')->get();
        $tahunAjaranAktif = TahunAjaran::getAktif();

        return view('pages.siswa.create', [
            'title' => 'Tambah Siswa',
            'kelasList' => $kelasList,
            'jurusanList' => $jurusanList,
            'tahunAjaranList' => $tahunAjaranList,
            'tahunAjaranAktif' => $tahunAjaranAktif,
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
            'password' => 'required|string|min:8|confirmed',
            'nisn' => 'nullable|string|unique:users,nisn',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'birth_date' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'kelas_id' => 'nullable|exists:kelas,id',
            'jurusan_id' => 'nullable|exists:jurusan,id',
            'nomor_induk_sekolah' => 'nullable|string|max:50',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama lengkap tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar, gunakan email lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'nisn.unique' => 'NISN sudah terdaftar, gunakan NISN lain.',
            'gender.in' => 'Jenis kelamin tidak valid.',
            'birth_date.date' => 'Format tanggal lahir tidak valid.',
            'phone.max' => 'Nomor telepon tidak boleh lebih dari 20 karakter.',
            'photo_profile.uploaded' => 'Foto gagal diunggah. Ukuran file melebihi batas maksimal yang diizinkan server.',
            'photo_profile.image' => 'File harus berupa gambar.',
            'photo_profile.mimes' => 'Format foto harus JPG, JPEG, atau PNG.',
            'photo_profile.max' => 'Ukuran foto tidak boleh lebih dari 2MB.',
            'tahun_ajaran_id.required' => 'Tahun ajaran wajib dipilih.',
            'tahun_ajaran_id.exists' => 'Tahun ajaran yang dipilih tidak valid.',
            'kelas_id.exists' => 'Kelas yang dipilih tidak valid.',
            'jurusan_id.exists' => 'Jurusan yang dipilih tidak valid.',
            'nomor_induk_sekolah.max' => 'Nomor induk sekolah tidak boleh lebih dari 50 karakter.',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'nisn' => $validated['nisn'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
        ];

        if ($request->hasFile('photo_profile')) {
            $userData['photo_profile'] = $request->file('photo_profile')->store('photos/students', 'public');
        }

        $user = User::create($userData);

        $siswaRole = Role::where('slug', 'siswa')->first();
        if ($siswaRole) {
            $user->roles()->attach($siswaRole->id);
        }

        SiswaTahunAjaran::create([
            'user_id' => $user->id,
            'tahun_ajaran_id' => $validated['tahun_ajaran_id'],
            'kelas_id' => $validated['kelas_id'] ?? null,
            'jurusan_id' => $validated['jurusan_id'] ?? null,
            'status' => 'aktif',
            'nomor_induk_sekolah' => $validated['nomor_induk_sekolah'] ?? null,
        ]);

        return redirect()->route('siswa.index')
            ->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function show(User $siswa, Request $request)
    {
        if (! auth()->user()->hasPermission('manage-siswa') && ! auth()->user()->hasPermission('view-siswa')) {
            abort(403, 'You do not have permission to view students.');
        }

        $selectedTahunAjaran = $request->input('tahun_ajaran_id');

        $riwayatAkademik = $siswa->siswaTahunAjaran()
            ->with(['tahunAjaran', 'kelas', 'jurusan'])
            ->orderBy('tahun_ajaran_id', 'desc')
            ->get();

        $currentSiswaTahunAjaran = $selectedTahunAjaran
            ? $siswa->getSiswaTahunAjaranFor($selectedTahunAjaran)
            : $siswa->getCurrentSiswaTahunAjaran();

        // Fetch all grades for this student
        $allGrades = Nilai::where('siswa_id', $siswa->id)
            ->with(['guruMapelKelas.mataPelajaran', 'guruMapelKelas.tahunAjaran', 'silabus'])
            ->get();

        // Group grades by tahun_ajaran_id, then by mata_pelajaran_id
        $gradesByYear = [];
        foreach ($allGrades as $grade) {
            if (! $grade->guruMapelKelas) {
                continue;
            }
            $yearId = $grade->guruMapelKelas->tahun_ajaran_id;
            $mapelId = $grade->guruMapelKelas->mata_pelajaran_id;
            $mapelName = $grade->guruMapelKelas->mataPelajaran->nama ?? 'Unknown';
            $kategori = $grade->silabus->kategori ?? 'formatif';

            if (! isset($gradesByYear[$yearId])) {
                $gradesByYear[$yearId] = [];
            }
            if (! isset($gradesByYear[$yearId][$mapelId])) {
                $gradesByYear[$yearId][$mapelId] = [
                    'name' => $mapelName,
                    'formatif_scores' => [],
                    'sumatif_scores' => [],
                ];
            }

            if ($kategori === 'formatif') {
                $gradesByYear[$yearId][$mapelId]['formatif_scores'][] = $grade->nilai;
            } else {
                $gradesByYear[$yearId][$mapelId]['sumatif_scores'][] = $grade->nilai;
            }
        }

        // Calculate averages for each subject in each year
        $raportByYear = [];
        foreach ($gradesByYear as $yearId => $subjects) {
            $subjectReports = [];
            $totalYearScore = 0;
            $subjectCount = 0;

            foreach ($subjects as $mapelId => $data) {
                $avgFormatif = count($data['formatif_scores']) > 0 ? round(array_sum($data['formatif_scores']) / count($data['formatif_scores']), 1) : null;
                $avgSumatif = count($data['sumatif_scores']) > 0 ? round(array_sum($data['sumatif_scores']) / count($data['sumatif_scores']), 1) : null;

                if ($avgFormatif !== null && $avgSumatif !== null) {
                    $finalScore = round(($avgFormatif + $avgSumatif) / 2, 1);
                } else {
                    $finalScore = $avgFormatif ?? $avgSumatif ?? null;
                }

                if ($finalScore !== null) {
                    $totalYearScore += $finalScore;
                    $subjectCount++;
                }

                $subjectReports[] = [
                    'name' => $data['name'],
                    'avg_formatif' => $avgFormatif,
                    'avg_sumatif' => $avgSumatif,
                    'final_score' => $finalScore,
                ];
            }

            // Sort subjects by name
            usort($subjectReports, fn ($a, $b) => strcmp($a['name'], $b['name']));

            $raportByYear[$yearId] = [
                'subjects' => $subjectReports,
                'overall_average' => $subjectCount > 0 ? round($totalYearScore / $subjectCount, 1) : null,
            ];
        }

        return view('pages.siswa.show', [
            'title' => 'Detail Siswa',
            'siswa' => $siswa,
            'riwayatAkademik' => $riwayatAkademik,
            'currentSiswaTahunAjaran' => $currentSiswaTahunAjaran,
            'raportByYear' => $raportByYear,
        ]);
    }

    public function edit(User $siswa)
    {
        if (! auth()->user()->hasPermission('manage-siswa') && ! auth()->user()->hasPermission('edit-siswa')) {
            abort(403, 'You do not have permission to edit students.');
        }

        $kelasList = Kelas::orderBy('nama')->get();
        $jurusanList = Jurusan::orderBy('nama')->get();
        $tahunAjaranList = TahunAjaran::orderBy('tahun', 'desc')->get();
        $tahunAjaranAktif = TahunAjaran::getAktif();

        $riwayatAkademik = $siswa->siswaTahunAjaran()
            ->with(['tahunAjaran', 'kelas', 'jurusan'])
            ->orderBy('tahun_ajaran_id', 'desc')
            ->get();

        $currentSiswaTahunAjaran = $siswa->siswaTahunAjaran()
            ->with(['tahunAjaran', 'kelas', 'jurusan'])
            ->orderBy('tahun_ajaran_id', 'desc')
            ->first();

        return view('pages.siswa.edit', [
            'title' => 'Edit Siswa',
            'siswa' => $siswa,
            'kelasList' => $kelasList,
            'jurusanList' => $jurusanList,
            'tahunAjaranList' => $tahunAjaranList,
            'tahunAjaranAktif' => $tahunAjaranAktif,
            'currentSiswaTahunAjaran' => $currentSiswaTahunAjaran,
            'riwayatAkademik' => $riwayatAkademik,
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
            'password' => 'nullable|string|min:8|confirmed',
            'nisn' => 'nullable|string|unique:users,nisn,'.$siswa->id,
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'birth_date' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'kelas_id' => 'nullable|exists:kelas,id',
            'jurusan_id' => 'nullable|exists:jurusan,id',
            'status' => 'nullable|in:aktif,naik_kelas,lulus,pindah,dikeluarkan,cuti,tinggal_kelas',
            'nomor_induk_sekolah' => 'nullable|string|max:50',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama lengkap tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar, gunakan email lain.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'nisn.unique' => 'NISN sudah terdaftar, gunakan NISN lain.',
            'gender.in' => 'Jenis kelamin tidak valid.',
            'birth_date.date' => 'Format tanggal lahir tidak valid.',
            'phone.max' => 'Nomor telepon tidak boleh lebih dari 20 karakter.',
            'photo_profile.uploaded' => 'Foto gagal diunggah. Ukuran file melebihi batas maksimal yang diizinkan server.',
            'photo_profile.image' => 'File harus berupa gambar.',
            'photo_profile.mimes' => 'Format foto harus JPG, JPEG, atau PNG.',
            'photo_profile.max' => 'Ukuran foto tidak boleh lebih dari 2MB.',
            'tahun_ajaran_id.required' => 'Tahun ajaran wajib dipilih.',
            'tahun_ajaran_id.exists' => 'Tahun ajaran yang dipilih tidak valid.',
            'kelas_id.exists' => 'Kelas yang dipilih tidak valid.',
            'jurusan_id.exists' => 'Jurusan yang dipilih tidak valid.',
            'status.in' => 'Status yang dipilih tidak valid.',
            'nomor_induk_sekolah.max' => 'Nomor induk sekolah tidak boleh lebih dari 50 karakter.',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nisn' => $validated['nisn'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
        ];

        if (! empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('photo_profile')) {
            if ($siswa->photo_profile) {
                Storage::disk('public')->delete($siswa->photo_profile);
            }
            $userData['photo_profile'] = $request->file('photo_profile')->store('photos/students', 'public');
        }

        $siswa->update($userData);

        $siswaTahunAjaran = $siswa->siswaTahunAjaran()
            ->where('tahun_ajaran_id', $validated['tahun_ajaran_id'])
            ->first();

        if ($siswaTahunAjaran) {
            $siswaTahunAjaran->update([
                'kelas_id' => $validated['kelas_id'] ?? null,
                'jurusan_id' => $validated['jurusan_id'] ?? null,
                'status' => $validated['status'] ?? 'aktif',
                'nomor_induk_sekolah' => $validated['nomor_induk_sekolah'] ?? null,
            ]);
        } else {
            SiswaTahunAjaran::create([
                'user_id' => $siswa->id,
                'tahun_ajaran_id' => $validated['tahun_ajaran_id'],
                'kelas_id' => $validated['kelas_id'] ?? null,
                'jurusan_id' => $validated['jurusan_id'] ?? null,
                'status' => $validated['status'] ?? 'aktif',
                'nomor_induk_sekolah' => $validated['nomor_induk_sekolah'] ?? null,
            ]);
        }

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

    public function reaktivasi(Request $request, User $siswa)
    {
        if (! auth()->user()->hasPermission('manage-siswa') && ! auth()->user()->hasPermission('edit-siswa')) {
            abort(403, 'You do not have permission to edit students.');
        }

        $validated = $request->validate([
            'tahun_ajaran_baru_id' => 'required|exists:tahun_ajaran,id',
            'kelas_baru_id' => 'required|exists:kelas,id',
            'jurusan_baru_id' => 'nullable|exists:jurusan,id',
        ]);

        $existingEntry = SiswaTahunAjaran::where('user_id', $siswa->id)
            ->where('tahun_ajaran_id', $validated['tahun_ajaran_baru_id'])
            ->first();

        if ($existingEntry) {
            return redirect()->back()
                ->with('error', 'Siswa sudah terdaftar di tahun ajaran yang dipilih.');
        }

        $latestEntry = $siswa->siswaTahunAjaran()
            ->orderBy('tahun_ajaran_id', 'desc')
            ->first();

        SiswaTahunAjaran::create([
            'user_id' => $siswa->id,
            'tahun_ajaran_id' => $validated['tahun_ajaran_baru_id'],
            'kelas_id' => $validated['kelas_baru_id'],
            'jurusan_id' => $validated['jurusan_baru_id'] ?? $latestEntry?->jurusan_id,
            'status' => 'aktif',
            'nomor_induk_sekolah' => $latestEntry?->nomor_induk_sekolah,
        ]);

        $tahunAjaran = TahunAjaran::find($validated['tahun_ajaran_baru_id']);

        return redirect()->route('siswa.edit', $siswa)
            ->with('success', "Siswa berhasil diaktifkan kembali di tahun ajaran {$tahunAjaran->tahun}.");
    }
}
