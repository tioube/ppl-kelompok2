<?php

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

    Route::get('/dashboard/super-admin', [App\Http\Controllers\Dashboard\SuperAdminDashboardController::class, 'index'])
        ->middleware('role:super-admin')
        ->name('dashboard.super-admin');

    Route::get('/dashboard/admin', [App\Http\Controllers\Dashboard\AdminDashboardController::class, 'index'])
        ->middleware('role:admin')
        ->name('dashboard.admin');

    Route::get('/dashboard/akademik', [App\Http\Controllers\Dashboard\AkademikDashboardController::class, 'index'])
        ->middleware('role:akademik')
        ->name('dashboard.akademik');

    Route::get('/dashboard/guru', [App\Http\Controllers\Dashboard\GuruDashboardController::class, 'index'])
        ->middleware('role:guru')
        ->name('dashboard.guru');

    Route::get('/dashboard/siswa', [App\Http\Controllers\Dashboard\SiswaDashboardController::class, 'index'])
        ->middleware('role:siswa')
        ->name('dashboard.siswa');

    Route::middleware('role:super-admin')->group(function () {
        Route::get('/guru', [App\Http\Controllers\GuruController::class, 'index'])->name('guru.index');

        Route::resource('mata-pelajaran', App\Http\Controllers\MataPelajaranController::class);

        Route::resource('siswa', App\Http\Controllers\SiswaController::class);
        Route::resource('tahun-ajaran', App\Http\Controllers\TahunAjaranController::class);
        Route::resource('jurusan', App\Http\Controllers\JurusanController::class);
        Route::resource('kelas', App\Http\Controllers\KelasController::class);
    Route::resource('jadwal-pelajaran', App\Http\Controllers\JadwalPelajaranController::class);

    Route::resource('guru-mapel-kelas', App\Http\Controllers\GuruMapelKelasController::class);
    Route::post('/guru-mapel-kelas-generate', [App\Http\Controllers\GuruMapelKelasController::class, 'generate'])->name('guru-mapel-kelas.generate');
    Route::delete('/guru-mapel-kelas-clear', [App\Http\Controllers\GuruMapelKelasController::class, 'clear'])->name('guru-mapel-kelas.clear');

    Route::get('/schedules', [App\Http\Controllers\ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/schedules/create', [App\Http\Controllers\ScheduleController::class, 'create'])->name('schedules.create');
    Route::post('/schedules', [App\Http\Controllers\ScheduleController::class, 'store'])->name('schedules.store');
    Route::post('/schedules/generate', [App\Http\Controllers\ScheduleController::class, 'generate'])->name('schedules.generate');
    Route::delete('/schedules', [App\Http\Controllers\ScheduleController::class, 'destroy'])->name('schedules.destroy');
        Route::post('/schedules/swap', [App\Http\Controllers\ScheduleController::class, 'swap'])->name('schedules.swap');
        Route::post('/schedules/move', [App\Http\Controllers\ScheduleController::class, 'moveToSlot'])->name('schedules.move');
        Route::get('/schedules/{id}/edit', [App\Http\Controllers\ScheduleController::class, 'edit'])->name('schedules.edit');
        Route::put('/schedules/{id}', [App\Http\Controllers\ScheduleController::class, 'update'])->name('schedules.update');
    });

    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';
