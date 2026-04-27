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
use App\Http\Controllers\SiswaTugasController;
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

    Route::get('/siswa/tugas', [SiswaTugasController::class, 'index'])
        ->middleware('role:siswa')
        ->name('siswa.tugas');

    Route::post('/siswa/tugas/{tugas}/upload', [SiswaTugasController::class, 'upload'])
    ->middleware('role:siswa')
    ->name('siswa.tugas.upload');

    Route::middleware('role:super-admin')->group(function () {
        Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');

        Route::resource('mata-pelajaran', MataPelajaranController::class);

        Route::resource('siswa', SiswaController::class);
        Route::resource('tahun-ajaran', TahunAjaranController::class);
        Route::resource('jurusan', JurusanController::class);
        Route::resource('kelas', KelasController::class);
        Route::resource('jadwal-pelajaran', JadwalPelajaranController::class);

        Route::resource('guru-mapel-kelas', GuruMapelKelasController::class);
        Route::post('/guru-mapel-kelas-generate', [GuruMapelKelasController::class, 'generate'])->name('guru-mapel-kelas.generate');
        Route::delete('/guru-mapel-kelas-clear', [GuruMapelKelasController::class, 'clear'])->name('guru-mapel-kelas.clear');

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

    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';
