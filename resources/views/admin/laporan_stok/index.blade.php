<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok - INVENDAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #86B6F6;
            --primary-blue: #159bd8;
            --primary-dark: #0d6f9d;
            --primary-soft: #e9f7fd;
            --bg: #f4f8fb;
            --text: #24323d;
            --muted: #6c7a86;
            --white: #ffffff;
            --border: #e7edf2;
            --danger: #dc3545;
            --danger-soft: #fff1f1;
            --success: #198754;
            --success-soft: #eefbf3;
            --warning: #b7791f;
            --warning-soft: #fff8e8;
            --sidebar: #0f5f86;
            --sidebar-dark: #0b4f70;
            --shadow: 0 10px 28px rgba(15, 95, 134, 0.07);
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg);
            color: var(--text);
            overflow: hidden;
        }

        .layout {
            width: 100%;
            height: 100vh;
            display: flex;
        }

        .sidebar {
            width: 285px;
            background: linear-gradient(180deg, var(--sidebar), var(--sidebar-dark));
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            padding: 22px 18px 35px;
            overflow-y: auto;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 1100;
            box-shadow: 4px 0 18px rgba(0, 0, 0, 0.12);
        }

        .sidebar.show {
            transform: translateX(0);
        }

        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.28);
            opacity: 0;
            visibility: hidden;
            transition: 0.25s ease;
            z-index: 1090;
        }

        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 6px 8px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.14);
            margin-bottom: 20px;
        }

        .brand-logo {
            width: 58px;
            height: 58px;
            flex-shrink: 0;
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
            filter:
                drop-shadow(0 0 2px rgba(255, 255, 255, 0.9))
                drop-shadow(0 0 7px rgba(255, 255, 255, 0.7));
        }

        .brand-text h4 {
            margin: 0;
            font-size: 1rem;
            font-weight: 800;
            line-height: 1.2;
        }

        .brand-text span {
            font-size: .78rem;
            opacity: .9;
        }

        .menu-title {
            font-size: .78rem;
            font-weight: 800;
            letter-spacing: .8px;
            opacity: .85;
            margin: 20px 10px 10px;
            text-transform: uppercase;
        }

        .menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .menu li {
            margin-bottom: 7px;
        }

        .menu a,
        .logout-btn {
            width: 100%;
            border: none;
            background: transparent;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #fff;
            padding: 12px 14px;
            border-radius: 14px;
            font-size: .95rem;
            font-weight: 700;
            transition: .2s ease;
            text-align: left;
        }

        .menu a i,
        .logout-btn i {
            font-size: 1.15rem;
            width: 22px;
            text-align: center;
        }

        .menu a:hover,
        .menu a.active,
        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.16);
        }

        .logout-form {
            margin: 0;
        }

        .main {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .topbar {
            background: #fff;
            padding: 18px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e8eef3;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .menu-toggle {
            width: 46px;
            height: 46px;
            border: 1px solid #dce8ef;
            background: #fff;
            border-radius: 12px;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            cursor: pointer;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.05);
        }

        .menu-toggle:hover {
            background: var(--primary-soft);
        }

        .topbar h3 {
            margin: 0;
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--primary-dark);
        }

        .topbar p {
            margin: 2px 0 0;
            color: var(--muted);
            font-size: .92rem;
        }

        .admin-badge {
            background: var(--primary-soft);
            color: var(--primary-dark);
            padding: 10px 16px;
            border-radius: 999px;
            font-weight: 700;
            font-size: .9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .content {
            flex: 1;
            overflow-y: auto;
            padding: 28px;
            background:
                radial-gradient(circle at top right, rgba(134, 182, 246, 0.25), transparent 35%),
                linear-gradient(180deg, #f8fbff 0%, #f4f8fb 100%);
        }

        .page-header {
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-dark));
            color: #fff;
            border-radius: 22px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 14px 30px rgba(21, 155, 216, 0.18);
        }

        .page-header h4 {
            margin: 0 0 8px;
            font-weight: 900;
        }

        .page-header p {
            margin: 0;
            color: #eef6ff;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 24px;
        }

        .summary-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 20px;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }

        .summary-card::after {
            content: "";
            position: absolute;
            right: -34px;
            top: -34px;
            width: 98px;
            height: 98px;
            border-radius: 50%;
            background: var(--primary-soft);
        }

        .summary-inner {
            position: relative;
            z-index: 2;
        }

        .summary-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            margin-bottom: 14px;
        }

        .icon-total {
            background: var(--primary-soft);
            color: var(--primary-dark);
        }

        .icon-aman {
            background: var(--success-soft);
            color: var(--success);
        }

        .icon-minimum {
            background: var(--warning-soft);
            color: var(--warning);
        }

        .icon-rendah {
            background: var(--danger-soft);
            color: var(--danger);
        }

        .summary-label {
            color: var(--muted);
            font-size: .88rem;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .summary-value {
            font-size: 2rem;
            font-weight: 900;
            color: var(--text);
            line-height: 1;
        }

        .card-soft {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 20px;
            box-shadow: var(--shadow);
        }

        .toolbar-card,
        .table-card {
            padding: 20px;
        }

        .btn-main {
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-dark));
            border: none;
            color: #fff;
            border-radius: 14px;
            padding: 11px 18px;
            font-weight: 800;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            box-shadow: 0 8px 18px rgba(13, 111, 157, 0.18);
        }

        .btn-main:hover {
            color: #fff;
            background: linear-gradient(135deg, var(--primary-dark), #095b82);
        }

        .btn-excel {
            background: #198754;
            border: none;
            color: #fff;
            border-radius: 14px;
            padding: 11px 18px;
            font-weight: 800;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
        }

        .btn-excel:hover {
            color: #fff;
            background: #146c43;
        }

        .btn-back {
            background: #fff;
            border: 1px solid #dbe6ef;
            color: var(--text);
            border-radius: 14px;
            padding: 11px 18px;
            font-weight: 800;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
        }

        .btn-back:hover {
            background: var(--primary-soft);
            color: var(--primary-dark);
        }

        .table-custom thead th {
            background: #f7fafc;
            color: var(--primary-dark);
            font-weight: 800;
            border-bottom: 1px solid #dce5ec;
            white-space: nowrap;
        }

        .table-custom td {
            vertical-align: middle;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: .78rem;
            font-weight: 900;
        }

        .status-aman {
            background: var(--success-soft);
            color: var(--success);
        }

        .status-minimum {
            background: var(--warning-soft);
            color: var(--warning);
        }

        .status-rendah {
            background: var(--danger-soft);
            color: var(--danger);
        }

        @media (max-width: 992px) {
            .summary-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .topbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .content {
                padding: 18px;
            }

            .summary-grid {
                grid-template-columns: 1fr;
            }

            .btn-main,
            .btn-excel,
            .btn-back {
                width: 100%;
            }

            .admin-badge {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
@php
    $logoKantor = asset('images/logo.png');
    $namaAdmin = auth()->user()->name ?? 'Admin';
@endphp

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="layout">
    <aside class="sidebar" id="sidebarMenu">
        <div class="brand">
            <div class="brand-logo">
                <img src="{{ $logoKantor }}" alt="Logo PDAM">
            </div>

            <div class="brand-text">
                <h4>INVENDAM</h4>
                <span>Admin Controls</span>
            </div>
        </div>

        <div class="menu-title">Menu Utama</div>

        <ul class="menu">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('admin.barang.index') }}">
                    <i class="bi bi-box-seam"></i>
                    Data Barang
                </a>
            </li>

            <li>
                <a href="{{ route('admin.kategori.index') }}">
                    <i class="bi bi-tags"></i>
                    Kategori
                </a>
            </li>

            <li>
                <a href="{{ route('admin.supplier.index') }}">
                    <i class="bi bi-truck"></i>
                    Supplier
                </a>
            </li>

            <li>
                <a href="{{ route('admin.user.index') }}">
                    <i class="bi bi-people"></i>
                    User
                </a>
            </li>
        </ul>

        <div class="menu-title">Transaksi</div>

        <ul class="menu">
            <li>
                <a href="{{ route('admin.barang-masuk.index') }}">
                    <i class="bi bi-box-arrow-in-down"></i>
                    Barang Masuk
                </a>
            </li>

            <li>
                <a href="{{ route('admin.barang-keluar.index') }}">
                    <i class="bi bi-box-arrow-up"></i>
                    Barang Keluar
                </a>
            </li>

            <li>
                <a href="{{ route('admin.permintaan-barang.index') }}">
                    <i class="bi bi-clipboard-check"></i>
                    Permintaan Barang
                </a>
            </li>
        </ul>

        <div class="menu-title">Laporan</div>

        <ul class="menu">
            <li>
                <a href="{{ route('admin.laporan-stok.index') }}" class="active">
                    <i class="bi bi-file-earmark-text"></i>
                    Laporan Stok
                </a>
            </li>

            <li>
                <a href="{{ route('admin.laporan-transaksi.index') }}">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                    Laporan Transaksi
                </a>
            </li>

            <li>
                <a href="{{ route('admin.notifikasi-stok.index') }}">
                    <i class="bi bi-bell"></i>
                    Notifikasi Stok
                </a>
            </li>
        </ul>

        <div class="menu-title">Akun</div>

        <ul class="menu">
            <li>
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf

                    <button type="submit" class="logout-btn">
                        <i class="bi bi-box-arrow-left"></i>
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </aside>

    <main class="main">
        <div class="topbar">
            <div class="topbar-left">
                <button class="menu-toggle" id="menuToggle" type="button">
                    <i class="bi bi-list"></i>
                </button>

                <div>
                    <h3>LAPORAN STOK</h3>
                    <p>Ringkasan dan daftar stok barang inventory</p>
                </div>
            </div>

            <div class="admin-badge">
                <i class="bi bi-person-circle"></i>
                {{ $namaAdmin }}
            </div>
        </div>

        <div class="content">
            <div class="page-header">
                <h4>Laporan Stok Barang</h4>
                <p>Halaman ini digunakan untuk melihat kondisi stok barang, mencetak laporan, dan export Excel.</p>
            </div>

            <div class="summary-grid">
                <div class="summary-card">
                    <div class="summary-inner">
                        <div class="summary-icon icon-total">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div class="summary-label">Total Barang</div>
                        <div class="summary-value">{{ $totalBarang ?? 0 }}</div>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-inner">
                        <div class="summary-icon icon-aman">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="summary-label">Stok Aman</div>
                        <div class="summary-value">{{ $stokAman ?? 0 }}</div>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-inner">
                        <div class="summary-icon icon-minimum">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <div class="summary-label">Stok Minimum</div>
                        <div class="summary-value">{{ $stokMinimum ?? 0 }}</div>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-inner">
                        <div class="summary-icon icon-rendah">
                            <i class="bi bi-x-circle"></i>
                        </div>
                        <div class="summary-label">Stok Rendah</div>
                        <div class="summary-value">{{ $stokRendah ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <div class="card-soft toolbar-card mb-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        <h5 class="mb-1 fw-bold text-primary">Aksi Laporan</h5>
                        <p class="mb-0 text-muted">Cetak laporan stok atau export data stok ke Excel.</p>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('admin.laporan-stok.cetak') }}" class="btn-main">
                            <i class="bi bi-printer"></i>
                            Cetak / Save PDF
                        </a>

                        <a href="{{ route('admin.laporan-stok.excel') }}" class="btn-excel">
                            <i class="bi bi-file-earmark-excel"></i>
                            Export Excel
                        </a>

                        <a href="{{ route('admin.dashboard') }}" class="btn-back">
                            <i class="bi bi-arrow-left"></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-soft table-card">
                <div class="table-responsive">
                    <table class="table table-custom table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Satuan</th>
                                <th>Stok</th>
                                <th>Minimum</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($barang as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->kode_barang }}</td>
                                    <td>{{ $item->nama_barang }}</td>
                                    <td>{{ $item->kategori }}</td>
                                    <td>{{ $item->satuan }}</td>
                                    <td>
                                        <strong>{{ $item->stok }}</strong>
                                    </td>
                                    <td>{{ $item->minimum_stok }}</td>
                                    <td>
                                        @if($item->stok > $item->minimum_stok)
                                            <span class="status-badge status-aman">
                                                <i class="bi bi-check-circle"></i>
                                                Aman
                                            </span>
                                        @elseif($item->stok == $item->minimum_stok)
                                            <span class="status-badge status-minimum">
                                                <i class="bi bi-exclamation-triangle"></i>
                                                Minimum
                                            </span>
                                        @else
                                            <span class="status-badge status-rendah">
                                                <i class="bi bi-x-circle"></i>
                                                Stok Rendah
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        Data barang belum tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    const menuToggle = document.getElementById('menuToggle');
    const sidebarMenu = document.getElementById('sidebarMenu');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    if (menuToggle && sidebarMenu && sidebarOverlay) {
        menuToggle.addEventListener('click', function () {
            sidebarMenu.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
        });

        sidebarOverlay.addEventListener('click', function () {
            sidebarMenu.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        });
    }
</script>
</body>
</html>