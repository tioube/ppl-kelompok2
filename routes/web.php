<?php

use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\AkademikDashboardController;
use App\Http\Controllers\Dashboard\GuruDashboardController;
use App\Http\Controllers\Dashboard\SiswaDashboardController;
use App\Http\Controllers\Dashboard\SuperAdminDashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\GuruMapelKelasController;
use App\Http\Controllers\JadwalPelajaranController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->hasRole('super-admin')) {
            return redirect()->route('dashboard.super-admin');
        } elseif ($user->hasRole('admin')) {
            return redirect()->route('dashboard.admin');
        } elseif ($user->hasRole('akademik')) {
            return redirect()->route('dashboard.akademik');
        } elseif ($user->hasRole('guru')) {
            return redirect()->route('dashboard.guru');
        } elseif ($user->hasRole('siswa')) {
            return redirect()->route('dashboard.siswa');
        }

        return view('dashboard', ['title' => 'Dashboard']);
    })->name('dashboard');

    Route::get('/dashboard/super-admin', [SuperAdminDashboardController::class, 'index'])
        ->middleware('role:super-admin')
        ->name('dashboard.super-admin');

    Route::get('/dashboard/admin', [AdminDashboardController::class, 'index'])
        ->middleware('role:admin')
        ->name('dashboard.admin');

    Route::get('/dashboard/akademik', [AkademikDashboardController::class, 'index'])
        ->middleware('role:akademik')
        ->name('dashboard.akademik');

    Route::get('/dashboard/guru', [GuruDashboardController::class, 'index'])
        ->middleware('role:guru')
        ->name('dashboard.guru');

    Route::get('/dashboard/siswa', [SiswaDashboardController::class, 'index'])
        ->middleware('role:siswa')
        ->name('dashboard.siswa');

    Route::middleware(['auth'])->group(function () {
        // Mata Pelajaran Routes with Granular Permissions
        Route::middleware('permission:manage-mata-pelajaran,view-mata-pelajaran')->group(function () {
            Route::get('/mata-pelajaran', [MataPelajaranController::class, 'index'])->name('mata-pelajaran.index');
            Route::get('/mata-pelajaran/{mata_pelajaran}', [MataPelajaranController::class, 'show'])->name('mata-pelajaran.show');
        });

        Route::middleware('permission:manage-mata-pelajaran,create-mata-pelajaran')->group(function () {
            Route::get('/mata-pelajaran/create', [MataPelajaranController::class, 'create'])->name('mata-pelajaran.create');
            Route::post('/mata-pelajaran', [MataPelajaranController::class, 'store'])->name('mata-pelajaran.store');
        });

        Route::middleware('permission:manage-mata-pelajaran,edit-mata-pelajaran')->group(function () {
            Route::get('/mata-pelajaran/{mata_pelajaran}/edit', [MataPelajaranController::class, 'edit'])->name('mata-pelajaran.edit');
            Route::put('/mata-pelajaran/{mata_pelajaran}', [MataPelajaranController::class, 'update'])->name('mata-pelajaran.update');
            Route::patch('/mata-pelajaran/{mata_pelajaran}', [MataPelajaranController::class, 'update']);
        });

        Route::middleware('permission:manage-mata-pelajaran,delete-mata-pelajaran')->group(function () {
            Route::delete('/mata-pelajaran/{mata_pelajaran}', [MataPelajaranController::class, 'destroy'])->name('mata-pelajaran.destroy');
        });

        // Siswa Routes with Granular Permissions (FIXED ORDER)
        Route::middleware('permission:manage-siswa,view-siswa')->group(function () {
            Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
        });

        Route::middleware('permission:manage-siswa,create-siswa')->group(function () {
            Route::get('/siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
            Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
        });

        Route::middleware('permission:manage-siswa,edit-siswa')->group(function () {
            Route::get('/siswa/{siswa}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
            Route::put('/siswa/{siswa}', [SiswaController::class, 'update'])->name('siswa.update');
            Route::patch('/siswa/{siswa}', [SiswaController::class, 'update']);
        });

        Route::middleware('permission:manage-siswa,delete-siswa')->group(function () {
            Route::delete('/siswa/{siswa}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
        });

        // Move show route AFTER specific routes to prevent collision
        Route::middleware('permission:manage-siswa,view-siswa')->group(function () {
            Route::get('/siswa/{siswa}', [SiswaController::class, 'show'])->name('siswa.show');
        });

        // Guru Routes with Granular Permissions (NEW)
        Route::middleware('permission:manage-guru,view-guru')->group(function () {
            Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');
        });

        Route::middleware('permission:manage-guru,create-guru')->group(function () {
            Route::get('/guru/create', [GuruController::class, 'create'])->name('guru.create');
            Route::post('/guru', [GuruController::class, 'store'])->name('guru.store');
        });

        Route::middleware('permission:manage-guru,edit-guru')->group(function () {
            Route::get('/guru/{guru}/edit', [GuruController::class, 'edit'])->name('guru.edit');
            Route::put('/guru/{guru}', [GuruController::class, 'update'])->name('guru.update');
            Route::patch('/guru/{guru}', [GuruController::class, 'update']);
        });

        Route::middleware('permission:manage-guru,delete-guru')->group(function () {
            Route::delete('/guru/{guru}', [GuruController::class, 'destroy'])->name('guru.destroy');
        });

        // Move show route AFTER specific routes to prevent collision
        Route::middleware('permission:manage-guru,view-guru')->group(function () {
            Route::get('/guru/{guru}', [GuruController::class, 'show'])->name('guru.show');
        });

        // Tahun Ajaran Routes with Granular Permissions
        Route::middleware('permission:manage-tahun-ajaran,view-tahun-ajaran')->group(function () {
            Route::get('/tahun-ajaran', [TahunAjaranController::class, 'index'])->name('tahun-ajaran.index');
            Route::get('/tahun-ajaran/{tahun_ajaran}', [TahunAjaranController::class, 'show'])->name('tahun-ajaran.show');
        });

        Route::middleware('permission:manage-tahun-ajaran,create-tahun-ajaran')->group(function () {
            Route::get('/tahun-ajaran/create', [TahunAjaranController::class, 'create'])->name('tahun-ajaran.create');
            Route::post('/tahun-ajaran', [TahunAjaranController::class, 'store'])->name('tahun-ajaran.store');
        });

        Route::middleware('permission:manage-tahun-ajaran,edit-tahun-ajaran')->group(function () {
            Route::get('/tahun-ajaran/{tahun_ajaran}/edit', [TahunAjaranController::class, 'edit'])->name('tahun-ajaran.edit');
            Route::put('/tahun-ajaran/{tahun_ajaran}', [TahunAjaranController::class, 'update'])->name('tahun-ajaran.update');
            Route::patch('/tahun-ajaran/{tahun_ajaran}', [TahunAjaranController::class, 'update']);
        });

        Route::middleware('permission:manage-tahun-ajaran,delete-tahun-ajaran')->group(function () {
            Route::delete('/tahun-ajaran/{tahun_ajaran}', [TahunAjaranController::class, 'destroy'])->name('tahun-ajaran.destroy');
        });

        // Jurusan Routes with Granular Permissions
        Route::middleware('permission:manage-jurusan,view-jurusan')->group(function () {
            Route::get('/jurusan', [JurusanController::class, 'index'])->name('jurusan.index');
            Route::get('/jurusan/{jurusan}', [JurusanController::class, 'show'])->name('jurusan.show');
        });

        Route::middleware('permission:manage-jurusan,create-jurusan')->group(function () {
            Route::get('/jurusan/create', [JurusanController::class, 'create'])->name('jurusan.create');
            Route::post('/jurusan', [JurusanController::class, 'store'])->name('jurusan.store');
        });

        Route::middleware('permission:manage-jurusan,edit-jurusan')->group(function () {
            Route::get('/jurusan/{jurusan}/edit', [JurusanController::class, 'edit'])->name('jurusan.edit');
            Route::put('/jurusan/{jurusan}', [JurusanController::class, 'update'])->name('jurusan.update');
            Route::patch('/jurusan/{jurusan}', [JurusanController::class, 'update']);
        });

        Route::middleware('permission:manage-jurusan,delete-jurusan')->group(function () {
            Route::delete('/jurusan/{jurusan}', [JurusanController::class, 'destroy'])->name('jurusan.destroy');
        });

        // Kelas Routes with Granular Permissions
        Route::middleware('permission:manage-kelas,view-kelas')->group(function () {
            Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
            Route::get('/kelas/{kela}', [KelasController::class, 'show'])->name('kelas.show');
        });

        Route::middleware('permission:manage-kelas,create-kelas')->group(function () {
            Route::get('/kelas/create', [KelasController::class, 'create'])->name('kelas.create');
            Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');
        });

        Route::middleware('permission:manage-kelas,edit-kelas')->group(function () {
            Route::get('/kelas/{kela}/edit', [KelasController::class, 'edit'])->name('kelas.edit');
            Route::put('/kelas/{kela}', [KelasController::class, 'update'])->name('kelas.update');
            Route::patch('/kelas/{kela}', [KelasController::class, 'update']);
        });

        Route::middleware('permission:manage-kelas,delete-kelas')->group(function () {
            Route::delete('/kelas/{kela}', [KelasController::class, 'destroy'])->name('kelas.destroy');
        });

        // Jadwal Pelajaran Routes
        Route::middleware('permission:manage-jadwal-pelajaran,view-jadwal-pelajaran')->group(function () {
            Route::get('/jadwal-pelajaran', [JadwalPelajaranController::class, 'index'])->name('jadwal-pelajaran.index');
        });

        // Guru Mapel Kelas Routes
        Route::middleware('permission:manage-guru-mapel-kelas,view-guru-mapel-kelas')->group(function () {
            Route::resource('guru-mapel-kelas', GuruMapelKelasController::class);
            Route::post('/guru-mapel-kelas-generate', [GuruMapelKelasController::class, 'generate'])->name('guru-mapel-kelas.generate');
            Route::delete('/guru-mapel-kelas-clear', [GuruMapelKelasController::class, 'clear'])->name('guru-mapel-kelas.clear');
        });

        // Schedule Routes
        Route::middleware('permission:manage-schedules,view-schedules')->group(function () {
            Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');
            Route::get('/schedules/create', [ScheduleController::class, 'create'])->name('schedules.create');
            Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store');
            Route::post('/schedules/generate', [ScheduleController::class, 'generate'])->name('schedules.generate');
            Route::delete('/schedules', [ScheduleController::class, 'destroy'])->name('schedules.destroy');
            Route::post('/schedules/swap', [ScheduleController::class, 'swap'])->name('schedules.swap');
            Route::post('/schedules/move', [ScheduleController::class, 'moveToSlot'])->name('schedules.move');
            Route::get('/schedules/{id}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');
            Route::put('/schedules/{id}', [ScheduleController::class, 'update'])->name('schedules.update');
        });

        // Users Routes with Granular Permissions
        Route::middleware('permission:manage-users,view-users')->group(function () {
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        });

        Route::middleware('permission:manage-users,create-users')->group(function () {
            Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/users', [UserController::class, 'store'])->name('users.store');
        });

        Route::middleware('permission:manage-users,edit-users')->group(function () {
            Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
            Route::patch('/users/{user}', [UserController::class, 'update']);
        });

        Route::middleware('permission:manage-users,delete-users')->group(function () {
            Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        });
    });
});

require __DIR__.'/auth.php';
