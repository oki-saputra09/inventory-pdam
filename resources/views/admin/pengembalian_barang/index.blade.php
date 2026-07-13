<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengembalian Barang - INVENDAM</title>

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
            --shadow: 0 10px 24px rgba(0, 0, 0, 0.04);
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

        .sidebar::-webkit-scrollbar,
        .content::-webkit-scrollbar {
            width: 8px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.28);
            border-radius: 999px;
        }

        .content::-webkit-scrollbar-thumb {
            background: #cfdbe5;
            border-radius: 999px;
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

        .menu a.disabled {
            opacity: .55;
            cursor: not-allowed;
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

        .search-form {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-box {
            position: relative;
            flex: 1;
        }

        .search-box i {
            position: absolute;
            top: 50%;
            left: 14px;
            transform: translateY(-50%);
            color: #8aa1b4;
        }

        .search-input {
            width: 100%;
            height: 46px;
            border: 1px solid #dbe6ef;
            border-radius: 14px;
            padding: 0 14px 0 42px;
            outline: none;
        }

        .search-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(134, 182, 246, 0.22);
        }

        .filter-select {
            height: 46px;
            border: 1px solid #dbe6ef;
            border-radius: 14px;
            padding: 0 14px;
            outline: none;
            min-width: 170px;
            color: var(--text);
            background: #fff;
            font-weight: 600;
        }

        .filter-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(134, 182, 246, 0.22);
        }

        .btn-search {
            height: 46px;
            border: none;
            background: var(--primary-dark);
            color: #ffffff;
            border-radius: 14px;
            padding: 0 18px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            white-space: nowrap;
        }

        .btn-search:hover {
            background: #095b82;
            color: #ffffff;
        }

        .btn-reset {
            height: 46px;
            border: 1px solid #dbe6ef;
            background: #ffffff;
            color: var(--text);
            border-radius: 14px;
            padding: 0 16px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
            cursor: pointer;
        }

        .btn-reset:hover {
            background: var(--primary-soft);
            color: var(--primary-dark);
        }

        .result-info {
            color: var(--muted);
            font-size: .9rem;
            font-weight: 600;
            margin-bottom: 14px;
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

        .staff-name,
        .barang-name {
            font-weight: 800;
            color: var(--text);
        }

        .text-sub {
            font-size: .84rem;
            color: var(--muted);
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: .78rem;
            font-weight: 800;
            white-space: nowrap;
        }

        .status-menunggu {
            background: var(--warning-soft);
            color: var(--warning);
        }

        .status-disetujui {
            background: var(--success-soft);
            color: var(--success);
        }

        .status-ditolak {
            background: var(--danger-soft);
            color: var(--danger);
        }

        .status-default {
            background: var(--primary-soft);
            color: var(--primary-dark);
        }

        .btn-action {
            min-width: 34px;
            height: 34px;
            border: none;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 10px;
            margin-right: 4px;
            text-decoration: none;
            font-size: .85rem;
            font-weight: 700;
            gap: 5px;
        }

        .btn-setuju {
            background: var(--success-soft);
            color: var(--success);
        }

        .btn-setuju:hover {
            background: var(--success);
            color: #fff;
        }

        .btn-tolak {
            background: var(--warning-soft);
            color: var(--warning);
        }

        .btn-tolak:hover {
            background: #d99a16;
            color: #fff;
        }

        .btn-delete {
            background: var(--danger-soft);
            color: #c64545;
        }

        .btn-delete:hover {
            background: var(--danger);
            color: #fff;
        }

        .processed-text {
            color: var(--muted);
            font-weight: 700;
            font-size: .88rem;
        }

        .alert-soft-success {
            background: var(--success-soft);
            border: 1px solid #cfe9d9;
            color: #1f7a45;
            border-radius: 16px;
            padding: 14px 18px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .alert-soft-danger {
            background: var(--danger-soft);
            border: 1px solid #ffd1d1;
            color: var(--danger);
            border-radius: 16px;
            padding: 14px 18px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .empty-state {
            text-align: center;
            padding: 42px 16px;
            color: var(--muted);
        }

        .empty-state i {
            font-size: 2.6rem;
            color: var(--primary-dark);
            margin-bottom: 10px;
            display: block;
        }

        .empty-state h5 {
            font-weight: 900;
            color: var(--text);
            margin-bottom: 6px;
        }

        .empty-search-row {
            display: none;
        }

        .pagination-wrapper {
            margin-top: 18px;
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

            .search-form {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-search,
            .btn-reset,
            .filter-select {
                width: 100%;
                justify-content: center;
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

    $hasUserRoute = \Illuminate\Support\Facades\Route::has('admin.user.index');
    $hasBarangMasukRoute = \Illuminate\Support\Facades\Route::has('admin.barang-masuk.index');
    $hasBarangKeluarRoute = \Illuminate\Support\Facades\Route::has('admin.barang-keluar.index');
    $hasLaporanStokRoute = \Illuminate\Support\Facades\Route::has('admin.laporan-stok.index');
    $hasLaporanTransaksiRoute = \Illuminate\Support\Facades\Route::has('admin.laporan-transaksi.index');
    $hasNotifikasiRoute = \Illuminate\Support\Facades\Route::has('admin.notifikasi-stok.index');
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
                <a href="{{ $hasUserRoute ? route('admin.user.index') : '#' }}"
                   class="{{ request()->routeIs('admin.user.*') ? 'active' : '' }} {{ !$hasUserRoute ? 'disabled' : '' }}">
                    <i class="bi bi-people"></i>
                    User
                </a>
            </li>
        </ul>

        <div class="menu-title">Transaksi</div>

        <ul class="menu">
            <li>
                <a href="{{ $hasBarangMasukRoute ? route('admin.barang-masuk.index') : '#' }}"
                   class="{{ request()->routeIs('admin.barang-masuk.*') ? 'active' : '' }} {{ !$hasBarangMasukRoute ? 'disabled' : '' }}">
                    <i class="bi bi-box-arrow-in-down"></i>
                    Barang Masuk
                </a>
            </li>

            <li>
                <a href="{{ $hasBarangKeluarRoute ? route('admin.barang-keluar.index') : '#' }}"
                   class="{{ request()->routeIs('admin.barang-keluar.*') ? 'active' : '' }} {{ !$hasBarangKeluarRoute ? 'disabled' : '' }}">
                    <i class="bi bi-box-arrow-up"></i>
                    Barang Keluar
                </a>
            </li>

            <li>
                <a href="{{ route('admin.permintaan-barang.index') }}"
                   class="{{ request()->routeIs('admin.permintaan-barang.*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-check"></i>
                    Permintaan Barang
                </a>
            </li>

            <li>
                <a href="{{ route('admin.pengembalian-barang.index') }}" class="active">
                    <i class="bi bi-arrow-counterclockwise"></i>
                    Pengembalian Barang
                </a>
            </li>
        </ul>

        <div class="menu-title">Laporan</div>

        <ul class="menu">
            <li>
                <a href="{{ $hasLaporanStokRoute ? route('admin.laporan-stok.index') : '#' }}"
                   class="{{ request()->routeIs('admin.laporan-stok.*') ? 'active' : '' }} {{ !$hasLaporanStokRoute ? 'disabled' : '' }}">
                    <i class="bi bi-file-earmark-text"></i>
                    Laporan Stok
                </a>
            </li>

            <li>
                <a href="{{ $hasLaporanTransaksiRoute ? route('admin.laporan-transaksi.index') : '#' }}"
                   class="{{ request()->routeIs('admin.laporan-transaksi.*') ? 'active' : '' }} {{ !$hasLaporanTransaksiRoute ? 'disabled' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                    Laporan Transaksi
                </a>
            </li>

            <li>
                <a href="{{ $hasNotifikasiRoute ? route('admin.notifikasi-stok.index') : '#' }}"
                   class="{{ request()->routeIs('admin.notifikasi-stok.*') ? 'active' : '' }} {{ !$hasNotifikasiRoute ? 'disabled' : '' }}">
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
                    <h3>PENGEMBALIAN BARANG</h3>
                    <p>Kelola persetujuan pengembalian barang dari staf</p>
                </div>
            </div>

            <div class="admin-badge">
                <i class="bi bi-person-circle"></i>
                {{ $namaAdmin }}
            </div>
        </div>

        <div class="content">
            <div class="page-header">
                <h4>Data Pengembalian Barang</h4>
                <p>Admin dapat menyetujui, menolak, atau menghapus pengembalian barang dari staf.</p>
            </div>

            @if (session('success'))
                <div class="alert-soft-success">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert-soft-danger">
                    <i class="bi bi-exclamation-circle-fill me-1"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="card-soft toolbar-card mb-4">
                <div class="search-form">
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input
                            type="text"
                            id="searchInput"
                            class="search-input"
                            placeholder="Cari staf / kode barang / nama barang / tanggal / keterangan..."
                        >
                    </div>

                    <select id="statusFilter" class="filter-select">
                        <option value="">Semua Status</option>
                        <option value="menunggu">Menunggu</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="ditolak">Ditolak</option>
                    </select>

                    <button type="button" class="btn-search" id="searchButton">
                        <i class="bi bi-search"></i>
                        Cari
                    </button>

                    <button type="button" class="btn-reset" id="resetButton">
                        Reset
                    </button>
                </div>
            </div>

            <div class="card-soft table-card">
                <div class="result-info" id="resultInfo">
                    Gunakan pencarian untuk menemukan pengembalian barang dengan cepat.
                </div>

                <div class="table-responsive">
                    <table class="table table-custom table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Staf</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Bukti</th>
                                <th width="230" class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="requestTableBody">
                            @forelse ($pengembalianBarang as $item)
                                @php
                                    $tanggal = $item->tanggal_pengembalian
                                        ? \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d-m-Y')
                                        : '-';

                                    $status = strtolower(trim($item->status ?? ''));
                                    $staffName = $item->user->name ?? '-';
                                    $kodeBarang = $item->barang->kode_barang ?? '-';
                                    $namaBarang = $item->barang->nama_barang ?? '-';
                                    $jumlah = $item->jumlah ?? 0;
                                    $keterangan = $item->keterangan ?: '-';

                                    $searchText = strtolower(
                                        $tanggal . ' ' .
                                        $staffName . ' ' .
                                        $kodeBarang . ' ' .
                                        $namaBarang . ' ' .
                                        $jumlah . ' ' .
                                        $status . ' ' .
                                        $keterangan
                                    );
                                @endphp

                                <tr
                                    class="request-row"
                                    data-search="{{ $searchText }}"
                                    data-status="{{ $status }}"
                                >
                                    <td class="row-number">{{ $loop->iteration }}</td>

                                    <td>{{ $tanggal }}</td>

                                    <td>
                                        <div class="staff-name">{{ $staffName }}</div>
                                        <div class="text-sub">Pengaju</div>
                                    </td>

                                    <td>{{ $kodeBarang }}</td>

                                    <td>
                                        <div class="barang-name">{{ $namaBarang }}</div>
                                    </td>

                                    <td>
                                        <strong>{{ $jumlah }}</strong>
                                        {{ $item->barang->satuan ?? '' }}
                                    </td>

                                    <td>
                                        @if ($item->status === 'Menunggu')
                                            <span class="badge-status status-menunggu">
                                                <i class="bi bi-hourglass-split"></i>
                                                Menunggu
                                            </span>
                                        @elseif ($item->status === 'Disetujui')
                                            <span class="badge-status status-disetujui">
                                                <i class="bi bi-check-circle"></i>
                                                Disetujui
                                            </span>
                                        @elseif ($item->status === 'Ditolak')
                                            <span class="badge-status status-ditolak">
                                                <i class="bi bi-x-circle"></i>
                                                Ditolak
                                            </span>
                                        @else
                                            <span class="badge-status status-default">
                                                {{ $item->status ?? '-' }}
                                            </span>
                                        @endif
                                    </td>

                                    <td>{{ $keterangan }}</td>

                                    <td>
                                        @if ($item->foto_bukti)
                                            <a href="{{ asset($item->foto_bukti) }}" target="_blank" title="Lihat bukti pengembalian">
                                                <img src="{{ asset($item->foto_bukti) }}" alt="Bukti"
                                                     style="width:52px; height:52px; object-fit:cover; border-radius:10px; border:1px solid var(--border);">
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if ($item->status === 'Menunggu')
                                            <form action="{{ route('admin.pengembalian-barang.setuju', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')

                                                <button type="submit" class="btn-action btn-setuju" onclick="return confirm('Setujui pengembalian ini?')">
                                                    <i class="bi bi-check-circle"></i>
                                                    Setuju
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.pengembalian-barang.tolak', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')

                                                <button type="submit" class="btn-action btn-tolak" onclick="return confirm('Tolak pengembalian ini?')">
                                                    <i class="bi bi-x-circle"></i>
                                                    Tolak
                                                </button>
                                            </form>
                                        @else
                                            <span class="processed-text">
                                                Sudah diproses
                                            </span>
                                        @endif

                                        <form action="{{ route('admin.pengembalian-barang.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn-action btn-delete" onclick="return confirm('Hapus data pengembalian ini?')">
                                                <i class="bi bi-trash"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">
                                        <div class="empty-state">
                                            <i class="bi bi-clipboard-check"></i>
                                            <h5>Belum ada pengembalian barang</h5>
                                            <p class="mb-0">
                                                Pengembalian barang dari staf akan muncul di halaman ini.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                            <tr class="empty-search-row" id="emptySearchRow">
                                <td colspan="10">
                                    <div class="empty-state">
                                        <i class="bi bi-search"></i>
                                        <h5>Data tidak ditemukan</h5>
                                        <p class="mb-0">
                                            Tidak ada pengembalian barang yang sesuai dengan pencarian.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                @if(method_exists($pengembalianBarang, 'links'))
                    <div class="pagination-wrapper">
                        {{ $pengembalianBarang->withQueryString()->links() }}
                    </div>
                @endif
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

    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const searchButton = document.getElementById('searchButton');
    const resetButton = document.getElementById('resetButton');
    const resultInfo = document.getElementById('resultInfo');
    const requestRows = document.querySelectorAll('.request-row');
    const emptySearchRow = document.getElementById('emptySearchRow');

    function filterPengembalian() {
        const keyword = (searchInput?.value || '').toLowerCase().trim();
        const status = (statusFilter?.value || '').toLowerCase().trim();

        let visibleCount = 0;

        requestRows.forEach(function (row) {
            const rowText = row.getAttribute('data-search') || '';
            const rowStatus = row.getAttribute('data-status') || '';

            const matchKeyword = keyword === '' || rowText.includes(keyword);
            const matchStatus = status === '' || rowStatus === status;

            if (matchKeyword && matchStatus) {
                row.style.display = '';
                visibleCount++;

                const numberCell = row.querySelector('.row-number');

                if (numberCell) {
                    numberCell.textContent = visibleCount;
                }
            } else {
                row.style.display = 'none';
            }
        });

        if (emptySearchRow) {
            emptySearchRow.style.display = visibleCount === 0 && requestRows.length > 0 ? 'table-row' : 'none';
        }

        if (resultInfo) {
            if (keyword || status) {
                resultInfo.innerHTML = '<i class="bi bi-info-circle me-1"></i> Menampilkan ' + visibleCount + ' hasil pencarian.';
            } else {
                resultInfo.innerHTML = 'Gunakan pencarian untuk menemukan pengembalian barang dengan cepat.';
            }
        }
    }

    if (searchInput) {
        searchInput.addEventListener('keyup', filterPengembalian);
    }

    if (statusFilter) {
        statusFilter.addEventListener('change', filterPengembalian);
    }

    if (searchButton) {
        searchButton.addEventListener('click', filterPengembalian);
    }

    if (resetButton) {
        resetButton.addEventListener('click', function () {
            if (searchInput) {
                searchInput.value = '';
            }

            if (statusFilter) {
                statusFilter.value = '';
            }

            filterPengembalian();
        });
    }
</script>
</body>
</html>