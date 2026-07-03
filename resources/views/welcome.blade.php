<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INVENDAM BENGKAYANG</title>

    @php
        $logoKantor = asset('images/logo.png');
        $heroBackground = asset('images/bg.jpg');

        $totalBarang = $totalBarang ?? 0;
        $totalBarangMasuk = $totalBarangMasuk ?? 0;
        $totalBarangKeluar = $totalBarangKeluar ?? 0;
        $stokMenipis = $stokMenipis ?? 0;

        $previewAktivitas = $previewAktivitas ?? collect();
    @endphp

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #159bd8;
            --primary-dark: #0d6f9d;
            --primary-soft: #e9f7fd;
            --accent: #c6a46a;
            --bg: #f7f8fa;
            --text: #24323d;
            --muted: #6c7a86;
            --white: #ffffff;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Georgia', 'Times New Roman', Times, serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.7;
        }

        * {
            transition: all 0.25s ease-in-out;
        }

        .navbar-custom {
            background: var(--primary);
            border-bottom: 4px solid var(--accent);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.04);
            transition: box-shadow 0.3s;
        }

        .navbar-custom:hover {
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.06);
        }

        .navbar-brand,
        .nav-link {
            color: #fff !important;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: .4px;
        }

        .brand-logo {
            width: 64px;
            height: 64px;
            border-radius: 0;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: none;
            border: none;
            flex-shrink: 0;
            padding: 0;
            overflow: visible;
            transition: transform 0.2s;
        }

        .brand-logo:hover {
            transform: scale(1.02);
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
            filter: drop-shadow(0 0 2px rgba(255,255,255,0.95))
                    drop-shadow(0 0 8px rgba(255,255,255,0.85))
                    drop-shadow(0 2px 8px rgba(0,0,0,0.18));
        }

        .brand-text-wrap {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .brand-title {
            font-size: 1.2rem;
            font-weight: 700;
        }

        .brand-subtitle {
            font-size: .72rem;
            opacity: .92;
            font-weight: 500;
            letter-spacing: .4px;
        }

        .nav-link {
            font-size: 1rem;
            font-weight: 600;
            margin-left: 8px;
            margin-right: 8px;
            padding: 8px 4px !important;
            border-bottom: 2px solid transparent;
        }

        .nav-link:hover {
            color: #fff4d6 !important;
            border-bottom-color: #fff4d6;
        }

        .btn-login-top {
            background: #fff;
            color: var(--primary-dark);
            border: none;
            border-radius: 8px;
            padding: 10px 24px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
            transition: all 0.25s;
        }

        .btn-login-top:hover {
            background: #f4fbff;
            color: var(--primary-dark);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
            transform: translateY(-1px);
        }

        .hero {
            background:
                linear-gradient(rgba(14, 112, 159, 0.88), rgba(14, 112, 159, 0.82)),
                url('{{ $heroBackground }}') center/cover no-repeat;
            color: #fff;
            padding: 90px 0 85px;
        }

        .hero h1 {
            font-size: 2.7rem;
            font-weight: 700;
            margin-bottom: 18px;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .hero p {
            max-width: 760px;
            margin: 0 auto 28px;
            font-size: 1.08rem;
            color: #eef8ff;
        }

        .btn-main {
            background: #fff;
            color: var(--primary-dark);
            border: none;
            padding: 12px 28px;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
            transition: all 0.25s;
        }

        .btn-main:hover {
            background: #f3fbff;
            color: var(--primary-dark);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .btn-outline-soft {
            background: transparent;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.6);
            padding: 12px 28px;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            transition: all 0.25s;
        }

        .btn-outline-soft:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
            border-color: #fff;
            transform: translateY(-2px);
        }

        .section-padding {
            padding: 70px 0;
        }

        .section-title-wrap {
            text-align: center;
            margin-bottom: 45px;
        }

        .section-title {
            display: inline-block;
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-dark);
            border-bottom: 3px solid var(--accent);
            padding-bottom: 8px;
            margin-bottom: 14px;
        }

        .section-subtitle {
            max-width: 760px;
            margin: 0 auto;
            color: var(--muted);
        }

        .card-soft {
            background: var(--white);
            border: 1px solid #e9edf2;
            border-radius: 18px;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.04);
            height: 100%;
            transition: all 0.3s cubic-bezier(0.2, 0, 0, 1);
        }

        .card-soft:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 30px -8px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-soft);
        }

        .stat-card {
            padding: 26px 22px;
        }

        .stat-icon {
            width: 58px;
            height: 58px;
            border-radius: 16px;
            background: var(--primary-soft);
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            transition: 0.2s;
        }

        .card-soft:hover .stat-icon {
            background: var(--primary);
            color: #fff;
        }

        .stat-label {
            color: var(--muted);
            font-size: .95rem;
            margin-bottom: 6px;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            color: var(--text);
        }

        .feature-card {
            text-align: center;
            padding: 30px 22px;
        }

        .feature-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 16px;
            border-radius: 20px;
            background: var(--primary-soft);
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.9rem;
            transition: all 0.25s;
        }

        .feature-card:hover .feature-icon {
            background: var(--primary);
            color: #fff;
            transform: scale(1.05);
        }

        .feature-card h5 {
            font-weight: 700;
            margin-bottom: 10px;
        }

        .feature-card p {
            color: var(--muted);
            margin-bottom: 0;
        }

        .about-box {
            background: var(--white);
            border-radius: 22px;
            overflow: hidden;
            border: 1px solid #e9edf2;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.04);
            transition: box-shadow 0.3s;
        }

        .about-box:hover {
            box-shadow: 0 20px 35px -6px rgba(0, 0, 0, 0.08);
        }

        .about-content {
            padding: 42px;
        }

        .about-content h3 {
            color: var(--primary-dark);
            font-weight: 700;
            margin-bottom: 16px;
        }

        .about-content p {
            color: var(--muted);
            margin-bottom: 14px;
        }

        .about-list {
            margin: 20px 0 0;
            padding-left: 0;
            list-style: none;
        }

        .about-list li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 12px;
            color: var(--text);
        }

        .about-list i {
            color: var(--primary);
            margin-top: 3px;
        }

        .preview-table {
            background: var(--white);
            border-radius: 22px;
            padding: 26px;
            border: 1px solid #e9edf2;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.04);
            transition: box-shadow 0.3s;
        }

        .preview-table:hover {
            box-shadow: 0 18px 32px -6px rgba(0, 0, 0, 0.08);
        }

        .table thead th {
            background: #f6f8fa;
            color: var(--primary-dark);
            border-bottom: 1px solid #dfe5ea;
            font-weight: 700;
        }

        .badge-soft {
            background: var(--primary-soft);
            color: var(--primary-dark);
            font-weight: 700;
            padding: 8px 14px;
            border-radius: 999px;
            font-size: .8rem;
            transition: 0.2s;
        }

        tr:hover .badge-soft {
            background: var(--primary);
            color: #fff;
        }

        .contact-box {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            border-radius: 22px;
            padding: 40px 30px;
            box-shadow: 0 18px 35px rgba(0, 0, 0, 0.12);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .contact-box:hover {
            box-shadow: 0 24px 40px rgba(0, 0, 0, 0.15);
            transform: translateY(-3px);
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 18px;
        }

        .contact-item i {
            font-size: 1.2rem;
            margin-top: 2px;
        }

        .cta-box {
            background: #fff;
            border: 1px solid #e9edf2;
            border-radius: 22px;
            text-align: center;
            padding: 45px 25px;
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.04);
            transition: all 0.3s;
        }

        .cta-box:hover {
            box-shadow: 0 24px 38px -8px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-soft);
        }

        .cta-box h2 {
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 14px;
        }

        .cta-box p {
            color: var(--muted);
            max-width: 740px;
            margin: 0 auto 24px;
        }

        .footer-custom {
            background: #0e5f85;
            color: #eaf8ff;
            text-align: center;
            padding: 22px 0;
            margin-top: 30px;
            border-top: 4px solid var(--accent);
        }

        @media (max-width: 991px) {
            .hero h1 {
                font-size: 2.1rem;
            }

            .navbar-nav {
                padding: 15px 0;
            }

            .btn-login-top {
                display: inline-block;
                margin-top: 10px;
            }

            .about-content {
                padding: 28px;
            }
        }

        @media (max-width: 576px) {
            .hero {
                padding: 70px 0 65px;
            }

            .hero h1 {
                font-size: 1.8rem;
            }

            .section-title {
                font-size: 1.6rem;
            }

            .brand-title {
                font-size: 1rem;
            }

            .brand-subtitle {
                font-size: .65rem;
            }

            .brand-logo {
                width: 56px;
                height: 56px;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <div class="brand-logo">
                    <img src="{{ $logoKantor }}" alt="Logo Kantor">
                </div>
                <div class="brand-text-wrap">
                    <span class="brand-title">PDAM INVENTORY</span>
                    <span class="brand-subtitle">Perumdam Air Minum Tirta Bengkayang</span>
                </div>
            </a>

            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-3 align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang-kami">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kontak-kami">Hubungi Kami</a>
                    </li>
                </ul>

                <a href="{{ route('login') }}" class="btn-login-top">Login</a>
            </div>
        </div>
    </nav>

    <section class="hero text-center">
        <div class="container">
            <h1>SISTEM INVENTORY PDAM BENGKAYANG</h1>
            <p>
                Halaman ini merupakan tampilan awal sistem untuk memberikan gambaran umum
                mengenai pengelolaan inventory PDAM. Untuk masuk ke sistem dan mengelola data,
                pengguna harus login terlebih dahulu.
            </p>

            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                <a href="{{ route('login') }}" class="btn-main">Login</a>
                <a href="#tentang-kami" class="btn-outline-soft">Pelajari Lebih Lanjut</a>
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="section-title-wrap">
                <h2 class="section-title">Ringkasan Sistem</h2>
                <p class="section-subtitle">
                    Berikut adalah tampilan ringkas yang menunjukkan gambaran umum data inventory
                    sebagai preview sebelum pengguna masuk ke dalam sistem utama.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card-soft stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-label">Total Barang</div>
                                <h3 class="stat-number">{{ $totalBarang }}</h3>
                            </div>
                            <div class="stat-icon">
                                <i class="bi bi-box-seam"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card-soft stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-label">Barang Masuk</div>
                                <h3 class="stat-number">{{ $totalBarangMasuk }}</h3>
                            </div>
                            <div class="stat-icon">
                                <i class="bi bi-box-arrow-in-down"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card-soft stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-label">Barang Keluar</div>
                                <h3 class="stat-number">{{ $totalBarangKeluar }}</h3>
                            </div>
                            <div class="stat-icon">
                                <i class="bi bi-box-arrow-up"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card-soft stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-label">Stok Menipis</div>
                                <h3 class="stat-number">{{ $stokMenipis }}</h3>
                            </div>
                            <div class="stat-icon">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding pt-0">
        <div class="container">
            <div class="section-title-wrap">
                <h2 class="section-title">Fitur Utama</h2>
                <p class="section-subtitle">
                    Modul-modul berikut tersedia di dalam sistem. Untuk mengakses semuanya,
                    pengguna harus login terlebih dahulu.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card-soft feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-box2-heart"></i>
                        </div>
                        <h5>Data Barang</h5>
                        <p>Pengelolaan data barang, kategori, dan stok gudang.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card-soft feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-arrow-down-square"></i>
                        </div>
                        <h5>Barang Masuk</h5>
                        <p>Pencatatan penerimaan barang dari supplier.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card-soft feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-arrow-up-square"></i>
                        </div>
                        <h5>Barang Keluar</h5>
                        <p>Pencatatan distribusi barang untuk operasional lapangan.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card-soft feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-file-earmark-bar-graph"></i>
                        </div>
                        <h5>Laporan</h5>
                        <p>Penyajian laporan inventory secara rapi dan terstruktur.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding pt-0" id="tentang-kami">
        <div class="container">
            <div class="section-title-wrap">
                <h2 class="section-title">Tentang Kami</h2>
                <p class="section-subtitle">
                    Sistem ini dirancang untuk membantu pengelolaan inventory PDAM secara lebih tertib,
                    efisien, dan mudah dipantau oleh admin maupun staf.
                </p>
            </div>

            <div class="about-box">
                <div class="about-content">
                    <h3>Baca Aturan Sebelum Login</h3>
                    <p>
                        Halaman awal ini berfungsi sebagai tampilan pembuka sebelum pengguna masuk
                        ke aplikasi utama.
                    </p>
                    <p>
                        Setelah login, pengguna akan diarahkan ke dashboard sesuai hak akses masing-masing,
                        yaitu dashboard <strong>admin</strong> atau dashboard <strong>staf</strong>.
                    </p>

                    <ul class="about-list">
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Admin dapat mengelola data master, transaksi, laporan, dan pengguna.</span>
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Staf dapat membuat permintaan barang dan memantau status pengajuannya.</span>
                        </li>
                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Setiap pengguna masuk melalui halaman login yang sama.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding pt-0">
        <div class="container">
            <div class="section-title-wrap">
                <h2 class="section-title">Preview Aktivitas</h2>
                <p class="section-subtitle">
                    Tampilan ini menampilkan aktivitas terbaru dari data inventory.
                </p>
            </div>

            <div class="preview-table">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama Barang</th>
                                <th>Aktivitas</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($previewAktivitas as $aktivitas)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $aktivitas['tanggal'] ?? '-' }}</td>
                                    <td>{{ $aktivitas['nama_barang'] ?? '-' }}</td>
                                    <td>{{ $aktivitas['aktivitas'] ?? '-' }}</td>
                                    <td>{{ $aktivitas['jumlah'] ?? '-' }}</td>
                                    <td>
                                        <span class="badge-soft">
                                            {{ $aktivitas['status'] ?? 'Tersimpan' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        Belum ada aktivitas inventory yang dapat ditampilkan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding pt-0" id="kontak-kami">
        <div class="container">
            <div class="section-title-wrap">
                <h2 class="section-title">Contact Kami</h2>
                <p class="section-subtitle">
                    Jangan sungkan, untuk pertanyaan terkait layanan atau informasi tambahan silakan hubungi kami melalui contact di bawah ini. Data pribadi anda dijamin keamanannya.
                </p>
            </div>

            <div class="contact-box">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="contact-item">
                            <i class="bi bi-envelope-fill"></i>
                            <div>
                                <strong>Email</strong><br>
                                invendam@gmail.com
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="bi bi-telephone-fill"></i>
                            <div>
                                <strong>Telepon</strong><br>
                                085752302055
                            </div>
                        </div>
                        <div class="contact-item mb-0">
                            <i class="bi bi-geo-alt-fill"></i>
                            <div>
                                <strong>Alamat</strong><br>
                                Jl. Raya Pontianak, Eks. Kantor BPBD Bengkayang, No. 95, RT/RW : 020/11.
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mt-4 mt-lg-0">
                        <p class="mb-4"></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding pt-0">
        <div class="container">
            <div class="cta-box">
                <h2>Login untuk Masuk ke Sistem</h2>
                <p>
                    Gunakan akun Anda untuk mengakses dashboard utama. Admin dan staf akan diarahkan
                    ke tampilan dashboard masing-masing setelah berhasil login.
                </p>
                </a>
            </div>
        </div>
    </section>

    <footer class="footer-custom">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Sistem Inventory PDAM Bengkayang</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>