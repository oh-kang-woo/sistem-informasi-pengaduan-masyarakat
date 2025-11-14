@extends('admin.layouts.app')

@section('title', 'Notifikasi Admin')

@push('styles')
<style>
body { background-color: #f7f9fc; font-family: 'Inter', sans-serif; }
.header-card { background: #fff; border-radius: 16px; padding: 1.5rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 3px 10px rgba(0,0,0,0.05); margin-bottom: 1.5rem; }
.header-card h4 { font-weight: 600; margin-bottom: 4px; }
.header-card p { color: #6c757d; font-size: 0.9rem; margin-bottom: 0; }
.stat-card { background: #fff; border-radius: 16px; padding: 1.25rem 1.5rem; box-shadow: 0 3px 8px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; transition: 0.2s ease; }
.stat-card:hover { transform: translateY(-2px); }
.stat-card h5 { margin-bottom: 4px; font-weight: 600; }
.stat-card p { margin: 0; color: #6c757d; font-size: 0.9rem; }
.stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; font-weight: bold; }
.stat-blue { background: #e7f0ff; color: #0d6efd; }
.stat-green { background: #eafaf1; color: #28a745; }
.stat-yellow { background: #fffbea; color: #ffc107; }
.stat-red { background: #fdecea; color: #dc3545; }
.filter-btn { border: none; background: #e9ecef; border-radius: 10px; padding: 6px 14px; margin: 5px; cursor: pointer; transition: 0.2s; font-size: 0.9rem; }
.filter-btn:hover { background: #dee2e6; }
.filter-btn.active { background: #0d6efd; color: #fff; }
.notif-box { background: #fff; border-radius: 10px; padding: 1.5rem; box-shadow: 0 3px 8px rgba(0,0,0,0.05); }
.notif-item { display: flex; justify-content: space-between; align-items: auto; padding: 0.75rem 0; border-bottom: 1px solid #f0f0f0; }
.notif-item:last-child { border-bottom: none; }
.notif-item h6 { margin: 0; font-weight: 600; color: #333; }
.notif-item p { margin: 0; color: #6c757d; font-size: 0.9rem; }
.notif-status { display: inline-block; width: 10px; height: 10px; border-radius: 50%; margin-top: 4px; } /* Bulat kecil tanpa teks */
.status-belum_dibaca { background: #ffc107; } /* kuning untuk belum dibaca */
.status-dibaca { background: #28a745; } /* hijau untuk dibaca */
.notif-actions button { margin-left: 6px; }
</style>
@endpush

@section('content')
<div class="header-card">
    <div>
        <h4>📢 Notifikasi Admin</h4>
        <p>Kelola semua notifikasi untuk admin</p>
    </div>
    <div>
        <form action="{{ route('admin.notifikasi.readAll') }}" method="POST" class="d-inline">
            @csrf
            @method('PATCH')
            <button class="btn btn-outline-secondary me-2">Tandai Semua Dibaca</button>
        </form>

        <form action="{{ route('admin.notifikasi.deleteAll') }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-outline-danger">Hapus Semua</button>
        </form>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div>
                <h5>{{ $total }}</h5>
                <p>Total Notifikasi</p>
            </div>
            <div class="stat-icon stat-blue">📨</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div>
                <h5>{{ $belum_dibaca }}</h5>
                <p>Belum Dibaca</p>
            </div>
            <div class="stat-icon stat-green">🔔</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div>
                <h5>{{ $hari_ini }}</h5>
                <p>Terkirim Hari Ini</p>
            </div>
            <div class="stat-icon stat-yellow">✅</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div>
                <h5>{{ $gagal }}</h5>
                <p>Gagal Kirim</p>
            </div>
            <div class="stat-icon stat-red">❌</div>
        </div>
    </div>
</div>

<div class="notif-box">
    @if($notifications->isEmpty())
        <p class="text-center text-muted mb-0">Tidak ada notifikasi.</p>
    @else
        @foreach($notifications as $notif)
        <div class="notif-item">
            <div>
                <h6>{{ $notif->judul }}</h6>
                <p>{{ $notif->pesan }}</p>
                <!-- Status badge diubah jadi bulat kecil tanpa teks -->
                <span class="notif-status status-{{ $notif->status }}"></span>
            </div>
            <div class="notif-actions">
                @if($notif->status === 'belum_dibaca')
                <form action="{{ route('admin.notifikasi.read', $notif->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-sm btn-success">Tandai Dibaca</button>
                </form>
                @endif
                <form action="{{ route('admin.notifikasi.destroy', $notif->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                </form>
            </div>
        </div>
        @endforeach
    @endif
</div>
@endsection
