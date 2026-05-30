<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\PengajaranController;
use App\Http\Controllers\Admin\RisetController;
use App\Http\Controllers\Admin\PkmController;
use App\Http\Controllers\Admin\BimbinganController;
use App\Http\Controllers\Admin\PeriodController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\EvaluasiKinerjaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('dosen.dashboard');
    }
    return redirect()->route('login');
});

// Authentication routes
Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Route untuk Admin
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Dosen
    Route::resource('dosens', DosenController::class);
    Route::get('/dosens/export/excel', [DosenController::class, 'export'])->name('dosens.export');

    // Pengajaran
    Route::resource('pengajaran', PengajaranController::class);
    Route::get('/pengajaran/export', [PengajaranController::class, 'export'])->name('pengajaran.export');
    Route::get('/pengajaran/print', [PengajaranController::class, 'print'])->name('pengajaran.print');

    // Riset
    Route::resource('riset', RisetController::class);
    Route::get('/riset/export', [RisetController::class, 'export'])->name('riset.export');
    Route::get('/riset/download/{id}', [RisetController::class, 'downloadLaporan'])->name('riset.download');

    // PKM
    Route::resource('pkm', PkmController::class);
    Route::get('/pkm/export', [PkmController::class, 'export'])->name('pkm.export');
    Route::get('/pkm/download/{id}', [PkmController::class, 'downloadLaporan'])->name('pkm.download');

    // Bimbingan
    Route::resource('bimbingan', BimbinganController::class);
    Route::get('/bimbingan/export', [BimbinganController::class, 'export'])->name('bimbingan.export');

    // Periode Akademik
    Route::resource('periods', PeriodController::class);
    Route::post('/periods/{period}/set-active', [PeriodController::class, 'setActive'])->name('periods.set-active');

    // ========== EVALUASI KINERJA ==========
    // PASTIKAN INI ADA
    Route::get('/evaluasi', [EvaluasiKinerjaController::class, 'index'])->name('evaluasi.index');
    Route::get('/evaluasi/print', [EvaluasiKinerjaController::class, 'print'])->name('evaluasi.print');
    Route::get('/evaluasi/export-pdf', [EvaluasiKinerjaController::class, 'exportPdf'])->name('evaluasi.export-pdf');

    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/export/excel', [LaporanController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export/pdf', [LaporanController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/print', [LaporanController::class, 'print'])->name('print');
    });

    // Activity Logs
    Route::prefix('activity-logs')->name('activity-logs.')->group(function () {
        Route::get('/', [ActivityLogController::class, 'index'])->name('index');
        Route::get('/{activityLog}', [ActivityLogController::class, 'show'])->name('show');
        Route::delete('/{activityLog}', [ActivityLogController::class, 'destroy'])->name('destroy');
        Route::delete('/clear/old', [ActivityLogController::class, 'clearOldLogs'])->name('clear');
        Route::get('/export', [ActivityLogController::class, 'export'])->name('export');
    });
});



Route::fallback(function () {
    return redirect()->route('login')->with('error', 'Halaman tidak ditemukan!');
});
