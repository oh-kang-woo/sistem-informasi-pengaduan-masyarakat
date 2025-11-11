<nav class="admin-sidebar">
    <div>
        <div class="admin-sidebar-header">
            <h3>Dasboard Admin</h3>
        </div>

        <ul class="nav flex-column">
            <span class="nav-heading">MENU</span>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}" href="{{route('admin.pengaduan.index')}}">
                    <i class="bi bi-speedometer2"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is(  'admin/laporan') ? 'active' : '' }}" href="{{ route('admin.laporan.index') }}">
                    <i class="bi bi-journal-text"></i>
                    Manajemen laporan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/kategori') ? 'active' : '' }}" href="{{route('admin.kategori.index')}}">
                    <i class="bi bi-tags-fill"></i>
                    Kategori Pengaduan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/notifikasi') ? 'active' : '' }}" href="{{route('admin.notifikasi.index')}}">
                    <i class="bi bi-bell-fill"></i>
                    Notifikasi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/laporan-cetak') ? 'active' : '' }}" href="#">
                    <i class="bi bi-printer-fill"></i>
                    Laporan
                </a>
            </li>

            <span class="nav-heading">LAINNYA</span>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/pengaturan') ? 'active' : '' }}" href="#">
                    <i class="bi bi-gear-fill"></i>
                    Pengaturan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/bantuan') ? 'active' : '' }}" href="#">
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
