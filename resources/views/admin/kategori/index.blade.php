@extends('admin.layouts.app')

@push('styles')
<style>
    /* === Warna gradasi (Akan diterapkan di .card-header & .modal-header) === */
    .bg-card-orange { background: linear-gradient(135deg, #f39c12, #f1c40f) !important; color: #fff !important; }
    .bg-card-yellow { background: linear-gradient(135deg, #f1c40f, #f9e79f) !important; color: #000 !important; }
    .bg-card-green  { background: linear-gradient(135deg, #27ae60, #2ecc71) !important; color: #fff !important; }
    .bg-card-blue   { background: linear-gradient(135deg, #2980b9, #3498db) !important; color: #fff !important; }
    .bg-card-purple { background: linear-gradient(135deg, #8e44ad, #9b59b6) !important; color: #fff !important; }
    .bg-card-gray   { background: linear-gradient(135deg, #7f8c8d, #95a5a6) !important; color: #fff !important; }

    /* === Kustomisasi Kartu === */
    .category-card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        overflow: hidden;
        background: #fff !important;
    }
    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .category-card .card-header {
        border: none;
        padding: 1.5rem;
        position: relative;
        border-radius: 0.75rem 0.75rem 0 0;
        min-height: 110px;
        display: flex;
        align-items: flex-start;
    }

    .category-icon {
        position: absolute;
        top: 1.5rem;
        left: 1.5rem;
        font-size: 1.8rem;
        line-height: 1;
        color: inherit;
        opacity: 0.9;
    }

    .header-content {
        margin-left: 55px;
        width: 100%;
    }
    .header-content h5 {
        color: inherit !important;
        margin-bottom: 0.25rem;
        padding-top: 2px;
    }

    .badge-status {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.3em 0.6em;
        border-radius: 0.25rem;
        background-color: rgba(255,255,255,0.25);
        color: #fff;
    }
    .bg-card-yellow .badge-status {
        background-color: rgba(0,0,0,0.1);
        color: #000;
    }

    /* === Body Kartu === */
    .category-card .card-body {
        padding: 1.5rem;
        background: #fff;
        color: #333;
    }
    .category-card .card-body p {
        color: #6c757d;
    }

    .stat-item { text-align: center; }
    .stat-number { font-size: 1.5rem; font-weight: 700; display: block; color: #212529; }
    .stat-label { font-size: 0.8rem; text-transform: uppercase; display: block; opacity: 0.9; color: #6c757d; }

    .btn-action-edit, .btn-action-hapus {
        font-weight: 600;
        border: none;
        border-radius: 0.5rem;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
    }
    .btn-action-edit {
        background-color: #e7f1ff;
        color: #0D6EFD;
    }
    .btn-action-hapus {
        background-color: #fdefee;
        color: #DC3545;
    }
    .btn-action-edit:hover { background-color: #d1e3ff; }
    .btn-action-hapus:hover { background-color: #fbdce0; }

    /* === Header Halaman === */
    .page-header {
        color: #fff;
        background: linear-gradient(90deg, #2563eb, #06b6d4);
        padding: 1.5rem;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
    }

    /* ========================================= */
    /* === MODIFIKASI MODAL EDIT (BARU) === */
    /* ========================================= */
    #editKategoriModal .modal-content {
        border: none;
        border-radius: 0.75rem; /* Cocokkan dengan radius kartu */
        overflow: hidden; /* Penting untuk header gradien */
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    }

    #editKategoriModal .modal-header {
        border-bottom: none; /* Hapus garis default */
        transition: background-color 0.3s ease;
    }

    /* Judul modal akan mewarisi warna (putih/hitam) dari header */
    #editKategoriModal .modal-header .modal-title {
        color: inherit;
        font-weight: 600;
    }
</style>
@endpush

@section('content')

{{-- Header Halaman, Statistik, dan Filter (Tidak Berubah) --}}
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2 class="h4 fw-bold mb-1">Manajemen Kategori Pengaduan</h2>
        <p class="mb-0 text-white-50">Kelola kategori untuk mengorganisir pengaduan di sistem Jari – Jaga Kendari</p>
    </div>
    <button type="button" class="btn btn-light shadow-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#tambahKategoriModal">
        <i class="bi bi-plus-circle-fill me-2"></i> Tambah Kategori
    </button>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Total Kategori</h6>
                    <h4 class="fw-bold mb-0">{{ $total_kategori ?? 6 }}</h4>
                </div>
                <i class="bi bi-tags-fill fs-2 text-primary"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Aktif</h6>
                    <h4 class="fw-bold mb-0 text-success">{{ $total_aktif ?? 5 }}</h4>
                </div>
                <i class="bi bi-check-circle-fill fs-2 text-success"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Non-Aktif</h6>
                    <h4 class="fw-bold mb-0 text-danger">{{ $total_nonaktif ?? 1 }}</h4>
                </div>
                <i class="bi bi-x-circle-fill fs-2 text-danger"></i>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form action="{{ route('admin.kategori.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label for="searchKategori" class="form-label">Cari Kategori</label>
                    <input type="text" class="form-control" name="search" id="searchKategori" placeholder="Ketik nama kategori..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label for="filterStatus" class="form-label">Status</label>
                    <select id="filterStatus" name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel-fill me-2"></i>Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Daftar Kategori (Tidak Berubah) --}}
<div class="row g-4">
    @forelse($kategori_list as $kategori)
        <div class="col-md-6 col-lg-4">
            <div class="card category-card h-100">
                <div class="card-header {{ $kategori->warna_kelas ?? 'bg-card-gray' }}">
                    <i class="category-icon
                        @if ($kategori->warna_kelas == 'bg-card-orange') bi bi-geo-alt-fill
                        @elseif ($kategori->warna_kelas == 'bg-card-yellow') bi bi-lightbulb-fill
                        @elseif ($kategori->warna_kelas == 'bg-card-green') bi bi-trash-fill
                        @elseif ($kategori->warna_kelas == 'bg-card-blue') bi bi-building-fill
                        @elseif ($kategori->warna_kelas == 'bg-card-purple') bi bi-arrow-down-up
                        @else bi bi-grid-fill @endif">
                    </i>
                    <div class="header-content d-flex justify-content-between align-items-start">
                        <h5 class="fw-bold">{{ $kategori->nama_kategori }}</h5>
                        <span class="badge-status">{{ strtoupper($kategori->status) }}</span>
                    </div>
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="small mb-3">{{ $kategori->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                    <div class="d-flex justify-content-around mb-3">
                        <div class="stat-item">
                            <span class="stat-number">{{ $kategori->total_laporan ?? 0 }}</span>
                            <span class="stat-label">Total</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">{{ $kategori->laporan_selesai ?? 0 }}</span>
                            <span class="stat-label">Selesai</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">{{ $kategori->laporan_proses ?? 0 }}</span>
                            <span class="stat-label">Proses</span>
                        </div>
                    </div>
                    <div class="mt-auto d-flex gap-2">
                        <button
                            type="button"
                            class="btn btn-action-edit w-100 btn-edit-kategori"
                            data-id="{{ $kategori->id }}"
                            data-nama="{{ $kategori->nama_kategori }}"
                            data-deskripsi="{{ $kategori->deskripsi }}"
                            data-warna="{{ $kategori->warna_kelas }}"
                            data-status="{{ $kategori->status }}">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </button>
                        <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="POST" class="w-100" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-action-hapus w-100">
                                <i class="bi bi-trash3 me-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card shadow-sm border-0 text-center p-5">
                <i class="bi bi-search fs-1 text-muted"></i>
                <h4 class="mt-3">Data Tidak Ditemukan</h4>
                <p class="text-muted">Tidak ada kategori yang sesuai dengan filter Anda.</p>
            </div>
        </div>
    @endforelse
</div>


{{-- ====================================================================== --}}
{{-- ======================== MODAL TAMBAH & EDIT ======================= --}}
{{-- ====================================================================== --}}


{{-- Modal Tambah (Tidak Berubah) --}}
<div class="modal fade" id="tambahKategoriModal" tabindex="-1" aria-labelledby="tambahKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahKategoriModalLabel">Tambah Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="warna_kelas" class="form-label">Warna Kartu</label>
                        <select class="form-select" id="warna_kelas" name="warna_kelas">
                            <option value="bg-card-orange">Oranye (Jalan Rusak)</option>
                            <option value="bg-card-yellow">Kuning (Lampu Jalan)</option>
                            <option value="bg-card-green">Hijau (Kebersihan)</option>
                            <option value="bg-card-blue">Biru (Fasilitas Umum)</option>
                            <option value="bg-card-purple">Ungu (Drainase)</option>
                            <option value="bg-card-gray" selected>Abu-abu (Lainnya)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="aktif" selected>Aktif</option>
                            <option value="nonaktif">Non-Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- Modal Edit (HTML Tidak Berubah, tapi CSS dan JS akan menatanya) --}}
<div class="modal fade" id="editKategoriModal" tabindex="-1" aria-labelledby="editKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editKategoriModalLabel">Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditKategori" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="edit_nama_kategori" name="nama_kategori" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_warna_kelas" class="form-label">Warna Kartu</label>
                        <select class="form-select" id="edit_warna_kelas" name="warna_kelas">
                            <option value="bg-card-orange">Oranye (Jalan Rusak)</option>
                            <option value="bg-card-yellow">Kuning (Lampu Jalan)</option>
                            <option value="bg-card-green">Hijau (Kebersihan)</option>
                            <option value="bg-card-blue">Biru (Fasilitas Umum)</option>
                            <option value="bg-card-purple">Ungu (Drainase)</option>
                            <option value="bg-card-gray">Abu-abu (Lainnya)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status</label>
                        <select class="form-select" id="edit_status" name="status">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Non-Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>


@push('scripts')
{{-- ========================================================== --}}
{{-- === MODIFIKASI SCRIPT UNTUK MODAL HEADER DINAMIS === --}}
{{-- ========================================================== --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.btn-edit-kategori');
    const formEdit = document.getElementById('formEditKategori');

    // Ambil elemen modal di luar loop untuk efisiensi
    const editModalEl = document.getElementById('editKategoriModal');
    const modalHeader = editModalEl.querySelector('.modal-header');
    const modalBtnClose = modalHeader.querySelector('.btn-close');
    const bootstrapModal = new bootstrap.Modal(editModalEl); // Inisialisasi modal sekali

    // Daftar semua kelas warna yang mungkin
    const colorClasses = [
        'bg-card-orange', 'bg-card-yellow', 'bg-card-green',
        'bg-card-blue', 'bg-card-purple', 'bg-card-gray'
    ];

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Ambil data dari tombol
            const id = this.dataset.id;
            const nama = this.dataset.nama;
            const deskripsi = this.dataset.deskripsi;
            const warna = this.dataset.warna;
            const status = this.dataset.status;

            // --- MODIFIKASI DINAMIS HEADER MODAL ---

            // 1. Hapus semua kelas warna sebelumnya dari header
            modalHeader.classList.remove(...colorClasses);

            // 2. Tambahkan kelas warna yang baru (jika ada)
            if (warna) {
                modalHeader.classList.add(warna);
            }

            // 3. Atur tombol close (X) agar terlihat
            //    Jika warna 'bg-card-yellow', teksnya hitam, jadi tombol close standar
            //    Jika warna lain, teksnya putih, jadi tombol close butuh '.btn-close-white'
            if (warna === 'bg-card-yellow') {
                modalBtnClose.classList.remove('btn-close-white');
            } else {
                modalBtnClose.classList.add('btn-close-white');
            }
            // --- AKHIR MODIFIKASI ---

            // Mengatur action form dengan URL update yang benar
            formEdit.action = `{{ route('admin.kategori.update', ':id') }}`.replace(':id', id);

            // Mengisi nilai-nilai form
            document.getElementById('edit_nama_kategori').value = nama;
            document.getElementById('edit_deskripsi').value = deskripsi;
            document.getElementById('edit_warna_kelas').value = warna;
            document.getElementById('edit_status').value = status;

            // Menampilkan modal
            bootstrapModal.show();
        });
    });

    // Opsional: Saat modal ditutup, reset header ke tampilan default
    editModalEl.addEventListener('hidden.bs.modal', function () {
        modalHeader.classList.remove(...colorClasses);
        modalBtnClose.classList.remove('btn-close-white');
    });
});
</script>
@endpush

@endsection
