<nav class="sidebar">
    <div class="sidebar-header">
        <h3>Pengaduan Masyarakat</h3>
        <span>Sistem Informasi Layanan</span>
    </div>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ Request::is('home') ? 'active' : '' }}" href="/home">
                <i class="bi bi-house-door-fill"></i>
                Home
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('notifikasi') ? 'active' : '' }}" href="/notifikasi">
                <i class="bi bi-bell-fill"></i>
                Notifikasi
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('riwayat') ? 'active' : '' }}" href="/riwayat">
                <i class="bi bi-clock-history"></i>
                Riwayat aduan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('pengaduan/create') || Request::is('pengaduan') ? 'active' : '' }}" href="/pengaduan/create">
                <i class="bi bi-plus-circle-fill"></i>
                ajukan pengaduan
            </a>
        </li>
    </ul>
</nav>
