@extends('admin.layouts.app')

@section('content')

<a href="{{ route('admin.kategori.index') }}" class="btn btn-light btn-sm shadow-sm mb-3">
    <i class="bi bi-arrow-left me-1"></i>
    Kembali ke kategori Kategori
</a>

<h2 class="h3 mb-4 text-white fw-bold">Tambah Kategori Baru</h2>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4 p-md-5">

                <form action="{{ route('admin.kategori.store') }}" method="POST">
                    @csrf <div class="mb-3">
                        <label for="nama_kategori" class="form-label fw-medium">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Contoh: Jalan Rusak" required>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-medium">Deskripsi Singkat <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Jelaskan kategori ini secara singkat..." required></textarea>
                    </div>

                    <div class="mb-3">
                         <label for="warna_kelas" class="form-label fw-medium">Warna Kartu <span class="text-danger">*</span></label>
                        <select class="form-select" id="warna_kelas" name="warna_kelas" required>
                            <option value="" selected disabled>Pilih warna</option>
                            <option value="bg-card-orange">Oranye</option>
                            <option value="bg-card-yellow">Kuning</option>
                            <option value="bg-card-green">Hijau</option>
                            <option value="bg-card-blue">Biru</option>
                            <option value="bg-card-purple">Ungu</option>
                            <option value="bg-card-gray">Abu-abu</option>
                        </select>
                        <small class="form-text text-muted">Warna ini akan tampil di header kartu.</small>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label fw-medium">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="aktif" selected>Aktif</option>
                            <option value="nonaktif">Non-Aktif</option>
                        </select>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.kategori.index') }}" class="btn btn-light border">Batal</a>
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-save-fill me-2"></i>
                            Simpan Kategori
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection
