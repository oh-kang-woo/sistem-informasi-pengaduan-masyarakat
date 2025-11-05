@extends('admin.layouts.app')

@push('styles')
<style>
    /* Kustomisasi Kartu Kategori */
    .category-card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }

    /* Warna header kartu dinamis */
    .category-card .card-header {
        border-top-left-radius: 0.75rem;
        border-top-right-radius: 0.75rem;
        padding: 1rem 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 0;
        color: #fff; /* Teks putih */
    }

    .bg-card-orange { background-color: #F39C12; }
    .bg-card-yellow { background-color: #F1C40F; }
    .bg-card-green { background-color: #2ECC71; }
    .bg-card-blue { background-color: #3498DB; }
    .bg-card-purple { background-color: #9B59B6; }
    .bg-card-gray { background-color: #95A5A6; }

    .category-card .card-title {
        font-weight: 600;
        margin-bottom: 0;
    }

    .badge-status {
        font-size: 0.7rem;
        font-weight: 600;
        padding: 0.3em 0.6em;
        border-radius: 0.25rem;
    }
    .badge-aktif {
        background-color: rgba(255, 255, 255, 0.25);
        color: #fff;
    }
    .badge-nonaktif {
        background-color: rgba(0, 0, 0, 0.2);
        color: #f0f0f0;
    }

    .stat-item {
        text-align: center;
    }
    .stat-item .stat-number {
        font-size: 1.25rem;
        font-weight: 600;
        display: block;
    }
    .stat-item .stat-label {
        font-size: 0.8rem;
        color: #6c757d;
    }

    .btn-action-edit {
        background-color: #EBF5FF;
        color: #0D6EFD;
    }
    .btn-action-edit:hover {
        background-color: #cfe2ff;
    }
    .btn-action-hapus {
        background-color: #FFF0F1;
        color: #DC3545;
    }
    .btn-action-hapus:hover {
        background-color: #fce1e3;
    }

    .stat-card-top .card-body {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .stat-card-top .stat-icon {
        font-size: 2.5rem;
        padding: 1rem;
        border-radius: 50%;
        background-color: #f4f4f4;
    }
</style>
@endpush

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-1 text-white fw-bold">Kategori Pengaduan</h2>
        <p class="mb-0 text-white-50">Kelola kategori untuk mengorganisir pengaduan di sistem.</p>
    </div>
    <div>
        <a href="{{ route('admin.kategori.create') }}" class="btn btn-light shadow-sm">
            <i class="bi bi-plus-circle-fill me-2"></i>
            Tambah Kategori
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 stat-card-top">
            <div class="card-body">
                <div>
                    <h5 class="card-title text-muted small mb-1">Total Kategori</h5>
                    <p class="card-text fs-2 fw-bold mb-0">{{ $total_kategori }}</p>
                </div>
                <div class="stat-icon text-primary bg-primary-subtle">
                    <i class="bi bi-tags-fill"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 stat-card-top">
            <div class="card-body">
                <div>
                    <h5 class="card-title text-muted small mb-1">Kategori Aktif</h5>
                    <p class="card-text fs-2 fw-bold mb-0">{{ $total_aktif }}</p>
                </div>
                <div class="stat-icon text-success bg-success-subtle">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 stat-card-top">
            <div class="card-body">
                <div>
                    <h5 class="card-title text-muted small mb-1">Kategori Non-Aktif</h5>
                    <p class="card-text fs-2 fw-bold mb-0">{{ $total_nonaktif }}</p>
                </div>
                <div class="stat-icon text-danger bg-danger-subtle">
                    <i class="bi bi-x-circle-fill"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- FILTER --}}
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

{{-- DAFTAR KATEGORI --}}
<div class="row g-4">
    @forelse($kategori_list as $kategori)
        <div class="col-md-6 col-lg-4">
            <div class="card category-card h-100">
                <div class="card-header {{ $kategori->warna_kelas ?? 'bg-card-gray' }}">
                    <h5 class="card-title">{{ $kategori->nama_kategori }}</h5>
                    @if($kategori->status == 'aktif')
                        <span class="badge-status badge-aktif">AKTIF</span>
                    @else
                        <span class="badge-status badge-nonaktif">NON-AKTIF</span>
                    @endif
                </div>
                <div class="card-body">
                    <p class="card-text text-muted small mb-3">
                        {{ $kategori->deskripsi ?? 'Tidak ada deskripsi.' }}
                    </p>
                    <hr class="my-3">
                    <div class="d-flex justify-content-around">
                        <div class="stat-item">
                            <span class="stat-number">{{ $kategori->total_laporan ?? 0 }}</span>
                            <span class="stat-label">Total</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number text-success">{{ $kategori->laporan_selesai ?? 0 }}</span>
                            <span class="stat-label">Selesai</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number text-primary">{{ $kategori->laporan_proses ?? 0 }}</span>
                            <span class="stat-label">Proses</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center p-5">
                    <i class="bi bi-search fs-1 text-muted"></i>
                    <h4 class="mt-3">Data Tidak Ditemukan</h4>
                    <p class="text-muted">Tidak ada kategori yang sesuai dengan filter Anda.</p>
                </div>
            </div>
        </div>
    @endforelse
</div>

@endsection
