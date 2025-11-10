<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// === Controller Import ===
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\Admin\PengaduanAdminController;
use App\Http\Controllers\Admin\NotifikasiController;

// === LANDING PAGE ===
Route::get('/', function () {
    return view('landingpage');
});

// === AUTH ===
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// === PENGADUAN (USER) ===


Route::get('/buat/laporan', [PengaduanController::class, 'create'])->name('pengaduan.create');
Route::post('/buat/laporan', [PengaduanController::class, 'store'])->name('pengaduan.store');



    // Pengaduan (Admin)
    Route::get('/pengaduan', [PengaduanAdminController::class, 'index'])->name('admin.pengaduan.index');
    Route::post('/pengaduan', [PengaduanAdminController::class, 'index'])->name('admin.pengaduan.index1');

    Route::get('/kategori', [KategoriController::class, 'index'])->name('admin.kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('admin.kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('admin.kategori.store');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('admin.kategori.edit');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('admin.kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('admin.kategori.destroy');
    Route::patch('/kategori/{id}/status', [KategoriController::class, 'toggleStatus'])->name('admin.kategori.toggleStatus');


    // Notifikasi System
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('admin.notifikasi.index');
    Route::patch('/notifikasi/{id}/read', [NotifikasiController::class, 'markAsRead'])->name('admin.notifikasi.read');
    Route::delete('/notifikasi/{id}', [NotifikasiController::class, 'destroy'])->name('admin.notifikasi.destroy');
    Route::patch('/notifikasi/read/all', [NotifikasiController::class, 'markAllRead'])->name('admin.notifikasi.readAll');
    Route::delete('/notifikasi/delete/all', [NotifikasiController::class, 'destroyAll'])->name('admin.notifikasi.deleteAll');
