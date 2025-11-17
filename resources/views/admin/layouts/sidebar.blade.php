<nav class="admin-sidebar">
    <div>
        <div class="admin-sidebar-header">
            <h3>Dashboard Admin</h3>
        </div>

        <ul class="nav flex-column">
            <span class="nav-heading">MENU</span>

            {{-- Dashboard --}}
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}"
                   href="{{ route('admin.index') }}">
                    <i class="bi bi-speedometer2"></i>
                    Dashboard
                </a>
            </li>

            {{-- Manajemen Laporan --}}
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/laporan*') ? 'active' : '' }}"
                href="{{ route('admin.laporan.index') }}">
                    <i class="bi bi-journal-text"></i>
                    Manajemen Laporan
                </a>
            </li>

            {{-- Kategori --}}
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/kategori') ? 'active' : '' }}"
                   href="{{ route('admin.kategori.index') }}">
                    <i class="bi bi-tags-fill"></i>
                    Kategori Pengaduan
                </a>
            </li>

            {{-- Notifikasi --}}
           <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/notifikasi*') ? 'active' : '' }}"
                href="{{ route('admin.notifikasi.index') }}">
                    <i class="bi bi-bell-fill"></i>
                    Notifikasi
                    @if(isset($notifikasiCount) && $notifikasiCount > 0)
                        <span class="badge bg-danger ms-1">{{ $notifikasiCount }}</span>
                    @endif
                </a>
            </li>


            {{-- Laporan Cetak (optional) --}}
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-printer-fill"></i>
                    Laporan
                </a>
            </li>

            <span class="nav-heading">LAINNYA</span>

            {{-- Pengaturan --}}
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-gear-fill"></i>
                    Pengaturan
                </a>
            </li>

            {{-- Bantuan --}}
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-question-circle-fill"></i>
                    Bantuan
                </a>
            </li>
        </ul>
    </div>

    <div class="mt-auto">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link logout-link" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-left"></i>
                    Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</nav>
