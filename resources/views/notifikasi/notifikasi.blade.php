@extends('admin.layouts.app')

@section('content')
<h2 class="h3 mb-4 text-white fw-bold">Notifikasi Admin</h2>

<div class="mb-3 d-flex justify-content-between">
    <div>
        <form action="{{ route('admin.notifikasi.readAll') }}" method="POST" class="d-inline">
            @csrf
            @method('PATCH')
            <button class="btn btn-sm btn-success">Tandai Semua Dibaca</button>
        </form>

        <form action="{{ route('admin.notifikasi.deleteAll') }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger">Hapus Semua</button>
        </form>
    </div>
</div>

<div class="list-group">
    @forelse($notifications as $notif)
        <div class="list-group-item d-flex justify-content-between align-items-center {{ $notif->status == 'belum_dibaca' ? 'bg-light' : '' }}">
            <div>
                <h6 class="mb-1">{{ $notif->judul ?? 'Notifikasi' }}</h6>
                <p class="mb-0">{{ $notif->pesan ?? '-' }}</p>
                <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
            </div>
            <div class="d-flex gap-2">
                @if($notif->status == 'belum_dibaca')
                    <form action="{{ route('admin.notifikasi.read', $notif->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-sm btn-success">Tandai Dibaca</button>
                    </form>
                @endif
                <form action="{{ route('admin.notifikasi.destroy', $notif->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-center text-muted">Tidak ada notifikasi.</p>
    @endforelse
</div>
@endsection
