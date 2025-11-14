@extends('layouts.app')

@section('content')
<div class="card form-card">
    <div class="card-body p-4 p-md-5">
        <div class="d-flex align-items-center mb-4">
            <div class="me-3">
                <span class="bg-success-subtle text-success p-3 rounded-circle d-inline-flex align-items-center justify-content-center">
                    <i class="bi bi-pencil-square fs-4"></i>
                </span>
            </div>
            <div>
                <h2 class="h4 mb-0">Buat Laporan Pengaduan</h2>
                <p class="text-muted mb-0">Sampaikan keluhan atau laporan Anda kepada kami</p>
            </div>
        </div>

        <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="judul_pengaduan" class="form-label fw-medium">Judul Pengaduan <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="judul_pengaduan" name="judul_pengaduan" placeholder="Masukkan judul pengaduan Anda" required>
            </div>

            <div class="mb-3">
                <label for="kategori_id" class="form-label fw-medium">Kategori Pengaduan <span class="text-danger">*</span></label>
                <select class="form-select" id="kategori_id" name="kategori_id" required>
                    <option value="" selected disabled>Pilih Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="lokasi_kejadian" class="form-label fw-medium">Lokasi Kejadian <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="lokasi_kejadian" name="lokasi_kejadian" placeholder="Contoh: Jl. Ahmad Yani, Kelurahan Mandonga" required>
            </div>

            <div class="mb-3">
                <label for="isi_laporan" class="form-label fw-medium">Isi Laporan <span class="text-danger">*</span></label>
                <textarea class="form-control" id="isi_laporan" name="isi_laporan" rows="5" placeholder="Jelaskan secara detail pengaduan Anda..." required></textarea>
            </div>

            <div class="mb-3">
                <label for="bukti" class="form-label">Bukti (Opsional)</label>
                <input type="file" class="form-control" id="bukti" name="bukti" accept=".jpg,.jpeg,.png,.pdf">
                <small class="text-muted">Format JPG, PNG, PDF (Max 5MB)</small>
            </div>
            @php
                $nohp = auth()->user()->no_hp;
            @endphp

            <div class="mb-3">
                <label class="form-label fw-medium">Nomor Telepon/WhatsApp <span class="text-danger">*</span></label>

                @if($nohp)
                    <!-- User SUDAH punya no_hp → tampil readonly -->
                    <input type="text" class="form-control" value="{{ $nohp }}" readonly>
                    <input type="hidden" name="no_hp" value="{{ $nohp }}">
                @else
                    <!-- User BARU → boleh isi -->
                    <input
                        type="text"
                        class="form-control"
                        name="no_hp"
                        placeholder="Contoh: 08123456789"
                        required
                    >
                @endif
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="reset" class="btn btn-light border">Reset</button>
                <button type="submit" class="btn btn-success px-4">Kirim Pengaduan</button>
            </div>
        </form>
    </div>
</div>
@endsection
