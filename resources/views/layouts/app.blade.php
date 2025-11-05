<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pengaduan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6; /* Warna fallback jika gradient tidak didukung */
        }

        .main-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* --- Sidebar Styles --- */
        .sidebar {
            width: 280px;
            min-height: 100vh;
            background-color: #00334E; /* Warna biru tua dari gambar */
            padding: 1.5rem;
            color: #ffffff;
            flex-shrink: 0;
        }
        .sidebar-header {
            margin-bottom: 2rem;
        }
        .sidebar-header h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0;
        }
        .sidebar-header span {
            font-size: 0.85rem;
            color: #a0bacc;
        }
        .sidebar .nav-link {
            color: #d0e0e9;
            font-size: 0.95rem;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            font-size: 1.1rem;
        }
        .sidebar .nav-link:hover {
            background-color: #004a70;
            color: #ffffff;
        }
        .sidebar .nav-link.active {
            background-color: #005a87;
            color: #ffffff;
            font-weight: 500;
        }

        /* --- Content Styles --- */
        .content-wrapper {
            flex-grow: 1;
            padding: 2rem;
            /* Gradient background utama */
            background-image: linear-gradient(120deg, #00467F, #1ABC9C);
            overflow-y: auto;
        }

        /* --- Topbar / User Menu --- */
        .topbar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 2rem;
        }
        .user-dropdown .dropdown-toggle {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            color: #333;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 500;
        }
        .user-dropdown .dropdown-toggle::after {
            margin-left: 0.5rem;
        }
        .user-dropdown .dropdown-menu {
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #6c757d;
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.5rem;
            font-weight: 600;
        }

        /* --- Form Card Styles --- */
        .form-card {
            background-color: #ffffff;
            border-radius: 1rem;
            border: none;
            box-shadow: 0 8px 30px rgba(0,0,0,0.05);
        }

        /* --- Custom File Upload --- */
        .file-drop-zone {
            border: 2px dashed #ced4da;
            border-radius: 0.5rem;
            padding: 2.5rem;
            text-align: center;
            cursor: pointer;
            background-color: #f9fafb;
            transition: background-color 0.2s;
        }
        .file-drop-zone:hover {
            background-color: #f1f3f5;
        }
        .file-drop-zone .file-input {
            display: none;
        }
        .file-drop-zone .file-msg {
            color: #0d6efd;
            font-weight: 500;
        }

    </style>
</head>
<body>

    <div class="main-wrapper">

        @include('layouts.sidebar')


        <div class="content-wrapper">

            <div class="topbar">
                <div class="dropdown user-dropdown">
                    <button class="btn dropdown-toggle d-flex align-items-center" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="user-avatar">A</span>
                        Acep
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="#">Profil</a></li>
                        <li><a class="dropdown-item" href="#">Pengaturan</a></li>
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
