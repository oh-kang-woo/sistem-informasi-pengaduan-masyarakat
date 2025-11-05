<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Pengaduan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* --- Admin Sidebar Styles --- */
        .admin-sidebar {
            width: 280px;
            min-height: 100vh;
            background-color: #004D40; /* Warna hijau tua dari gambar */
            padding: 1.5rem;
            color: #ffffff;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
        }
        .admin-sidebar-header {
            margin-bottom: 1.5rem;
            padding-left: 0.5rem;
        }
        .admin-sidebar-header h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0;
            color: #E0F2F1;
        }
        .admin-sidebar .nav-heading {
            font-size: 0.75rem;
            font-weight: 600;
            color: #80CBC4; /* Warna heading 'MENU' */
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0 0.75rem;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }
        .admin-sidebar .nav-link {
            color: #B2DFDB;
            font-size: 0.9rem;
            padding: 0.65rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 0.25rem;
            font-weight: 500;
        }
        .admin-sidebar .nav-link i {
            margin-right: 12px;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }
        .admin-sidebar .nav-link:hover {
            background-color: #00695C;
            color: #ffffff;
        }
        .admin-sidebar .nav-link.active {
            background-color: #F9A825; /* Warna kuning aktif */
            color: #000;
            font-weight: 600;
        }
        .admin-sidebar .logout-link {
            color: #FFCDD2;
        }
        .admin-sidebar .logout-link:hover {
            background-color: #C62828;
            color: #fff;
        }


        /* --- Admin Content Styles --- */
        .admin-content {
            flex-grow: 1;
            padding: 2rem;
            /* Gradient background utama */
            background-image: linear-gradient(120deg, #16A085, #1ABC9C);
            overflow-y: auto;
        }

        /* --- Topbar / User Menu --- */
        .admin-topbar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 2rem;
        }
        .user-dropdown .dropdown-toggle {
            background-color: rgba(255, 255, 255, 0.95);
            border: none;
            color: #333;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 500;
        }
        .user-dropdown .dropdown-toggle::after {
            margin-left: 0.5rem;
        }
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #8E44AD; /* Avatar ungu */
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.5rem;
            font-weight: 600;
        }

        /* Custom Button */
        .btn-purple {
            background-color: #6a1b9a; /* Warna ungu filter */
            border-color: #6a1b9a;
            color: white;
        }
        .btn-purple:hover {
            background-color: #4a148c;
            border-color: #4a148c;
            color: white;
        }

    </style>
</head>
<body>

    <div class="admin-wrapper">

        @include('admin.layouts.sidebar')


        <div class="admin-content">

            <div class="admin-topbar">
                <div class="dropdown user-dropdown">
                    <button class="btn dropdown-toggle d-flex align-items-center" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="user-avatar">A</span>
                        <div>
                            Asep
                            <small class="d-block text-muted" style="margin-top: -5px;">Administrator</small>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="#">Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#">Logout</a></li>
                    </ul>
                </div>
            </div>

            <main>
                @yield('content')
            </main>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
