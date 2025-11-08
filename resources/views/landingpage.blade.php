<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPEMAS | Sistem Pengaduan Masyarakat</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        /* =================================
           1. RESET & GAYA DASAR
           ================================= */

        /* Reset CSS Sederhana */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            line-height: 1.6;
            background-color: #ffffff;
            color: #333;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* =================================
           2. HEADER & NAVIGASI
           ================================= */

        .header {
            background-color: #ffffff;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50; /* Biru Navy */
            text-decoration: none;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 25px;
        }

        .nav-links li a {
            text-decoration: none;
            color: #555;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .nav-links li a:hover {
            color: #007bff; /* Biru Terang */
        }

        /* =================================
           3. TOMBOL (Buttons)
           ================================= */

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-primary {
            background-color: #007bff; /* Biru Terang */
            color: #ffffff;
        }

        .btn-primary:hover {
            background-color: #0056b3; /* Biru Lebih Gelap */
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,123,255,0.3);
        }

        .btn-secondary {
            background-color: #6c757d; /* Abu-abu */
            color: #ffffff;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }


        /* =================================
           4. HERO SECTION & SLIDER
           ================================= */

        .hero {
            position: relative;
            height: 70vh; /* Tinggi 70% dari layar */
            width: 100%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .slider-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .slide {
            position: absolute;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 1.5s ease-in-out; /* Transisi fade 1.5 detik */
        }

        /* Overlay gelap agar teks terbaca */
        .slide::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
        }

        .slide.active {
            opacity: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            color: #ffffff;
            max-width: 700px;
            padding: 20px;
        }

        .hero-content h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }

        .hero-content p {
            font-size: 18px;
            font-weight: 300;
            margin-bottom: 30px;
        }

        .hero-content .track-form {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .hero-content .track-form input {
            padding: 12px 15px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            width: 250px;
        }

        /* =================================
           5. BAGIAN ALUR PENGADUAN
           ================================= */

        .section {
            padding: 80px 0;
        }

        .bg-light {
            background-color: #f9f9f9;
        }

        .section-title {
            text-align: center;
            font-size: 36px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .section-subtitle {
            text-align: center;
            font-size: 18px;
            color: #777;
            margin-bottom: 50px;
        }

        .flow-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            text-align: center;
        }

        .flow-item {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .flow-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        }

        .flow-item .icon {
            font-size: 48px;
            margin-bottom: 15px;
            color: #007bff;
        }

        .flow-item h3 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .flow-item p {
            font-size: 15px;
            color: #555;
        }

        /* =================================
           6. BAGIAN CALL TO ACTION (CTA)
           ================================= */

        .cta-section {
            background-color: #2c3e50; /* Biru Navy */
            color: #ffffff;
            text-align: center;
        }

        .cta-section .section-title {
            color: #ffffff;
        }

        .cta-section .section-subtitle {
            color: #eee;
            margin-bottom: 30px;
        }

        /* =================================
           7. FOOTER
           ================================= */

        .footer {
            background-color: #222;
            color: #aaa;
            padding: 40px 0;
            text-align: center;
        }

        .footer p {
            font-size: 14px;
        }

        /* =================================
           8. RESPONSIVE DESIGN (HP)
           ================================= */

        @media (max-width: 768px) {
            .nav-links {
                display: none; /* Sembunyikan menu di HP, bisa diganti burger menu */
            }

            .header .container {
                justify-content: space-between;
            }

            .header .btn-primary {
                font-size: 14px;
                padding: 10px 16px;
            }

            .hero {
                height: 80vh; /* Lebih tinggi di HP */
            }

            .hero-content h1 {
                font-size: 32px;
            }

            .hero-content p {
                font-size: 16px;
            }

            .hero-content .track-form {
                flex-direction: column;
                align-items: center;
            }

            .hero-content .track-form input {
                width: 100%;
                max-width: 300px;
            }

            .flow-grid {
                grid-template-columns: 1fr; /* Susun ke bawah */
            }

            .section-title {
                font-size: 28px;
            }
        }

    </style>
</head>
<body>

    <header class="header">
        <div class="container">
            <a href="#" class="logo">SIPEMAS</a>
            <nav>
                <ul class="nav-links">
                    <li><a href="#beranda">Beranda</a></li>
                    <li><a href="#alur">Alur Pengaduan</a></li>
                    <li><a href="#faq">FAQ</a></li>
                </ul>
            </nav>
            <a href="#lapor" class="btn btn-primary">Buat Laporan</a>
        </div>
    </header>

    <section class="hero" id="beranda">

        <div class="slider-container">
            <div
                class="slide active"
                style="background-image: url('https://images.unsplash.com/photo-1504384308090-c894fdcc538d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80');">
                </div>
            <div
                class="slide"
                style="background-image: url('https://images.unsplash.com/photo-1573497491208-6b1acb260507?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80');">
                </div>
            <div
                class="slide"
                style="background-image: url('https://images.unsplash.com/photo-1517048676732-d65bc937f952?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80');">
                </div>
        </div>

        <div class="hero-content">
            <h1>Suara Anda, Solusi Kita Bersama.</h1>
            <p>Sampaikan aspirasi, keluhan, dan laporan Anda secara langsung, transparan, dan terintegrasi. Kami di sini untuk mendengar dan menindaklanjuti.</p>

            <a href="#lapor" class="btn btn-primary btn-lg">⬇ BUAT LAPORAN SEKARANG</a>

            <form class="track-form">
                <input type="text" placeholder="Masukkan No. Tiket Laporan Anda...">
                <button type="submit" class="btn btn-secondary">Cek Status</button>
            </form>
        </div>
    </section>

    <section class="section bg-light" id="alur">
        <div class="container">
            <h2 class="section-title">Proses Pengaduan yang Mudah</h2>
            <p class="section-subtitle">Hanya butuh 4 langkah mudah untuk membuat laporan Anda ditangani.</p>

            <div class="flow-grid">
                <div class="flow-item">
                    <div class="icon">📝</div>
                    <h3>1. Tulis Laporan</h3>
                    <p>Sampaikan laporan Anda dengan detail dan jelas. Unggah foto pendukung jika ada.</p>
                </div>
                <div class="flow-item">
                    <div class="icon">🛡</div>
                    <h3>2. Verifikasi</h3>
                    <p>Laporan Anda akan diverifikasi oleh petugas kami untuk kelengkapan data.</p>
                </div>
                <div class="flow-item">
                    <div class="icon">⚙</div>
                    <h3>3. Tindak Lanjut</h3>
                    <p>Laporan diteruskan ke instansi terkait untuk ditangani hingga tuntas.</p>
                </div>
                <div class="flow-item">
                    <div class="icon">✅</div>
                    <h3>4. Selesai</h3>
                    <p>Anda akan menerima notifikasi saat laporan selesai ditangani. Beri tanggapan Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section cta-section" id="lapor">
        <div class="container">
            <h2 class="section-title">Perubahan Dimulai dari Suara Anda</h2>
            <p class="section-subtitle">Setiap laporan sangat berharga untuk membangun kota yang lebih baik, lebih nyaman, dan lebih responsif.</p>

            <a href="#" class="btn btn-primary btn-lg">✍ Sampaikan Laporan Anda Di Sini</a>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <p>© 2025 Pemerintah [Nama Kota Anda]. Hak Cipta Dilindungi.</p>
            <p>Email: lapor@kotaku.go.id | Call Center: 1500-XXX</p>
        </div>
    </footer>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.slide');
            let currentSlide = 0;
            const slideInterval = 4000; // Ganti foto setiap 4 detik (4000ms)

            function nextSlide() {
                // Sembunyikan slide saat ini
                slides[currentSlide].classList.remove('active');

                // Tentukan slide berikutnya
                currentSlide = (currentSlide + 1) % slides.length;

                // Tampilkan slide berikutnya
                slides[currentSlide].classList.add('active');
            }

            // Atur interval untuk memanggil nextSlide
            setInterval(nextSlide, slideInterval);
        });
    </script>

</body>
</html>
