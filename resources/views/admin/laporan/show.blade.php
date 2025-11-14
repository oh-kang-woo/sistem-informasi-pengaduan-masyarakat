@extends('admin.layouts.app')

@section('content')
<div class="container py-4">

    <h3 class="mb-4 fw-bold">Detail Laporan</h3>

    <div class="card shadow-sm p-4">

        <h4 class="fw-bold">{{ $pengaduan->judul_pengaduan }}</h4>
        <p class="text-muted">{{ $pengaduan->created_at->format('d M Y H:i') }}</p>

        <hr>

        <p><strong>Kategori:</strong> {{ $pengaduan->kategori->nama_kategori }}</p>
        <p><strong>Status:</strong> {{ $pengaduan->status }}</p>

        <p><strong>Isi Laporan:</strong></p>
        <p>{{ $pengaduan->isi_laporan }}</p>

        <hr>

        <h5 class="fw-bold mt-4">Data Pelapor</h5>
        <p><strong>Nama:</strong> {{ $pengaduan->user->nama ?? 'Tidak ditemukan' }}</p>
        <p><strong>Email:</strong> {{ $pengaduan->user->email ?? '-' }}</p>
        <p><strong>No HP:</strong> {{ $pengaduan->user->no_hp ?? '-' }}</p>

        @if ($pengaduan->bukti)
            <p class="mt-4"><strong>Bukti:</strong></p>
            <img
                src="{{ asset('storage/' . $pengaduan->bukti) }}"
                class="img-fluid rounded shadow"
                style="max-height: 350px; object-fit: contain;"
            >
        @else
            <p class="text-muted">Tidak ada bukti.</p>
        @endif

        <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary mt-4">
            Kembali
        </a>

    </div>
</div>
@endsection
