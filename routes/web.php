<?php
// routes/web.php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\PengajaranController as AdminPengajaranController;
use App\Http\Controllers\Admin\RisetController as AdminRisetController;
use App\Http\Controllers\Admin\PkmController as AdminPkmController;
use App\Http\Controllers\Admin\BimbinganController as AdminBimbinganController;
use App\Http\Controllers\Admin\PeriodController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AsosiasiController;
use App\Http\Controllers\Admin\EvaluasiKinerjaController;
use App\Http\Controllers\Admin\PelatihanController;
use App\Http\Controllers\Admin\SertifikasiController;
use App\Http\Controllers\Admin\SippController;
use App\Http\Controllers\Admin\SuratTugasController;
use App\Http\Controllers\Dosen\AsosiasiController as DosenAsosiasiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route untuk Dosen Controllers
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Dosen\PengajaranController as DosenPengajaranController;
use App\Http\Controllers\Dosen\RisetController as DosenRisetController;
use App\Http\Controllers\Dosen\PkmController as DosenPkmController;
use App\Http\Controllers\Dosen\BimbinganController as DosenBimbinganController;
use App\Http\Controllers\Dosen\EvaluasiKinerjaController as DosenEvaluasiKinerjaController;
use App\Http\Controllers\Dosen\LaporanController as DosenLaporanController;
use App\Http\Controllers\Dosen\PelatihanController as DosenPelatihanController;
use App\Http\Controllers\Dosen\ProfileController as DosenProfileController;
use App\Http\Controllers\Dosen\SertifikasiController as DosenSertifikasiController;
use App\Http\Controllers\Dosen\SippController as DosenSippController;
use App\Http\Controllers\Dosen\SuratTugasController as DosenSuratTugasController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route utama - LANGSUNG KE LOGIN
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes
Auth::routes();

// Route setelah login - handle redirect di LoginController
Route::get('/home', function () {
    $user = Auth::user();
    if ($user) {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        if ($user->role === 'dosen') {
            return redirect()->route('dosen.dashboard');
        }
    }
    return redirect()->route('login');
})->name('home');

// Route untuk profile (bisa diakses semua user yang login)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// ========== ROUTE UNTUK ADMIN ==========
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Dosen
    Route::resource('dosens', DosenController::class);
    Route::get('/dosens/export/excel', [DosenController::class, 'export'])->name('dosens.export');

    // Pengajaran
    Route::resource('pengajaran', AdminPengajaranController::class);
    Route::get('/pengajaran/export', [AdminPengajaranController::class, 'export'])->name('pengajaran.export');
    Route::get('/pengajaran/print', [AdminPengajaranController::class, 'print'])->name('pengajaran.print');

    // Riset
    Route::resource('riset', AdminRisetController::class);
    Route::get('/riset/export', [AdminRisetController::class, 'export'])->name('riset.export');
    Route::get('/riset/download/{id}', [AdminRisetController::class, 'downloadLaporan'])->name('riset.download');

    // PKM
    Route::resource('pkm', AdminPkmController::class);
    Route::get('/pkm/export', [AdminPkmController::class, 'export'])->name('pkm.export');
    Route::get('/pkm/download/{id}', [AdminPkmController::class, 'downloadLaporan'])->name('pkm.download');

    // Bimbingan
    Route::resource('bimbingan', AdminBimbinganController::class);
    Route::get('/bimbingan/export', [AdminBimbinganController::class, 'export'])->name('bimbingan.export');

    // Asosiasi
    Route::resource('asosiasi', AsosiasiController::class);

    // Pelatihan
    Route::resource('pelatihan', PelatihanController::class);
    Route::get('/pelatihan/download/{id}', [PelatihanController::class, 'download'])->name('pelatihan.download');

    // SIPP
    Route::resource('sipp', SippController::class);

    // Surat Tugas
    Route::resource('surat-tugas', SuratTugasController::class);
    Route::get('/surat-tugas/download/{id}', [SuratTugasController::class, 'download'])->name('surat-tugas.download');

    // Sertifikasi
    Route::resource('sertifikasi', SertifikasiController::class);
    Route::get('/sertifikasi/download/{id}', [SertifikasiController::class, 'download'])->name('sertifikasi.download');

    // Periode Akademik
    Route::resource('periods', PeriodController::class);
    Route::post('/periods/{period}/set-active', [PeriodController::class, 'setActive'])->name('periods.set-active');

    // Evaluasi Kinerja
    Route::prefix('evaluasi-kinerja')->name('evaluasi-kinerja.')->group(function () {
        Route::get('/', [EvaluasiKinerjaController::class, 'index'])->name('index');
        Route::get('/print', [EvaluasiKinerjaController::class, 'print'])->name('print');
        Route::get('/export-pdf', [EvaluasiKinerjaController::class, 'exportPdf'])->name('export-pdf');
    });

    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [AdminLaporanController::class, 'index'])->name('index');
        Route::get('/export/excel', [AdminLaporanController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export/pdf', [AdminLaporanController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/print', [AdminLaporanController::class, 'print'])->name('print');
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

// ========== ROUTE UNTUK DOSEN ==========
Route::prefix('dosen')->name('dosen.')->middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DosenDashboardController::class, 'index'])->name('dashboard');

    // Pengajaran
    Route::resource('pengajaran', DosenPengajaranController::class);

    // Riset
    Route::resource('riset', DosenRisetController::class);
    Route::get('/riset/download/{id}', [DosenRisetController::class, 'downloadLaporan'])->name('riset.download');

    // PKM
    Route::resource('pkm', DosenPkmController::class);
    Route::get('/pkm/download/{id}', [DosenPkmController::class, 'downloadLaporan'])->name('pkm.download');

    // Bimbingan
    Route::resource('bimbingan', DosenBimbinganController::class);

    // Asosiasi
    Route::resource('asosiasi', DosenAsosiasiController::class);

    // Pelatihan
    Route::resource('pelatihan', DosenPelatihanController::class);
    Route::get('/pelatihan/download/{id}', [DosenPelatihanController::class, 'download'])->name('pelatihan.download');

    // SIPP
    Route::resource('sipp', DosenSippController::class);

    // Surat Tugas
    Route::resource('surat-tugas', DosenSuratTugasController::class);
    Route::get('/surat-tugas/download/{id}', [DosenSuratTugasController::class, 'download'])->name('surat-tugas.download');

    // Sertifikasi
    Route::resource('sertifikasi', DosenSertifikasiController::class);
    Route::get('/sertifikasi/download/{id}', [DosenSertifikasiController::class, 'download'])->name('sertifikasi.download');

    // Laporan
    Route::get('/laporan', [DosenLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/print', [DosenLaporanController::class, 'print'])->name('laporan.print');

    // Evaluasi Kinerja
    Route::get('/evaluasi-kinerja', [DosenEvaluasiKinerjaController::class, 'index'])->name('evaluasi-kinerja.index');
    Route::get('/evaluasi-kinerja/print', [DosenEvaluasiKinerjaController::class, 'print'])->name('evaluasi-kinerja.print');

    // Profile
    Route::get('/profile', [DosenProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [DosenProfileController::class, 'update'])->name('profile.update');
});

// Fallback route untuk 404
Route::fallback(function () {
    return redirect()->route('login')->with('error', 'Halaman tidak ditemukan!');
});
