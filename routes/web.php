<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\PengajaranController;
use App\Http\Controllers\Admin\RisetController;
use App\Http\Controllers\Admin\PkmController;
use App\Http\Controllers\Admin\BimbinganController;
use App\Http\Controllers\Admin\PeriodController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

Auth::routes();

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Dosen Management
    Route::resource('dosens', DosenController::class);

    // Pengajaran Management
    Route::resource('pengajaran', PengajaranController::class);

    // Research Management
    Route::resource('riset', RisetController::class);

    // Community Service Management
    Route::resource('pkm', PkmController::class);

    // Guidance Management
    Route::resource('bimbingan', BimbinganController::class);

    // Academic Period Management
    Route::resource('periods', PeriodController::class);
    Route::post('/periods/{period}/set-active', [PeriodController::class, 'setActive'])->name('periods.set-active');

    // Reports
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export/excel', [LaporanController::class, 'exportExcel'])->name('laporan.export.excel');
    Route::get('/laporan/export/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Activity Log Management (only superadmin and admin)
    Route::prefix('activity-logs')->name('activity-logs.')->middleware(['role:superadmin,admin'])->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('index');
        Route::get('/{activityLog}', [App\Http\Controllers\Admin\ActivityLogController::class, 'show'])->name('show');
        Route::delete('/{activityLog}', [App\Http\Controllers\Admin\ActivityLogController::class, 'destroy'])->name('destroy');
        Route::delete('/clear/old', [App\Http\Controllers\Admin\ActivityLogController::class, 'clearOldLogs'])->name('clear');
        Route::get('/export', [App\Http\Controllers\Admin\ActivityLogController::class, 'export'])->name('export');
    });
});
