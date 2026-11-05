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
use App\Http\Controllers\Admin\AsosiasiController;
use App\Http\Controllers\Admin\PelatihanController;
use App\Http\Controllers\Admin\SippController;
use App\Http\Controllers\Admin\SertifikasiController;
use App\Http\Controllers\Admin\SuratTugasController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Import Controller Dosen
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Dosen\PengajaranController as DosenPengajaranController;
use App\Http\Controllers\Dosen\RisetController as DosenRisetController;
use App\Http\Controllers\Dosen\PkmController as DosenPkmController;
use App\Http\Controllers\Dosen\BimbinganController as DosenBimbinganController;
use App\Http\Controllers\Dosen\LaporanController as DosenLaporanController;
use App\Http\Controllers\Dosen\EvaluasiKinerjaController as DosenEvaluasiKinerjaController;
use App\Http\Controllers\Dosen\ProfileController as DosenProfileController;
use App\Http\Controllers\Dosen\AsosiasiController as DosenAsosiasiController;
use App\Http\Controllers\Dosen\PelatihanController as DosenPelatihanController;
use App\Http\Controllers\Dosen\SippController as DosenSippController;
use App\Http\Controllers\Dosen\SertifikasiController as DosenSertifikasiController;
use App\Http\Controllers\Dosen\SuratTugasController as DosenSuratTugasController;

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

// ==========================================
// ROUTE UNTUK ADMIN
// ==========================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Dosen
    Route::get('/dosens/export/excel', [DosenController::class, 'export'])->name('dosens.export');
    Route::get('/dosens/download-template', [DosenController::class, 'downloadTemplate'])->name('dosens.download-template');
    Route::post('/dosens/import', [DosenController::class, 'import'])->name('dosens.import');
    Route::post('/dosens/{id}/reset-password', [DosenController::class, 'resetPassword'])->name('dosens.reset-password');
    Route::resource('dosens', DosenController::class);

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

    // Pengembangan Profesi
    Route::resource('asosiasi', AsosiasiController::class);
    Route::resource('pelatihan', PelatihanController::class);
    Route::get('/pelatihan/download/{id}', [PelatihanController::class, 'download'])->name('pelatihan.download');
    Route::resource('sipp', SippController::class);
    Route::resource('sertifikasi', SertifikasiController::class);
    Route::get('/sertifikasi/download/{id}', [SertifikasiController::class, 'download'])->name('sertifikasi.download');
    Route::resource('surat-tugas', SuratTugasController::class);
    Route::get('/surat-tugas/download/{id}', [SuratTugasController::class, 'download'])->name('surat-tugas.download');

    // Periode Akademik
    Route::resource('periods', PeriodController::class);
    Route::post('/periods/{period}/set-active', [PeriodController::class, 'setActive'])->name('periods.set-active');

    // Evaluasi Kinerja (Hanya satu, tidak dobel)
    Route::prefix('evaluasi-kinerja')->name('evaluasi-kinerja.')->group(function () {
        Route::get('/', [EvaluasiKinerjaController::class, 'index'])->name('index');
        Route::get('/print', [EvaluasiKinerjaController::class, 'print'])->name('print');
        Route::get('/export-pdf', [EvaluasiKinerjaController::class, 'exportPdf'])->name('export-pdf');
    });

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

// ==========================================
// ROUTE UNTUK DOSEN
// ==========================================
Route::prefix('dosen')->name('dosen.')->middleware(['auth', 'role:dosen'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DosenDashboardController::class, 'index'])->name('dashboard');

    // Kinerja Utama
    Route::resource('pengajaran', DosenPengajaranController::class);
    Route::resource('riset', DosenRisetController::class);
    Route::get('/riset/download/{id}', [DosenRisetController::class, 'downloadLaporan'])->name('riset.download');
    Route::resource('pkm', DosenPkmController::class);
    Route::get('/pkm/download/{id}', [DosenPkmController::class, 'downloadLaporan'])->name('pkm.download');
    Route::resource('bimbingan', DosenBimbinganController::class);

    // Pengembangan Profesi
    Route::resource('asosiasi', DosenAsosiasiController::class);
    Route::resource('pelatihan', DosenPelatihanController::class);
    Route::get('/pelatihan/download/{id}', [DosenPelatihanController::class, 'download'])->name('pelatihan.download');
    Route::resource('sipp', DosenSippController::class);
    Route::resource('sertifikasi', DosenSertifikasiController::class);
    Route::get('/sertifikasi/download/{id}', [DosenSertifikasiController::class, 'download'])->name('sertifikasi.download');
    Route::resource('surat-tugas', DosenSuratTugasController::class);
    Route::get('/surat-tugas/download/{id}', [DosenSuratTugasController::class, 'download'])->name('surat-tugas.download');
    Route::resource('sipp', DosenSippController::class);
    Route::get('/sipp/download/{id}', [DosenSippController::class, 'download'])->name('sipp.download');

    // Laporan & Evaluasi
    Route::get('/laporan', [DosenLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/print', [DosenLaporanController::class, 'print'])->name('laporan.print');
    Route::get('/evaluasi-kinerja', [DosenEvaluasiKinerjaController::class, 'index'])->name('evaluasi-kinerja.index');
    Route::get('/evaluasi-kinerja/print', [DosenEvaluasiKinerjaController::class, 'print'])->name('evaluasi-kinerja.print');

    // Profile
    Route::get('/profile', [DosenProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [DosenProfileController::class, 'update'])->name('profile.update');
});

// Fallback Route
Route::fallback(function () {
    return redirect()->route('login')->with('error', 'Halaman tidak ditemukan!');
});
