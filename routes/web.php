<?php

use Illuminate\Support\Facades\Route;

// === Controller Import ===
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\Admin\PengaduanAdminController;
use App\Http\Controllers\Admin\NotifikasiController as AdminNotifikasiController;
use App\Http\Controllers\NotifikasiController as UserNotifikasiController;
use App\Http\Controllers\UserController;

// ======================================================================
// LANDING PAGE (public)
// ======================================================================
Route::get('/', fn() => view('landingpage'));


// ======================================================================
// AUTH (guest only)
// ======================================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});


// ======================================================================
// LOGOUT (auth only)
// ======================================================================
Route::middleware('auth')->post('/logout', [AuthController::class, 'logout'])->name('logout');


// ======================================================================
// USER ROUTES (auth + role:user)
// ======================================================================
Route::middleware(['auth', 'role:user'])->group(function () {

    Route::get('/dashboard-user', [UserController::class, 'userDashboard'])->name('dashboard.user');

    Route::prefix('buat/laporan')->group(function () {
        Route::get('/', [PengaduanController::class, 'create'])->name('pengaduan.create');
        Route::post('/', [PengaduanController::class, 'store'])->name('pengaduan.store');
    });

    Route::get('/riwayat/pengaduan', [PengaduanController::class, 'riwayat'])->name('pengaduan.riwayat');
    Route::get('/pengaduan/{id}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::patch('/pengaduan/cancel/{id}', [PengaduanController::class, 'cancel'])->name('pengaduan.cancel');

    // === Notifikasi User ===
    Route::prefix('user/notifikasi')->name('user.notifikasi.')->group(function () {
        Route::get('/', [UserNotifikasiController::class, 'index'])->name('index');
        Route::post('/mark-as-read/{id}', [UserNotifikasiController::class, 'markAsRead'])->name('markAsRead');
        Route::post('/mark-all', [UserNotifikasiController::class, 'markAll'])->name('markAll');
        Route::delete('/delete/{id}', [UserNotifikasiController::class, 'destroy'])->name('destroy');
        Route::delete('/delete-all', [UserNotifikasiController::class, 'deleteAll'])->name('deleteAll');
    });

});


// ======================================================================
// ADMIN ROUTES (auth + role:admin)
// ======================================================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

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

    // === Pengaduan Admin ===
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [PengaduanAdminController::class, 'manajemen'])->name('index');
        Route::get('/show/{id}', [PengaduanAdminController::class, 'show'])->name('show');
        Route::patch('/status/{id}', [PengaduanAdminController::class, 'updateStatus'])->name('updateStatus');
        Route::delete('/delete/{id}', [PengaduanAdminController::class, 'destroy'])->name('destroy');
        Route::delete('/delete-all', [PengaduanAdminController::class, 'deleteAll'])->name('deleteAll');
    });

    // === Kategori ===
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
