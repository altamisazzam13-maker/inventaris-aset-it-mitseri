<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\UserController;

// Redirect Halaman Utama
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Route Umum (Bisa diakses Admin & Staff)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AssetController::class, 'dashboard'])->name('dashboard');
    Route::get('/assets', [AssetController::class, 'index'])->name('assets.index');
    
    // RUTE PDF (Mencakup URL /assets/export-pdf sesuai tombol di gambar)
    Route::get('/assets/export-pdf', [AssetController::class, 'exportPdf'])->name('assets.exportPdf');
    Route::get('/assets/export/pdf', [AssetController::class, 'exportPdf']);
    
    // Route Export Excel
    Route::get('/assets/export/excel', [AssetController::class, 'exportExcel'])->name('assets.exportExcel');

    // Route Detail Asset (Harus di bawah rute PDF)
    Route::get('/assets/{asset}', [AssetController::class, 'show'])->name('assets.show');
});

// Route Khusus Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::put('/users/{user}/role', [AssetController::class, 'updateUserRole'])->name('users.updateRole');
    
    Route::get('/kategori', [AssetController::class, 'kategoriIndex'])->name('kategori.index');
    Route::get('/maintenances', [AssetController::class, 'maintenanceIndex'])->name('maintenances.index');
    Route::post('/maintenances', [AssetController::class, 'storeMaintenance'])->name('maintenances.store');
    Route::post('/assets/import/excel', [AssetController::class, 'importExcel'])->name('assets.importExcel');
    
    Route::post('/assets', [AssetController::class, 'store'])->name('assets.store');
    Route::put('/assets/{asset}', [AssetController::class, 'update'])->name('assets.update');
    Route::delete('/assets/{asset}', [AssetController::class, 'destroy'])->name('assets.destroy');
});

require __DIR__.'/auth.php';