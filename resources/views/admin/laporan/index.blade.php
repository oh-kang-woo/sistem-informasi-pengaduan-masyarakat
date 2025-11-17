@extends('admin.layouts.app')

@section('content')

<h2 class="h3 mb-4 text-white fw-bold">Manajemen Pengaduan</h2>

{{-- Statistik --}}
<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h5 class="card-title text-muted small mb-1">Menunggu Verifikasi</h5>
                <p class="card-text fs-2 fw-bold mb-0">{{ $totalMenunggu }}</p>
                <small class="text-muted">Laporan baru</small>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h5 class="card-title text-muted small mb-1">Sedang Diproses</h5>
                <p class="card-text fs-2 fw-bold mb-0">{{ $totalProses }}</p>
                <small class="text-muted">Sedang ditindaklanjuti</small>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h5 class="card-title text-muted small mb-1">Selesai</h5>
                <p class="card-text fs-2 fw-bold mb-0">{{ $totalSelesai }}</p>
                <small class="text-success">Telah diselesaikan</small>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h5 class="card-title text-muted small mb-1">Ditolak</h5>
                <p class="card-text fs-2 fw-bold mb-0">{{ $totalDitolak }}</p>
                <small class="text-danger">Laporan tidak valid</small>
            </div>
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="{{ route('admin.laporan.index') }}" method="GET">
            <div class="row g-3">

                <div class="col-md-4">
                    <label class="form-label fw-medium">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                        <option value="Diproses">Sedang Diproses</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Ditolak">Ditolak</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-medium">Kategori</label>
                    <select name="kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoris as $kat)
                            <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-medium">Cari</label>
                    <input type="text" name="search" class="form-control" placeholder="Cari judul atau lokasi...">
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-purple w-100 py-2">
                    <i class="bi bi-funnel-fill me-2"></i>Filter
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Daftar Laporan --}}
<div class="card shadow-sm border-0 mt-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Laporan Masuk</h5>

        {{-- Tombol Hapus Semua --}}
        <form action="{{ route('admin.laporan.deleteAll') }}" method="POST"
            onsubmit="return confirm('Yakin hapus semua laporan?')" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-trash"></i> Hapus Semua
            </button>
        </form>

    </div>

    <div class="card-body">
        @if ($pengaduans->count())
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Judul Laporan</th>
                        <th>Kategori</th>
                        <th>Tgl Lapor</th>
                        <th>Status</th>
                        <th style="width: 1%; white-space: nowrap;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengaduans as $no => $laporan)
                        <tr>
                            <td>{{ $no + 1 }}</td>
                            <td>{{ $laporan->judul_pengaduan }}</td>
                            <td>{{ $laporan->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $laporan->created_at->format('d M Y') }}</td>
                           <td>
                                @switch($laporan->status)
                                    @case('Menunggu Verifikasi')
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                        @break

                                    @case('Diproses')
                                        <span class="badge bg-info text-dark">Diproses</span>
                                        @break

                                    @case('Selesai')
                                        <span class="badge bg-success">Selesai</span>
                                        @break

                                    @case('Ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                        @break

                                    @case('Dibatalkan')
                                        <span class="badge bg-secondary">Dibatalkan</span>
                                        @break

                                    @default
                                        <span class="badge bg-dark">-</span>
                                @endswitch
                            </td>

                            <td>
                                <div class="aksi-buttons">

                                    {{-- Tombol Lihat --}}
                                  <a href="{{ route('admin.laporan.show', $laporan->id) }}"
                                    class="btn btn-outline-primary btn-sm">Lihat </a>

                                    {{-- Dropdown Aksi --}}
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                            Detail
                                        </button>
                                        <ul class="dropdown-menu">
                                            @foreach (['Menunggu Verifikasi', 'Diproses', 'Selesai', 'Ditolak'] as $status)
                                                <li>
                                                   <form action="{{ route('admin.laporan.updateStatus', $laporan->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="{{ $status }}">
                                                        <button type="submit" class="dropdown-item">{{ $status }}</button>
                                                    </form>
                                                </li>
                                            @endforeach

                                            <li><hr class="dropdown-divider"></li>

                                            <li>
                                               <form action="{{ route('admin.laporan.destroy', $laporan->id) }}" method="POST"
                                                    onsubmit="return confirm('Yakin hapus laporan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center text-muted">Belum ada data laporan.</p>
        @endif
    </div>
</div>
@endsection
