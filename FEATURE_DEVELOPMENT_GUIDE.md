# 🔧 Feature Development Guide - TailAdmin Laravel

**Project:** TailAdmin Laravel - Sistem Akademik SMA  
**Last Updated:** 22 April 2026  
**Version:** 1.0

---

## 📋 Table of Contents

1. [Overview](#overview)
2. [Development Workflow](#development-workflow)
3. [Feature Planning](#feature-planning)
4. [Step-by-Step Implementation](#step-by-step-implementation)
5. [Code Standards & Best Practices](#code-standards--best-practices)
6. [Testing Guidelines](#testing-guidelines)
7. [Documentation Requirements](#documentation-requirements)
8. [Example: Complete Feature](#example-complete-feature)
9. [Common Patterns](#common-patterns)
10. [Troubleshooting](#troubleshooting)

---

## 🎯 Overview

This guide provides a systematic approach to adding new features to the TailAdmin Laravel application, following Laravel best practices and the project's established patterns.

### Architecture Overview

```
┌─────────────────────────────────────────┐
│           USER REQUEST                  │
└──────────────┬──────────────────────────┘
               │
               ▼
┌─────────────────────────────────────────┐
│      ROUTES (web.php)                   │
│  - Define URL endpoints                 │
│  - Apply middleware                     │
└──────────────┬──────────────────────────┘
               │
               ▼
┌─────────────────────────────────────────┐
│      MIDDLEWARE                         │
│  - Authentication                       │
│  - Authorization (Role/Permission)      │
│  - CSRF Protection                      │
└──────────────┬──────────────────────────┘
               │
               ▼
┌─────────────────────────────────────────┐
│      CONTROLLER                         │
│  - Handle request                       │
│  - Validate input                       │
│  - Call services/models                 │
│  - Return response                      │
└──────────────┬──────────────────────────┘
               │
               ▼
┌─────────────────────────────────────────┐
│      SERVICE (optional)                 │
│  - Business logic                       │
│  - Complex operations                   │
│  - Data processing                      │
└──────────────┬──────────────────────────┘
               │
               ▼
┌─────────────────────────────────────────┐
│      MODEL                              │
│  - Database interaction                 │
│  - Relationships                        │
│  - Accessors/Mutators                   │
└──────────────┬──────────────────────────┘
               │
               ▼
┌─────────────────────────────────────────┐
│      DATABASE                           │
└─────────────────────────────────────────┘
```

---

## 🔄 Development Workflow

### Phase 1: Planning (1-2 hours)
1. Define feature requirements
2. Design database schema
3. Plan user interface
4. Identify required permissions

### Phase 2: Database (30 min - 1 hour)
1. Create migration
2. Create/update model
3. Define relationships
4. Run migration

### Phase 3: Backend (2-4 hours)
1. Create controller
2. Create service (if needed)
3. Add validation
4. Define routes
5. Test with Postman/curl

### Phase 4: Frontend (2-4 hours)
1. Create views
2. Add forms
3. Add JavaScript (if needed)
4. Style with Tailwind CSS

### Phase 5: Testing (1-2 hours)
1. Manual testing
2. Write automated tests
3. Test edge cases
4. Fix bugs

### Phase 6: Documentation (30 min)
1. Update README
2. Write feature docs
3. Add code comments
4. Update API docs (if applicable)

---

## 📝 Feature Planning

### Planning Template

```markdown
# Feature: [Feature Name]

## Requirements
- What should this feature do?
- Who will use it?
- What problems does it solve?

## Database Schema
- What tables are needed?
- What fields are required?
- What relationships exist?

## UI/UX
- What pages are needed?
- What forms/inputs are required?
- How should users interact?

## Permissions
- What roles can access?
- What actions need permissions?

## Dependencies
- What existing features does this depend on?
- What libraries/packages are needed?

## Validation Rules
- What data needs validation?
- What are the constraints?

## Success Criteria
- How do we know it works?
- What tests should pass?
```

---

## 🛠️ Step-by-Step Implementation

### STEP 1: Create Migration

**Purpose:** Define database structure

```bash
# Create migration file
php artisan make:migration create_feature_name_table

# Or for adding columns to existing table
php artisan make:migration add_columns_to_table_name
```

**Example: Create "Nilai" (Grades) Table**

```bash
php artisan make:migration create_nilai_table
```

**File:** `database/migrations/2026_04_22_XXXXXX_create_nilai_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            
            // Foreign keys
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajaran')->onDelete('cascade');
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('users')->onDelete('cascade');
            
            // Data columns
            $table->enum('semester', ['ganjil', 'genap']);
            $table->enum('jenis', ['tugas', 'uts', 'uas', 'praktek']);
            $table->decimal('nilai', 5, 2); // e.g., 98.50
            $table->text('catatan')->nullable();
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index('siswa_id');
            $table->index('mata_pelajaran_id');
            $table->index(['tahun_ajaran_id', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
```

**Run Migration:**
```bash
php artisan migrate
```

---

### STEP 2: Create Model

**Purpose:** Represent database table as PHP object

```bash
# Create model
php artisan make:model Nilai

# Or create model with migration, controller, and seeder
php artisan make:model Nilai -mcs
```

**File:** `app/Models/Nilai.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';
    
    protected $fillable = [
        'siswa_id',
        'mata_pelajaran_id',
        'tahun_ajaran_id',
        'guru_id',
        'semester',
        'jenis',
        'nilai',
        'catatan',
    ];
    
    protected $casts = [
        'nilai' => 'decimal:2',
    ];
    
    // Relationships
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
    
    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }
    
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
    
    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
    
    // Accessors (optional)
    public function getNilaiHurufAttribute()
    {
        if ($this->nilai >= 90) return 'A';
        if ($this->nilai >= 80) return 'B';
        if ($this->nilai >= 70) return 'C';
        if ($this->nilai >= 60) return 'D';
        return 'E';
    }
    
    // Scopes (optional)
    public function scopeSemesterGanjil($query)
    {
        return $query->where('semester', 'ganjil');
    }
    
    public function scopeSemesterGenap($query)
    {
        return $query->where('semester', 'genap');
    }
}
```

---

### STEP 3: Create Controller

**Purpose:** Handle HTTP requests and responses

```bash
# Create controller
php artisan make:controller NilaiController

# Or create resource controller (CRUD methods)
php artisan make:controller NilaiController --resource
```

**File:** `app/Http/Controllers/NilaiController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use App\Models\User;

class NilaiController extends Controller
{
    public function index()
    {
        $nilai = Nilai::with(['siswa', 'mataPelajaran', 'tahunAjaran', 'guru'])
            ->latest()
            ->paginate(15);
        
        return view('akademik.nilai.index', [
            'title' => 'Daftar Nilai',
            'nilai' => $nilai
        ]);
    }
    
    public function create()
    {
        $siswa = Siswa::orderBy('nama')->get();
        $mataPelajaran = MataPelajaran::orderBy('nama')->get();
        $tahunAjaran = TahunAjaran::orderBy('tahun_mulai', 'desc')->get();
        $guru = User::whereHas('roles', function($query) {
            $query->where('slug', 'guru');
        })->orderBy('name')->get();
        
        return view('akademik.nilai.create', [
            'title' => 'Tambah Nilai',
            'siswa' => $siswa,
            'mataPelajaran' => $mataPelajaran,
            'tahunAjaran' => $tahunAjaran,
            'guru' => $guru
        ]);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'guru_id' => 'required|exists:users,id',
            'semester' => 'required|in:ganjil,genap',
            'jenis' => 'required|in:tugas,uts,uas,praktek',
            'nilai' => 'required|numeric|min:0|max:100',
            'catatan' => 'nullable|string|max:500',
        ]);
        
        // Check duplicate
        $exists = Nilai::where('siswa_id', $validated['siswa_id'])
            ->where('mata_pelajaran_id', $validated['mata_pelajaran_id'])
            ->where('tahun_ajaran_id', $validated['tahun_ajaran_id'])
            ->where('semester', $validated['semester'])
            ->where('jenis', $validated['jenis'])
            ->exists();
        
        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Nilai untuk kombinasi ini sudah ada!']);
        }
        
        Nilai::create($validated);
        
        return redirect()->route('nilai.index')
            ->with('success', 'Nilai berhasil ditambahkan.');
    }
    
    public function edit(Nilai $nilai)
    {
        $siswa = Siswa::orderBy('nama')->get();
        $mataPelajaran = MataPelajaran::orderBy('nama')->get();
        $tahunAjaran = TahunAjaran::orderBy('tahun_mulai', 'desc')->get();
        $guru = User::whereHas('roles', function($query) {
            $query->where('slug', 'guru');
        })->orderBy('name')->get();
        
        return view('akademik.nilai.edit', [
            'title' => 'Edit Nilai',
            'nilai' => $nilai,
            'siswa' => $siswa,
            'mataPelajaran' => $mataPelajaran,
            'tahunAjaran' => $tahunAjaran,
            'guru' => $guru
        ]);
    }
    
    public function update(Request $request, Nilai $nilai)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'guru_id' => 'required|exists:users,id',
            'semester' => 'required|in:ganjil,genap',
            'jenis' => 'required|in:tugas,uts,uas,praktek',
            'nilai' => 'required|numeric|min:0|max:100',
            'catatan' => 'nullable|string|max:500',
        ]);
        
        $nilai->update($validated);
        
        return redirect()->route('nilai.index')
            ->with('success', 'Nilai berhasil diperbarui.');
    }
    
    public function destroy(Nilai $nilai)
    {
        $nilai->delete();
        
        return redirect()->route('nilai.index')
            ->with('success', 'Nilai berhasil dihapus.');
    }
}
```

---

### STEP 4: Create Service (Optional)

**Purpose:** Separate complex business logic from controller

**Use Service When:**
- Complex calculations
- Multiple database operations
- External API calls
- Reusable logic across controllers

```bash
# Create service manually
mkdir -p app/Services
touch app/Services/NilaiCalculationService.php
```

**File:** `app/Services/NilaiCalculationService.php`

```php
<?php

namespace App\Services;

use App\Models\Nilai;
use Illuminate\Support\Facades\DB;

class NilaiCalculationService
{
    public function calculateRapor($siswaId, $tahunAjaranId, $semester)
    {
        $nilai = Nilai::where('siswa_id', $siswaId)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->where('semester', $semester)
            ->with('mataPelajaran')
            ->get()
            ->groupBy('mata_pelajaran_id');
        
        $rapor = [];
        
        foreach ($nilai as $mapelId => $nilaiList) {
            $tugas = $nilaiList->where('jenis', 'tugas')->avg('nilai') ?? 0;
            $uts = $nilaiList->where('jenis', 'uts')->first()->nilai ?? 0;
            $uas = $nilaiList->where('jenis', 'uas')->first()->nilai ?? 0;
            $praktek = $nilaiList->where('jenis', 'praktek')->avg('nilai') ?? 0;
            
            // Formula: (30% Tugas + 30% UTS + 40% UAS + 10% Praktek) / 1.1
            $nilaiAkhir = (($tugas * 0.3) + ($uts * 0.3) + ($uas * 0.4) + ($praktek * 0.1)) / 1.1;
            
            $rapor[] = [
                'mata_pelajaran' => $nilaiList->first()->mataPelajaran->nama,
                'nilai_tugas' => round($tugas, 2),
                'nilai_uts' => $uts,
                'nilai_uas' => $uas,
                'nilai_praktek' => round($praktek, 2),
                'nilai_akhir' => round($nilaiAkhir, 2),
                'huruf' => $this->getNilaiHuruf($nilaiAkhir),
                'predikat' => $this->getPredikat($nilaiAkhir),
            ];
        }
        
        return $rapor;
    }
    
    private function getNilaiHuruf($nilai)
    {
        if ($nilai >= 90) return 'A';
        if ($nilai >= 80) return 'B';
        if ($nilai >= 70) return 'C';
        if ($nilai >= 60) return 'D';
        return 'E';
    }
    
    private function getPredikat($nilai)
    {
        if ($nilai >= 90) return 'Sangat Baik';
        if ($nilai >= 80) return 'Baik';
        if ($nilai >= 70) return 'Cukup';
        if ($nilai >= 60) return 'Kurang';
        return 'Sangat Kurang';
    }
}
```

**Use in Controller:**
```php
use App\Services\NilaiCalculationService;

class NilaiController extends Controller
{
    protected $nilaiService;
    
    public function __construct(NilaiCalculationService $nilaiService)
    {
        $this->nilaiService = $nilaiService;
    }
    
    public function rapor($siswaId)
    {
        $rapor = $this->nilaiService->calculateRapor($siswaId, 1, 'ganjil');
        return view('akademik.nilai.rapor', compact('rapor'));
    }
}
```

---

### STEP 5: Define Routes

**Purpose:** Map URLs to controller methods

**File:** `routes/web.php`

```php
// Add inside super-admin middleware group
Route::middleware('role:super-admin')->group(function () {
    // ... existing routes ...
    
    // Nilai routes
    Route::resource('nilai', App\Http\Controllers\NilaiController::class);
    
    // Custom routes (if needed)
    Route::get('/nilai/rapor/{siswa}', [App\Http\Controllers\NilaiController::class, 'rapor'])
        ->name('nilai.rapor');
    Route::post('/nilai/import', [App\Http\Controllers\NilaiController::class, 'import'])
        ->name('nilai.import');
});

// For different role access
Route::middleware('role:guru')->group(function () {
    Route::get('/nilai/input', [App\Http\Controllers\NilaiController::class, 'inputNilai'])
        ->name('nilai.input');
});
```

**Route Types:**

```php
// Resource routes (automatic CRUD)
Route::resource('nilai', NilaiController::class);
// Creates: index, create, store, show, edit, update, destroy

// Custom single route
Route::get('/path', [Controller::class, 'method'])->name('route.name');

// Group with prefix
Route::prefix('nilai')->group(function () {
    Route::get('/', [NilaiController::class, 'index']);
    Route::get('/create', [NilaiController::class, 'create']);
});

// With middleware
Route::middleware(['auth', 'role:admin'])->group(function () {
    // routes here
});
```

---

### STEP 6: Create Views

**Purpose:** User interface

**Folder Structure:**
```
resources/views/akademik/nilai/
├── index.blade.php      # List view
├── create.blade.php     # Create form
├── edit.blade.php       # Edit form
└── show.blade.php       # Detail view (optional)
```

**File:** `resources/views/akademik/nilai/index.blade.php`

```blade
@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Daftar Nilai" />

    <div class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Daftar Nilai Siswa</h2>
                <a href="{{ route('nilai.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 rounded-lg px-4 py-2 text-sm font-medium text-white transition">
                    <i class="fas fa-plus mr-2"></i>Tambah Nilai
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-green-900/20 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase dark:bg-gray-800">
                        <tr>
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">Siswa</th>
                            <th class="px-6 py-4">Mata Pelajaran</th>
                            <th class="px-6 py-4">Tahun Ajaran</th>
                            <th class="px-6 py-4">Semester</th>
                            <th class="px-6 py-4">Jenis</th>
                            <th class="px-6 py-4">Nilai</th>
                            <th class="px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($nilai as $index => $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                <td class="px-6 py-4">{{ $nilai->firstItem() + $index }}</td>
                                <td class="px-6 py-4">{{ $item->siswa->nama }}</td>
                                <td class="px-6 py-4">{{ $item->mataPelajaran->nama }}</td>
                                <td class="px-6 py-4">{{ $item->tahunAjaran->tahun_mulai }}/{{ $item->tahunAjaran->tahun_selesai }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-full bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                        {{ ucfirst($item->semester) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ ucfirst($item->jenis) }}</td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-lg">{{ $item->nilai }}</span>
                                    <span class="ml-2 text-gray-500">({{ $item->nilai_huruf }})</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('nilai.edit', $item) }}" class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('nilai.destroy', $item) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center text-gray-600">
                                    Belum ada data nilai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($nilai->hasPages())
                <div class="mt-4">
                    {{ $nilai->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
```

**File:** `resources/views/akademik/nilai/create.blade.php`

```blade
@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Tambah Nilai" />

    <div class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h2 class="mb-6 text-xl font-semibold text-gray-900 dark:text-white">Form Tambah Nilai</h2>

            @if($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-red-900/20 dark:text-red-400">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('nilai.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Siswa -->
                    <div>
                        <label class="mb-2 block text-sm font-medium">Siswa <span class="text-red-500">*</span></label>
                        <select name="siswa_id" required
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswa as $s)
                                <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Mata Pelajaran -->
                    <div>
                        <label class="mb-2 block text-sm font-medium">Mata Pelajaran <span class="text-red-500">*</span></label>
                        <select name="mata_pelajaran_id" required
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($mataPelajaran as $mapel)
                                <option value="{{ $mapel->id }}" {{ old('mata_pelajaran_id') == $mapel->id ? 'selected' : '' }}>
                                    {{ $mapel->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tahun Ajaran -->
                    <div>
                        <label class="mb-2 block text-sm font-medium">Tahun Ajaran <span class="text-red-500">*</span></label>
                        <select name="tahun_ajaran_id" required
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5">
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            @foreach($tahunAjaran as $ta)
                                <option value="{{ $ta->id }}" {{ old('tahun_ajaran_id') == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->tahun_mulai }}/{{ $ta->tahun_selesai }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Guru -->
                    <div>
                        <label class="mb-2 block text-sm font-medium">Guru <span class="text-red-500">*</span></label>
                        <select name="guru_id" required
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5">
                            <option value="">-- Pilih Guru --</option>
                            @foreach($guru as $g)
                                <option value="{{ $g->id }}" {{ old('guru_id') == $g->id ? 'selected' : '' }}>
                                    {{ $g->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Semester -->
                    <div>
                        <label class="mb-2 block text-sm font-medium">Semester <span class="text-red-500">*</span></label>
                        <select name="semester" required
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5">
                            <option value="">-- Pilih Semester --</option>
                            <option value="ganjil" {{ old('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="genap" {{ old('semester') == 'genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                    </div>

                    <!-- Jenis -->
                    <div>
                        <label class="mb-2 block text-sm font-medium">Jenis Nilai <span class="text-red-500">*</span></label>
                        <select name="jenis" required
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5">
                            <option value="">-- Pilih Jenis --</option>
                            <option value="tugas" {{ old('jenis') == 'tugas' ? 'selected' : '' }}>Tugas</option>
                            <option value="uts" {{ old('jenis') == 'uts' ? 'selected' : '' }}>UTS</option>
                            <option value="uas" {{ old('jenis') == 'uas' ? 'selected' : '' }}>UAS</option>
                            <option value="praktek" {{ old('jenis') == 'praktek' ? 'selected' : '' }}>Praktek</option>
                        </select>
                    </div>

                    <!-- Nilai -->
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium">Nilai (0-100) <span class="text-red-500">*</span></label>
                        <input type="number" name="nilai" min="0" max="100" step="0.01" required
                            value="{{ old('nilai') }}"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5">
                    </div>

                    <!-- Catatan -->
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium">Catatan</label>
                        <textarea name="catatan" rows="3"
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5">{{ old('catatan') }}</textarea>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <a href="{{ route('nilai.index') }}"
                        class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Kembali
                    </a>
                    <button type="submit"
                        class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
```

---

### STEP 7: Add to Menu/Navigation

**File:** `app/Helpers/MenuHelper.php` (or wherever menu is defined)

```php
// Add to super-admin menu
[
    'label' => 'Nilai Siswa',
    'icon' => 'fas fa-graduation-cap',
    'route' => 'nilai.index',
    'roles' => ['super-admin', 'akademik', 'guru'],
],
```

---

### STEP 8: Test the Feature

**Manual Testing Checklist:**

```markdown
✅ CREATE (Tambah)
- [ ] Form displays correctly
- [ ] All dropdowns populated
- [ ] Validation works (required fields)
- [ ] Success message shown
- [ ] Data saved to database
- [ ] Redirects correctly

✅ READ (List)
- [ ] All data displays
- [ ] Pagination works
- [ ] Search/filter works (if implemented)
- [ ] No errors in console

✅ UPDATE (Edit)
- [ ] Edit form pre-populated
- [ ] Can update all fields
- [ ] Validation works
- [ ] Success message shown
- [ ] Data updated in database

✅ DELETE
- [ ] Confirmation dialog appears
- [ ] Data deleted from database
- [ ] Success message shown
- [ ] No orphaned records

✅ EDGE CASES
- [ ] Duplicate prevention works
- [ ] Foreign key constraints work
- [ ] Error messages are clear
- [ ] Empty states handled
```

---

### STEP 9: Write Tests (Optional but Recommended)

**File:** `tests/Feature/NilaiTest.php`

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NilaiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_nilai_index()
    {
        $user = User::factory()->create();
        $user->assignRole('super-admin');

        $response = $this->actingAs($user)->get(route('nilai.index'));

        $response->assertStatus(200);
        $response->assertSee('Daftar Nilai');
    }

    public function test_can_create_nilai()
    {
        $user = User::factory()->create();
        $user->assignRole('super-admin');
        
        $siswa = Siswa::factory()->create();

        $data = [
            'siswa_id' => $siswa->id,
            'mata_pelajaran_id' => 1,
            'tahun_ajaran_id' => 1,
            'guru_id' => $user->id,
            'semester' => 'ganjil',
            'jenis' => 'tugas',
            'nilai' => 85.5,
        ];

        $response = $this->actingAs($user)->post(route('nilai.store'), $data);

        $response->assertRedirect(route('nilai.index'));
        $this->assertDatabaseHas('nilai', ['nilai' => 85.5]);
    }
}
```

**Run Tests:**
```bash
php artisan test
# or
./vendor/bin/pest
```

---

### STEP 10: Documentation

Create feature documentation file.

**File:** `NILAI_FEATURE_DOCUMENTATION.md`

```markdown
# Nilai (Grades) Feature Documentation

## Overview
Feature for managing student grades across subjects, semesters, and assessment types.

## Database Schema
Table: `nilai`
- Primary Key: id
- Foreign Keys: siswa_id, mata_pelajaran_id, tahun_ajaran_id, guru_id
- Fields: semester, jenis, nilai, catatan

## Routes
- GET /nilai - List all grades
- GET /nilai/create - Create form
- POST /nilai - Store new grade
- GET /nilai/{id}/edit - Edit form
- PUT /nilai/{id} - Update grade
- DELETE /nilai/{id} - Delete grade

## Validation Rules
- siswa_id: required, exists
- mata_pelajaran_id: required, exists
- nilai: required, numeric, 0-100
- semester: required, enum(ganjil, genap)
- jenis: required, enum(tugas, uts, uas, praktek)

## Business Logic
- Prevents duplicate grades for same student, subject, year, semester, type
- Calculates grade letter (A-E) based on numeric value
- Can calculate rapor (report card) with weighted average

## Files Created/Modified
- Migration: 2026_04_22_XXXXXX_create_nilai_table.php
- Model: app/Models/Nilai.php
- Controller: app/Http/Controllers/NilaiController.php
- Views: resources/views/akademik/nilai/*.blade.php
- Routes: routes/web.php
```

---

## 📐 Code Standards & Best Practices

### Naming Conventions

```php
// Class names: PascalCase
class NilaiController extends Controller

// Method names: camelCase
public function calculateAverage()

// Variable names: camelCase
$totalNilai = 0;

// Constants: UPPER_SNAKE_CASE
const MAX_NILAI = 100;

// Database tables: snake_case, plural
'guru_mapel_kelas'

// Database columns: snake_case
'mata_pelajaran_id'

// Route names: lowercase, dot notation
route('nilai.index')

// Blade files: kebab-case
index.blade.php
create-form.blade.php
```

### Security Practices

```php
// ✅ ALWAYS validate input
$validated = $request->validate([...]);

// ✅ Use mass assignment protection
protected $fillable = [...];

// ✅ Use CSRF protection (automatic in forms)
@csrf

// ✅ Use parameterized queries (Eloquent does this)
Nilai::where('id', $id)->first();

// ❌ NEVER do raw queries with user input
DB::raw("SELECT * FROM nilai WHERE id = $id"); // DANGEROUS!

// ✅ Escape output in Blade (automatic)
{{ $nilai->catatan }}

// ❌ Don't use unescaped output unless necessary
{!! $html !!} // Only if you trust the source

// ✅ Use authorization
$this->authorize('update', $nilai);

// ✅ Validate file uploads
$request->validate([
    'file' => 'required|file|max:2048|mimes:pdf,doc'
]);
```

### Performance Optimization

```php
// ✅ Use eager loading
$nilai = Nilai::with(['siswa', 'mataPelajaran'])->get();

// ❌ Avoid N+1 queries
foreach ($nilai as $n) {
    $n->siswa->nama; // This causes N queries!
}

// ✅ Use pagination
$nilai = Nilai::paginate(15);

// ✅ Add database indexes
$table->index('siswa_id');

// ✅ Cache expensive queries
$nilai = Cache::remember('nilai.all', 3600, function () {
    return Nilai::all();
});

// ✅ Use select to limit columns
Nilai::select('id', 'nama', 'nilai')->get();
```

---

## 🧪 Testing Guidelines

### Test Types

1. **Unit Tests** - Test individual methods
2. **Feature Tests** - Test HTTP requests/responses
3. **Browser Tests** - Test UI with Laravel Dusk

### Writing Good Tests

```php
// Test naming: test_what_it_does
public function test_user_can_create_nilai()

// Arrange - Act - Assert pattern
public function test_nilai_validation()
{
    // Arrange
    $user = User::factory()->create();
    
    // Act
    $response = $this->actingAs($user)->post(route('nilai.store'), [
        'nilai' => 150 // Invalid
    ]);
    
    // Assert
    $response->assertSessionHasErrors('nilai');
}
```

---

## 📚 Documentation Requirements

Every feature should have:

1. **Inline Code Comments** - For complex logic
2. **Method Documentation** - PHPDoc blocks
3. **README Updates** - Feature list
4. **Feature Guide** - How to use
5. **API Documentation** - If applicable

---

## 💡 Common Patterns

### Pattern 1: Filter & Search

```php
// Controller
public function index(Request $request)
{
    $query = Nilai::query();
    
    if ($request->has('siswa_id')) {
        $query->where('siswa_id', $request->siswa_id);
    }
    
    if ($request->has('semester')) {
        $query->where('semester', $request->semester);
    }
    
    $nilai = $query->paginate(15);
    
    return view('nilai.index', compact('nilai'));
}
```

### Pattern 2: Bulk Actions

```php
// Controller
public function bulkDelete(Request $request)
{
    $ids = $request->input('ids', []);
    Nilai::whereIn('id', $ids)->delete();
    
    return redirect()->back()
        ->with('success', count($ids) . ' nilai berhasil dihapus.');
}
```

### Pattern 3: Export/Import

```php
// Export
public function export()
{
    return Excel::download(new NilaiExport, 'nilai.xlsx');
}

// Import
public function import(Request $request)
{
    Excel::import(new NilaiImport, $request->file('file'));
    return redirect()->back()->with('success', 'Import berhasil!');
}
```

---

## 🔧 Troubleshooting

### Common Issues

**Issue:** Route not found
```bash
php artisan route:clear
php artisan route:cache
```

**Issue:** View not found
```bash
php artisan view:clear
```

**Issue:** Migration fails
```bash
php artisan migrate:rollback
# Fix migration file
php artisan migrate
```

**Issue:** Class not found
```bash
composer dump-autoload
```

---

## ✅ Feature Completion Checklist

```markdown
## Pre-Development
- [ ] Requirements defined
- [ ] Database schema designed
- [ ] UI/UX planned
- [ ] Permissions identified

## Development
- [ ] Migration created and tested
- [ ] Model created with relationships
- [ ] Controller created with CRUD
- [ ] Service created (if needed)
- [ ] Routes defined
- [ ] Views created
- [ ] Validation implemented
- [ ] Authorization implemented

## Testing
- [ ] Manual testing completed
- [ ] Edge cases tested
- [ ] Unit tests written
- [ ] Feature tests written
- [ ] Browser tests written (if needed)

## Documentation
- [ ] Code comments added
- [ ] PHPDoc blocks added
- [ ] Feature documentation created
- [ ] README updated
- [ ] Changelog updated

## Deployment
- [ ] Code reviewed
- [ ] Tests passing
- [ ] No console errors
- [ ] Performance optimized
- [ ] Security reviewed
- [ ] Merged to main branch
```

---

## 🎓 Learning Resources

- **Laravel Docs:** https://laravel.com/docs
- **Tailwind CSS:** https://tailwindcss.com/docs
- **Blade Templates:** https://laravel.com/docs/blade
- **Eloquent ORM:** https://laravel.com/docs/eloquent
- **Testing:** https://laravel.com/docs/testing

---

**Happy Coding! 🚀**

**Last Updated:** April 22, 2026  
**Version:** 1.0

