<?php

use Illuminate\Support\Facades\Route;

// === Controller Import ===
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\Admin\PengaduanAdminController;
use App\Http\Controllers\Admin\NotifikasiController as AdminNotifikasiController;
use App\Http\Controllers\NotifikasiController as UserNotifikasiController;

// ======================================================================
// LANDING PAGE
// ======================================================================
Route::get('/', function () {
    return view('landingpage');
});

// ======================================================================
// AUTH
// ======================================================================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ======================================================================
// USER ROUTES
// ======================================================================
Route::get('/buat/laporan', [PengaduanController::class,'create'])->name('pengaduan.create');
Route::post('/buat/laporan', [PengaduanController::class,'store'])->name('pengaduan.store');

// Notifikasi User
Route::prefix('user/notifikasi')->name('user.notifikasi.')->group(function () {
    Route::get('/', [UserNotifikasiController::class, 'index'])->name('index');
    Route::patch('/read/{id}', [UserNotifikasiController::class, 'markAsRead'])->name('read');
    Route::patch('/read-all', [UserNotifikasiController::class, 'markAll'])->name('readAll');
    Route::delete('/delete/{id}', [UserNotifikasiController::class, 'destroy'])->name('destroy');
    Route::delete('/delete-all', [UserNotifikasiController::class, 'deleteAll'])->name('deleteAll');
});

// ======================================================================
// ADMIN ROUTES
// ======================================================================
Route::prefix('admin')->name('admin.')->group(function () {

    // === Dashboard ===
    Route::get('/dashboard', [PengaduanAdminController::class, 'index'])->name('index');

    // === Notifikasi Admin ===
    Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
        Route::get('/', [AdminNotifikasiController::class, 'index'])->name('index');
        Route::patch('/read/{id}', [AdminNotifikasiController::class, 'read'])->name('read');
        Route::patch('/read-all', [AdminNotifikasiController::class, 'readAll'])->name('readAll');
        Route::delete('/delete/{id}', [AdminNotifikasiController::class, 'destroy'])->name('destroy');
        Route::delete('/delete-all', [AdminNotifikasiController::class, 'deleteAll'])->name('deleteAll');
    });

    // === Pengaduan / Laporan ===
    Route::prefix('laporan')->name('laporan.')->group(function () {

        // Halaman daftar laporan
        Route::get('/', [PengaduanAdminController::class, 'manajemen'])->name('index');

        // Detail laporan
        Route::get('/show/{id}', [PengaduanAdminController::class, 'show'])->name('show');

        // Update status
        Route::patch('/status/{id}', [PengaduanAdminController::class, 'updateStatus'])->name('updateStatus');

        // Hapus satu laporan
        Route::delete('/delete/{id}', [PengaduanAdminController::class, 'destroy'])->name('destroy');

        // Hapus semua laporan
        Route::delete('/delete-all', [PengaduanAdminController::class, 'deleteAll'])->name('deleteAll');
    });

    // === Kategori Pengaduan ===
    Route::prefix('kategori')->name('kategori.')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('index');
        Route::get('/create', [KategoriController::class, 'create'])->name('create');
        Route::post('/', [KategoriController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('edit');
        Route::put('/{id}', [KategoriController::class, 'update'])->name('update');
        Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/status', [KategoriController::class, 'toggleStatus'])->name('toggleStatus');
    });
});
