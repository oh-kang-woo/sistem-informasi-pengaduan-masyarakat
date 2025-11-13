<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// === Controller Import ===
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\Admin\PengaduanAdminController;
use App\Http\Controllers\Admin\NotifikasiController as AdminNotifikasiController;
use App\Http\Controllers\User\NotifikasiController as UserNotifikasiController;

// === LANDING PAGE ===
Route::get('/', function () {
    return view('landingpage');
});

// === AUTH ROUTES ===
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// === USER ROUTES ===

    // Form & store pengaduan
    Route::get('/buat/laporan', [PengaduanController::class,'create'])->name('pengaduan.create');
    Route::post('/buat/laporan', [PengaduanController::class,'store'])->name('pengaduan.store');


    // === USER ROUTES ===

        Route::get('user/notifikasi', [UserNotifikasiController::class, 'index'])->name('user.notifikasi.index');
        Route::patch('user/notifikasi/read/{notification}', [UserNotifikasiController::class, 'read'])->name('user.notifikasi.read');
        Route::delete('user/notifikasi/{notification}', [UserNotifikasiController::class, 'destroy'])->name('user.notifikasi.destroy');
        Route::patch('user/notifikasi/readAll', [UserNotifikasiController::class, 'readAll'])->name('user.notifikasi.readAll');
        Route::delete('user/notifikasi/deleteAll', [UserNotifikasiController::class, 'deleteAll'])->name('user.notifikasi.deleteAll');

// === ADMIN ROUTES ===

 // === ADMIN ROUTES ===
Route::prefix('admin')->name('admin.')->group(function () {
    // Notifikasi admin
    Route::get('/notifikasi', [AdminNotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::patch('/notifikasi/read/{notification}', [AdminNotifikasiController::class, 'read'])->name('notifikasi.read');
    Route::delete('/notifikasi/{notification}', [AdminNotifikasiController::class, 'destroy'])->name('notifikasi.destroy');
    Route::patch('/notifikasi/readAll', [AdminNotifikasiController::class, 'readAll'])->name('notifikasi.readAll');
    Route::delete('/notifikasi', [AdminNotifikasiController::class, 'deleteAll'])->name('notifikasi.deleteAll');
});


    // Pengaduan admin
    Route::get('/pengaduan', [PengaduanAdminController::class, 'index'])->name('admin.index');
    Route::post('/pengaduan', [PengaduanAdminController::class, 'index'])->name('admin.pengaduan.index1');
    Route::get('/manajemen/pengaduan', [PengaduanAdminController::class, 'manajemen'])->name('admin.laporan.index');
    Route::patch('/pengaduan/{id}/update-status', [PengaduanAdminController::class, 'updateStatus'])->name('admin.pengaduan.updateStatus');
    Route::delete('/pengaduan/{id}', [PengaduanAdminController::class, 'destroy'])->name('admin.pengaduan.destroy');
    Route::delete('admin/pengaduan/deleteAll', [PengaduanAdminController::class, 'deleteAll'])->name('admin.pengaduan.deleteAll');


    // Kategori pengaduan
    Route::get('/kategori', [KategoriController::class, 'index'])->name('admin.kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('admin.kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('admin.kategori.store');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('admin.kategori.edit');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('admin.kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('admin.kategori.destroy');
    Route::patch('/kategori/{id}/status', [KategoriController::class, 'toggleStatus'])->name('admin.kategori.toggleStatus');
