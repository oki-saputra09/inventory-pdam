<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi - INVENDAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #86B6F6;
            --primary-dark: #0d6f9d;
            --primary-blue: #159bd8;
            --primary-soft: #e9f7fd;
            --bg: #f4f8fb;
            --text: #24323d;
            --muted: #6c7a86;
            --sidebar: #0f5f86;
            --sidebar-dark: #0b4f70;
            --success-soft: #eefbf3;
            --danger-soft: #fff1f1;
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
            width: 270px;
            background: linear-gradient(180deg, var(--sidebar), var(--sidebar-dark));
            color: #fff;
            position: fixed;
            inset: 0 auto 0 0;
            padding: 24px 18px;
            overflow-y: auto;
            transform: translateX(-100%);
            transition: 0.3s ease;
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
            padding: 6px 8px 22px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.14);
            margin-bottom: 22px;
        }

        .brand-logo {
            width: 56px;
            height: 56px;
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
            font-weight: 700;
            letter-spacing: .8px;
            opacity: .8;
            margin: 20px 10px 10px;
            text-transform: uppercase;
        }

        .menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .menu li {
            margin-bottom: 8px;
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
            font-weight: 600;
            transition: .2s ease;
            text-align: left;
        }

        .menu a:hover,
        .menu a.active,
        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.14);
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

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-print-small {
            background: var(--primary-dark);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 9px 14px;
            font-size: .86rem;
            font-weight: 800;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            white-space: nowrap;
            box-shadow: 0 8px 18px rgba(13, 111, 157, 0.18);
        }

        .btn-print-small:hover {
            background: #095b82;
            color: #fff;
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
            border-radius: 24px;
            padding: 26px;
            margin-bottom: 24px;
            box-shadow: 0 14px 30px rgba(21, 155, 216, 0.22);
        }

        .page-header h4 {
            margin: 0 0 8px;
            font-weight: 900;
            font-size: 1.55rem;
        }

        .page-header p {
            margin: 0;
            color: #eef6ff;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 24px;
        }

        .summary-card {
            background: #fff;
            border: 1px solid #e7edf2;
            border-radius: 22px;
            padding: 20px;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.04);
        }

        .summary-card small {
            color: var(--muted);
            font-weight: 700;
        }

        .summary-card h3 {
            margin: 6px 0 0;
            font-weight: 900;
            color: var(--text);
        }

        .card-section {
            background: #fff;
            border: 1px solid #e7edf2;
            border-radius: 22px;
            padding: 22px;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.04);
            margin-bottom: 24px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }

        .section-title .icon {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: var(--primary-soft);
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
        }

        .section-title h5 {
            margin: 0;
            font-weight: 900;
            color: var(--text);
        }

        .section-title p {
            margin: 2px 0 0;
            color: var(--muted);
            font-size: .9rem;
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

        .badge-transaksi {
            border-radius: 999px;
            padding: 7px 12px;
            font-size: .78rem;
            font-weight: 800;
        }

        .badge-masuk {
            background: var(--success-soft);
            color: #198754;
        }

        .badge-keluar {
            background: var(--danger-soft);
            color: #dc3545;
        }

        @media (max-width: 991px) {
            .summary-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .topbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .topbar-actions {
                width: 100%;
                justify-content: flex-start;
                flex-wrap: wrap;
            }
        }

        @media (max-width: 576px) {
            .summary-grid {
                grid-template-columns: 1fr;
            }

            .content {
                padding: 18px;
            }
        }
    </style>
</head>

<body>
@php
    $logoKantor = asset('images/logo.png');
    $namaAdmin = auth()->user()->name ?? 'Admin';

    $totalMasuk = $barangMasuk->count();
    $totalKeluar = $barangKeluar->count();

    $jumlahMasuk = $barangMasuk->sum('jumlah');
    $jumlahKeluar = $barangKeluar->sum('jumlah');
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
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('admin.barang.index') }}" class="{{ request()->routeIs('admin.barang.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i>
                    Data Barang
                </a>
            </li>

            <li>
                <a href="{{ route('admin.kategori.index') }}" class="{{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i>
                    Kategori
                </a>
            </li>

            <li>
                <a href="{{ route('admin.supplier.index') }}" class="{{ request()->routeIs('admin.supplier.*') ? 'active' : '' }}">
                    <i class="bi bi-truck"></i>
                    Supplier
                </a>
            </li>

            <li>
                <a href="{{ route('admin.user.index') }}" class="{{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    User
                </a>
            </li>
        </ul>

        <div class="menu-title">Transaksi</div>

        <ul class="menu">
            <li>
                <a href="{{ route('admin.barang-masuk.index') }}" class="{{ request()->routeIs('admin.barang-masuk.*') ? 'active' : '' }}">
                    <i class="bi bi-box-arrow-in-down"></i>
                    Barang Masuk
                </a>
            </li>

            <li>
                <a href="{{ route('admin.barang-keluar.index') }}" class="{{ request()->routeIs('admin.barang-keluar.*') ? 'active' : '' }}">
                    <i class="bi bi-box-arrow-up"></i>
                    Barang Keluar
                </a>
            </li>

            <li>
                <a href="{{ route('admin.permintaan-barang.index') }}" class="{{ request()->routeIs('admin.permintaan-barang.*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-check"></i>
                    Permintaan Barang
                </a>
            </li>
        </ul>

        <div class="menu-title">Laporan</div>

        <ul class="menu">
            <li>
                <a href="{{ route('admin.laporan-stok.index') }}" class="{{ request()->routeIs('admin.laporan-stok.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i>
                    Laporan Stok
                </a>
            </li>

            <li>
                <a href="{{ route('admin.laporan-transaksi.index') }}" class="{{ request()->routeIs('admin.laporan-transaksi.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                    Laporan Transaksi
                </a>
            </li>

            <li>
                <a href="{{ route('admin.notifikasi-stok.index') }}" class="{{ request()->routeIs('admin.notifikasi-stok.*') ? 'active' : '' }}">
                    <i class="bi bi-bell"></i>
                    Notifikasi Stok
                </a>
            </li>

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
                    <h3>LAPORAN TRANSAKSI</h3>
                    <p>Rekapitulasi barang masuk dan barang keluar</p>
                </div>
            </div>

            <div class="topbar-actions">
                <a href="{{ route('admin.laporan-transaksi.cetak') }}" target="_blank" class="btn-print-small">
                    <i class="bi bi-printer"></i>
                    Cetak
                </a>

                <div class="admin-badge">
                    <i class="bi bi-person-circle"></i>
                    {{ $namaAdmin }}
                </div>
            </div>
        </div>

        <div class="content">
            <div class="page-header">
                <h4>Laporan Transaksi Barang</h4>
                <p>Admin dapat melihat data barang masuk dan barang keluar dalam satu halaman laporan.</p>
            </div>

            <div class="summary-grid">
                <div class="summary-card">
                    <small>Total Barang Masuk</small>
                    <h3>{{ $totalMasuk }}</h3>
                </div>

                <div class="summary-card">
                    <small>Total Barang Keluar</small>
                    <h3>{{ $totalKeluar }}</h3>
                </div>

                <div class="summary-card">
                    <small>Jumlah Masuk</small>
                    <h3>{{ $jumlahMasuk }}</h3>
                </div>

                <div class="summary-card">
                    <small>Jumlah Keluar</small>
                    <h3>{{ $jumlahKeluar }}</h3>
                </div>
            </div>

            <div class="card-section">
                <div class="section-title">
                    <div class="icon">
                        <i class="bi bi-box-arrow-in-down"></i>
                    </div>

                    <div>
                        <h5>Barang Masuk</h5>
                        <p>Daftar transaksi barang yang masuk ke gudang.</p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Supplier</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($barangMasuk as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $item->tanggal_masuk ? \Carbon\Carbon::parse($item->tanggal_masuk)->format('d-m-Y') : '-' }}
                                    </td>
                                    <td>
                                        <span class="badge-transaksi badge-masuk">Masuk</span>
                                    </td>
                                    <td>{{ $item->barang->kode_barang ?? '-' }}</td>
                                    <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                                    <td>{{ $item->supplier->nama_supplier ?? '-' }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>{{ $item->keterangan ?: '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        Belum ada data barang masuk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-section">
                <div class="section-title">
                    <div class="icon">
                        <i class="bi bi-box-arrow-up"></i>
                    </div>

                    <div>
                        <h5>Barang Keluar</h5>
                        <p>Daftar transaksi barang yang keluar dari gudang.</p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Tujuan</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($barangKeluar as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $item->tanggal_keluar ? \Carbon\Carbon::parse($item->tanggal_keluar)->format('d-m-Y') : '-' }}
                                    </td>
                                    <td>
                                        <span class="badge-transaksi badge-keluar">Keluar</span>
                                    </td>
                                    <td>{{ $item->barang->kode_barang ?? '-' }}</td>
                                    <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>{{ $item->tujuan ?: '-' }}</td>
                                    <td>{{ $item->keterangan ?: '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        Belum ada data barang keluar.
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