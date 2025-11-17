@extends('layouts.app')

@section('title', 'Dashboard Pengguna')

@section('content')
<div class="container py-4">

    {{-- HEADER + TOMBOL TAMBAH --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Dashboard Kamu</h3>

        <a href="{{ route('pengaduan.create') }}" class="btn btn-primary px-4 py-2">
            + Tambah Laporan
        </a>
    </div>

    <div class="row g-4">

        <!-- Total Pengaduan -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="fw-bold">Total Pengaduan</h5>
                    <h2 class="text-primary fw-bold">{{ $totalPengaduan }}</h2>
                </div>
            </div>
        </div>

        <!-- Pengaduan Diproses -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="fw-bold">Sedang Diproses</h5>
                    <h2 class="text-warning fw-bold">{{ $diproses }}</h2>
                </div>
            </div>
        </div>

        <!-- Pengaduan Selesai -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="fw-bold">Selesai</h5>
                    <h2 class="text-success fw-bold">{{ $selesai }}</h2>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-4">

    <h4 class="fw-bold mb-3">Riwayat Pengaduan Terbaru</h4>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengaduanTerbaru as $p)
                        <tr>
                            <td>{{ $p->judul_pengaduan }}</td>
                            <td>{{ $p->kategori->nama_kategori ?? '-' }}</td>

                            <td>
                                <span class="badge
                                    @if($p->status == 'selesai') bg-success
                                    @elseif($p->status == 'diproses') bg-warning
                                    @else bg-secondary @endif
                                ">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td>{{ $p->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada pengaduan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
