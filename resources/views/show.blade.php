@extends('layouts.app')

@section('title', 'Detail Pengaduan')

@section('content')
<div class="container-fluid px-4 py-5">

    {{-- HEADER --}}
    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1">{{ $pengaduan->judul_pengaduan }}</h2>
        <p class="text-muted small">
            Detail laporan yang kamu kirimkan, lengkap dengan informasi dan bukti.
        </p>
    </div>

    {{-- KOTAK STATUS --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body d-flex align-items-center">
            @php
                $statusColor = [
                    'Menunggu Verifikasi' => 'warning',
                    'Diproses' => 'info',
                    'Selesai' => 'success',
                    'Ditolak' => 'danger',
                ];
            @endphp

            <div class="me-3">
                <span class="badge bg-{{ $statusColor[$pengaduan->status] ?? 'secondary' }} px-3 py-2">
                    {{ $pengaduan->status }}
                </span>
            </div>

            <div>
                <h6 class="mb-0 fw-bold">Status Pengaduan</h6>
                <small class="text-muted">Pantau perkembangan laporanmu di sini.</small>
            </div>
        </div>
    </div>

    {{-- DETAIL LAPORAN --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">

            {{-- APA YANG DILAPORKAN --}}
            <h5 class="fw-bold mb-2">Apa yang kamu laporkan?</h5>
            <p class="text-dark">{{ $pengaduan->isi_laporan }}</p>

            <hr>

            <h6 class="fw-bold mt-3 mb-2">Detail Informasi</h6>

            <div class="row small">
                <div class="col-md-4 mb-2">
                    <strong>Kategori:</strong>
                    <span class="text-muted">
                        {{ $pengaduan->kategori->nama_kategori ?? '-' }}
                    </span>
                </div>

                <div class="col-md-4 mb-2">
                    <strong>Tanggal Lapor:</strong>
                    <span class="text-muted">
                        {{ $pengaduan->created_at->format('d F Y') }}
                    </span>
                </div>

                <div class="col-md-4 mb-2">
                    <strong>Lokasi Kejadian:</strong>
                    <span class="text-muted">{{ $pengaduan->lokasi_kejadian }}</span>
                </div>
            </div>

        </div>
    </div>

    {{-- BUKTI FOTO --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">

            <h5 class="fw-bold mb-3">Bukti Laporan</h5>

            @if($pengaduan->bukti)
                <div class="text-center">
                    <img src="{{ asset('storage/' . $pengaduan->bukti) }}"
                         class="img-fluid rounded shadow-sm"
                         style="
                            max-height: 380px;
                            width: 100%;
                            object-fit: contain;
                            background-color: #f8f9fa;
                            padding: 10px;
                         ">
                </div>
            @else
                <p class="text-muted">Tidak ada bukti diunggah.</p>
            @endif

        </div>
    </div>

    {{-- BATALKAN LAPORAN --}}
    @if($pengaduan->status == 'Menunggu Verifikasi')
        <div class="mb-4">
            <form action="{{ route('pengaduan.cancel', $pengaduan->id) }}"
                  method="POST"
                  onsubmit="return confirm('Batalkan pengaduan ini?');">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-danger px-4">
                    Batalkan Pengaduan
                </button>
            </form>
        </div>
    @endif

    {{-- BACK --}}
    <a href="{{ route('pengaduan.riwayat') }}" class="btn btn-secondary px-4">
        Kembali ke Riwayat
    </a>

</div>
@endsection
