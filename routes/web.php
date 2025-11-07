<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\Admin\PengaduanAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Pengaduan (User)
Route::get('/buat-laporan', [PengaduanController::class, 'create'])->name('pengaduan.create');
Route::post('/buat-laporan', [PengaduanController::class, 'store'])->name('pengaduan.store');

// Pengaduan (Admin)
Route::get('/admin/pengaduan', [PengaduanAdminController::class, 'index'])->name('admin.pengaduan.index');




    Route::get('/kategori', [KategoriController::class, 'index'])->name('admin.kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('admin.kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('admin.kategori.store');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('admin.kategori.edit');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('admin.kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('admin.kategori.destroy');
    Route::patch('/kategori/{id}/status', [KategoriController::class, 'toggleStatus'])->name('admin.kategori.toggleStatus');

