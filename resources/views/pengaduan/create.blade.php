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

        <div class="alert alert-info d-flex align-items-center" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i>
            <div>
                Periksa semua data yang Anda isikan sudah benar. Laporan akan diverifikasi terlebih dahulu sebelum diproses.
            </div>
        </div>

        {{-- ✅ Perbaikan utama: ubah action ke route POST --}}
        <form action="{{route('pengaduan.store')}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="judul" class="form-label fw-medium">Judul Pengaduan <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan judul pengaduan Anda" required>
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
                <label for="lokasi" class="form-label fw-medium">Lokasi Kejadian <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Contoh: Jl. Ahmad Yani, Kelurahan Mandonga" required>
            </div>

            <div class="mb-3">
                <label for="isi_laporan" class="form-label fw-medium">Isi Laporan <span class="text-danger">*</span></label>
                <textarea class="form-control" id="isi_laporan" name="isi_laporan" rows="5" placeholder="Jelaskan secara detail pengaduan Anda..." required></textarea>
            </div>

            <div class="mb-3">
                <label for="bukti" class="file-drop-zone">
                    <i class="bi bi-cloud-arrow-up fs-1 text-secondary"></i><br>
                    <span class="file-msg">Klik untuk upload</span> atau drag & drop
                    <br>
                    <small class="text-muted">Format JPG, PNG, PDF (Max 5MB)</small>
                    <input type="file" class="file-input" id="bukti" name="bukti">
                </label>
            </div>

            <div class="mb-4">
                <label for="no_hp" class="form-label fw-medium">Nomor Telepon/WhatsApp</label>
                <input type="tel" class="form-control" id="no_hp" name="no_hp" placeholder="Contoh: 08123456789">
                <small class="form-text text-muted">Akan digunakan untuk menghubungi Anda jika diperlukan.</small>
            </div>

            <div class="alert alert-warning d-flex align-items-center" role="alert">
                <i class="bi bi-hourglass-split me-2"></i>
                <div>
                    <strong>Status pengaduan Anda:</strong> Menunggu Verifikasi
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <button type="reset" class="btn btn-light border">Reset</button>
                <button type="submit" class="btn btn-success px-4">Kirim Pengaduan</button>
            </div>

        </form>

    </div>
</div>

@endsection

@push('scripts')
<script>
    // ✅ Perbaikan: pakai id yang benar sesuai input file
    const fileInput = document.getElementById('bukti');
    const fileMsg = document.querySelector('.file-msg');

    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
            let fileNames = [];
            for(let i = 0; i < fileInput.files.length; i++) {
                fileNames.push(fileInput.files[i].name);
            }
            fileMsg.textContent = fileNames.join(', ');
        } else {
            fileMsg.textContent = 'Klik untuk upload atau drag & drop';
        }
    });
</script>
@endpush
