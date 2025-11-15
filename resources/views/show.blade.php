@extends('layouts.app')

@section('title', 'Detail Pengaduan')

@section('content')
<div class="container-fluid px-4 py-5">

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="fw-bold">{{ $pengaduan->judul_pengaduan }}</h4>
            <span class="badge bg-{{ $pengaduan->status=='Menunggu Verifikasi'?'warning':($pengaduan->status=='Sedang Diproses'?'info':($pengaduan->status=='Selesai'?'success':'danger')) }}">
                {{ $pengaduan->status }}
            </span>

            <p class="mt-3">{{ $pengaduan->isi_laporan }}</p>
            <div class="d-flex flex-wrap small text-muted mb-3">
                <span class="me-3">📅 {{ $pengaduan->created_at->format('d F Y') }}</span>
                <span class="me-3">🏷️ {{ $pengaduan->kategori->nama }}</span>
                <span>📍 {{ $pengaduan->lokasi_kejadian }}</span>
            </div>

            {{-- Timeline --}}
            <div class="timeline-status mt-4">
                <h6 class="small text-uppercase fw-bold">Timeline Status</h6>
                @forelse($pengaduan->timeline as $tl)
                    <div class="mb-2">
                        <strong>{{ $tl->status_deskripsi }}</strong>
                        <span class="small text-muted">{{ $tl->created_at->format('d F Y, H:i') }}</span>
                        @if($tl->catatan)
                            <p class="small mb-0">{{ $tl->catatan }}</p>
                        @endif
                    </div>
                @empty
                    <p class="small text-muted mb-0">Belum ada progres timeline.</p>
                @endforelse
            </div>

            {{-- Tombol Batalkan jika status Menunggu --}}
            @if($pengaduan->status=='Menunggu Verifikasi')
                <form action="{{ route('pengaduan.cancel', $pengaduan->id) }}" method="POST" class="mt-3"
                      onsubmit="return confirm('Anda yakin ingin membatalkan pengaduan ini?');">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger">Batalkan Pengaduan</button>
                </form>
            @endif

        </div>
    </div>

    <a href="{{ route('pengaduan.riwayat') }}" class="btn btn-secondary">Kembali ke Riwayat</a>

</div>
@endsection
