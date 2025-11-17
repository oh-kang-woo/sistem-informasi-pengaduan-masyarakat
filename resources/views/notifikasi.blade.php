@extends('layouts.app')

@section('title', 'Notifikasi User')

@section('content')
<div class="container py-5" style="max-width: 1200px; margin:auto;">

    <!-- HEADER RATA KIRI -->
    <div class="mb-4">
        <h3 class="fw-bold mb-1">🔔 Notifikasi</h3>
        <p class="text-muted">Pantau status pengajuan dan informasi penting</p>
    </div>

    <!-- SUMMARY CARD -->
    <div class="row g-4 mb-5 justify-content-center">

        <!-- Total Notifikasi -->
        <div class="col-md-4">
            <div class="p-4 rounded-4 shadow-sm border-2 border-primary"
                style="background:#eef4ff; border-color:#3b82f6;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary p-3 text-white d-flex align-items-center justify-content-center"
                        style="width:55px;height:55px;">
                        <i class="bi bi-bell fs-4"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">{{ $total }}</h3>
                        <small class="text-muted">Total Notifikasi</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Belum Dibaca -->
        <div class="col-md-4">
            <div class="p-4 rounded-4 shadow-sm" style="background:#e7ffe7;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-white shadow-sm p-3 d-flex align-items-center justify-content-center"
                        style="width:55px;height:55px; color:#fbbf24;">
                        <i class="bi bi-exclamation-circle fs-4"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">{{ $belumDibaca }}</h3>
                        <small class="text-muted">Belum Dibaca</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Perlu Tindakan -->
        <div class="col-md-4">
            <div class="p-4 rounded-4 shadow-sm" style="background:#ffe7e7;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-white shadow-sm p-3 d-flex align-items-center justify-content-center"
                        style="width:55px;height:55px; color:#ef4444;">
                        <i class="bi bi-exclamation-triangle fs-4"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">{{ $perluTindakan }}</h3>
                        <small class="text-muted">Perlu Tindakan</small>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- END SUMMARY CARD -->

    <!-- HEADER LIST -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Daftar Notifikasi</h4>
        <button class="btn btn-danger btn-sm px-3"
            onclick="confirmDelete('{{ route('user.notifikasi.deleteAll') }}')">
            Hapus Semua
        </button>
    </div>

    <!-- LIST NOTIFIKASI -->
    @if($notifications->count() == 0)
        <div class="alert alert-info text-center">Tidak ada notifikasi.</div>
    @else
        @foreach($notifications as $notif)
        @php
            // Tentukan warna berdasarkan status pengaduan di judul/pesan
            $color = 'secondary';
            if(str_contains(strtolower($notif->judul), 'diproses') || str_contains(strtolower($notif->pesan), 'diproses')) {
                $color = 'primary';
            } elseif(str_contains(strtolower($notif->judul), 'selesai') || str_contains(strtolower($notif->pesan), 'selesai')) {
                $color = 'success';
            } elseif(str_contains(strtolower($notif->judul), 'ditolak') || str_contains(strtolower($notif->pesan), 'ditolak')) {
                $color = 'danger';
            }
        @endphp
        <div class="card shadow-sm border-0 mb-3 border-start border-4 border-{{ $color }}">
            <div class="card-body d-flex justify-content-between align-items-start">
                <div class="me-3">
                    <h6 class="fw-bold">{{ $notif->judul }}</h6>
                    <p class="mb-1">{{ $notif->pesan }}</p>
                    <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                </div>
                <div class="d-flex flex-column gap-2">
                    <form action="{{ route('user.notifikasi.markAsRead', $notif->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-outline-primary" type="submit">Tandai Dibaca</button>
                    </form>
                    <button class="btn btn-outline-danger btn-sm"
                        onclick="confirmDelete('{{ route('user.notifikasi.destroy', $notif->id) }}')">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    @endif

</div>

<!-- Modal Hapus -->
<div class="modal fade" id="modalHapus" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus notifikasi ini?
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="formHapus" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<script>
    function confirmDelete(url) {
        document.getElementById('formHapus').action = url;
        let modal = new bootstrap.Modal(document.getElementById('modalHapus'));
        modal.show();
    }
</script>
@endpush
