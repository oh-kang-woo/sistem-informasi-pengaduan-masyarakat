<nav class="sidebar">
    <div class="sidebar-header">
        <h3>Pengaduan Masyarakat</h3>
        <span>Sistem Informasi Layanan</span>
    </div>

   @php
    $notifCount = \App\Models\UserNotification::where('receiver_id', auth()->id())
                    ->where('status', 'unread')
                    ->count();
    @endphp


    <ul class="nav flex-column">

        <!-- HOME -->
        <li class="nav-item">
            <a class="nav-link {{ Request::is('home') ? 'active' : '' }}"
               href="{{ route('dashboard.user') }}">
                <i class="bi bi-house-door-fill"></i>
                Home
            </a>
        </li>

        <!-- NOTIFIKASI -->
       <li class="nav-item">
            <a class="nav-link" href="{{ route('user.notifikasi.index') }}">
                🔔 Notifikasi
                @if($notifCount > 0)
                    <span class="badge bg-danger">{{ $notifCount }}</span>
                @endif
            </a>
        </li>
        <!-- RIWAYAT -->
        <li class="nav-item">
            <a class="nav-link {{ Request::is('riwayat') ? 'active' : '' }}"
               href="{{ route('pengaduan.riwayat') }}">
                <i class="bi bi-clock-history"></i>
                Riwayat Aduan
            </a>
        </li>

        <!-- AJUKAN -->
        <li class="nav-item">
            <a class="nav-link
                    {{ Request::is('pengaduan/create') || Request::is('pengaduan') ? 'active' : '' }}"
               href="{{ route('pengaduan.create') }}">
                <i class="bi bi-plus-circle-fill"></i>
                Ajukan Pengaduan
            </a>
        </li>

    </ul>
</nav>
