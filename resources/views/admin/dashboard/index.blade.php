<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INVENDAM</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #86B6F6;
            --primary-dark: #0d6f9d;
            --primary-soft: #e9f7fd;
            --bg: #f4f8fb;
            --text: #24323d;
            --muted: #6c7a86;
            --white: #ffffff;
            --danger-soft: #fff1f1;
            --warning-soft: #fff8e8;
            --success-soft: #eefbf3;
            --sidebar: #0f5f86;
            --sidebar-dark: #0b4f70;
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
            top: 0;
            left: 0;
            bottom: 0;
            padding: 24px 18px;
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

        .sidebar::-webkit-scrollbar-thumb,
        .content::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.22);
            border-radius: 999px;
        }

        .content::-webkit-scrollbar-thumb {
            background: #cfdbe5;
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

        .menu a {
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
        }

        .menu a:hover,
        .menu a.active {
            background: rgba(255, 255, 255, 0.14);
        }

        .menu a i {
            font-size: 1.05rem;
        }

        .logout-form {
            margin: 0;
        }

        .logout-btn {
            width: 100%;
            border: none;
            background: transparent;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 14px;
            font-size: .95rem;
            font-weight: 600;
            transition: .2s ease;
            text-align: left;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.14);
        }

        .logout-btn i {
            font-size: 1.05rem;
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
            background: #f7fbfd;
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

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .notif-badge {
            position: relative;
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: #ffffff;
            border: 1px solid #dce8ef;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-dark);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.05);
            cursor: pointer;
            flex-shrink: 0;
            transition: .2s ease;
        }

        .notif-badge:hover {
            background: var(--primary-soft);
            color: var(--primary-dark);
            transform: translateY(-2px);
        }

        .notif-badge i {
            font-size: 1.2rem;
        }

        .notif-count {
            position: absolute;
            top: -4px;
            right: -2px;
            min-width: 20px;
            height: 20px;
            padding: 0 5px;
            border-radius: 999px;
            background: #dc3545;
            color: #fff;
            font-size: .72rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-dropdown {
            position: relative;
        }

        .profile-btn {
            border: none;
            background: var(--primary-soft);
            color: var(--primary-dark);
            padding: 8px 14px 8px 8px;
            border-radius: 999px;
            font-weight: 700;
            font-size: .9rem;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            cursor: pointer;
        }

        .profile-btn:hover {
            background: #dff1fb;
        }

        .profile-avatar {
            width: 36px;
            height: 36px;
            border-radius: 999px;
            object-fit: cover;
            border: 2px solid var(--primary);
            background: #ffffff;
            display: block;
        }

        .profile-menu {
            position: absolute;
            right: 0;
            top: 58px;
            width: 220px;
            background: #fff;
            border: 1px solid #e8eef3;
            border-radius: 16px;
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.12);
            padding: 8px;
            display: none;
            z-index: 1200;
        }

        .profile-menu.show {
            display: block;
        }

        .profile-menu a,
        .profile-menu button {
            width: 100%;
            border: none;
            background: transparent;
            color: var(--text);
            text-decoration: none;
            padding: 11px 12px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: .92rem;
            font-weight: 600;
            text-align: left;
        }

        .profile-menu a:hover,
        .profile-menu button:hover {
            background: var(--primary-soft);
            color: var(--primary-dark);
        }

        .profile-divider {
            height: 1px;
            background: #edf1f4;
            margin: 6px 0;
        }

        .logout-dropdown-btn {
            color: #dc3545 !important;
        }

        .logout-dropdown-btn:hover {
            background: #fff1f1 !important;
            color: #dc3545 !important;
        }

        .content {
            flex: 1;
            overflow-y: auto;
            padding: 28px;
        }

        .card-soft {
            background: var(--white);
            border: 1px solid #e7edf2;
            border-radius: 20px;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.04);
            height: 100%;
        }

        .stat-card {
            padding: 22px;
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.45rem;
        }

        .icon-blue {
            background: var(--primary-soft);
            color: var(--primary-dark);
        }

        .icon-green {
            background: var(--success-soft);
            color: #1f8a4c;
        }

        .icon-orange {
            background: var(--warning-soft);
            color: #c38712;
        }

        .icon-red {
            background: var(--danger-soft);
            color: #cb4d4d;
        }

        .stat-label {
            color: var(--muted);
            font-size: .94rem;
            margin-bottom: 6px;
        }

        .stat-value {
            font-size: 1.9rem;
            font-weight: 800;
            margin: 0;
            color: var(--text);
        }

        .section-card {
            padding: 24px;
        }

        .section-card h5 {
            margin: 0 0 18px;
            color: var(--primary-dark);
            font-weight: 800;
        }

        .quick-menu {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .quick-item {
            border: 1px solid #e8eef3;
            border-radius: 18px;
            padding: 18px 14px;
            text-align: center;
            text-decoration: none;
            color: var(--text);
            background: #fff;
            transition: .2s ease;
        }

        .quick-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, .06);
            border-color: #cfe4ef;
        }

        .quick-item i {
            font-size: 1.6rem;
            color: var(--primary-dark);
            margin-bottom: 10px;
            display: block;
        }

        .quick-item span {
            font-size: .92rem;
            font-weight: 700;
        }

        .table-custom thead th {
            background: #f7fafc;
            color: var(--primary-dark);
            font-weight: 700;
            border-bottom: 1px solid #dce5ec;
        }

        .badge-status {
            padding: 7px 12px;
            border-radius: 999px;
            font-size: .78rem;
            font-weight: 700;
        }

        .badge-danger-soft {
            background: var(--danger-soft);
            color: #b33838;
        }

        .notif-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .notif-item {
            padding: 14px 16px;
            border-radius: 16px;
            border: 1px solid #edf1f4;
            background: #fff;
        }

        .notif-item.warning {
            background: var(--warning-soft);
        }

        .notif-item.danger {
            background: var(--danger-soft);
        }

        .notif-item.success {
            background: var(--success-soft);
        }

        .notif-item h6 {
            margin: 0 0 6px;
            font-size: .95rem;
            font-weight: 800;
        }

        .notif-item p {
            margin: 0;
            font-size: .88rem;
            color: #4d5d6b;
        }

        .btn-delete-aktivitas {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 12px;
            background: #fff1f1;
            color: #dc3545;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: .2s ease;
            flex-shrink: 0;
        }

        .btn-delete-aktivitas:hover {
            background: #dc3545;
            color: #fff;
        }

        @media (max-width: 991px) {
            .quick-menu {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .topbar {
                padding: 16px 18px;
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .topbar-left,
            .topbar-right {
                width: 100%;
            }

            .topbar-right {
                justify-content: flex-start;
            }

            .content {
                padding: 18px;
            }

            .quick-menu {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
@php
    $logoKantor = asset('images/logo.png');
    $userLogin = auth()->user();
    $namaAdmin = $userLogin->name ?? 'Admin';

    $fotoProfil = asset('uploads/foto-profil/avatar.png');

    if ($userLogin && !empty($userLogin->foto)) {
        $foto = ltrim($userLogin->foto, '/');
        $versiFoto = optional($userLogin->updated_at)->timestamp ?? time();

        if (str_starts_with($foto, 'http://') || str_starts_with($foto, 'https://')) {
            $fotoProfil = $foto;
        } elseif (str_starts_with($foto, 'storage/')) {
            $fotoProfil = asset($foto) . '?v=' . $versiFoto;
        } elseif (str_starts_with($foto, 'uploads/')) {
            $fotoProfil = asset($foto) . '?v=' . $versiFoto;
        } elseif (file_exists(public_path('storage/' . $foto))) {
            $fotoProfil = asset('storage/' . $foto) . '?v=' . $versiFoto;
        } elseif (file_exists(public_path($foto))) {
            $fotoProfil = asset($foto) . '?v=' . $versiFoto;
        }
    }
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
                    <h3>INVENDAM DASHBOARD</h3>
                    <p>Selamat datang di sistem inventory PDAM Bengkayang</p>
                </div>
            </div>

            <div class="topbar-right">
                <a href="{{ route('admin.notifikasi-stok.index') }}" class="notif-badge text-decoration-none">
                    <i class="bi bi-bell-fill"></i>

                    @if (($jumlahNotifikasiStok ?? 0) > 0)
                        <span class="notif-count">{{ $jumlahNotifikasiStok }}</span>
                    @endif
                </a>

                <div class="profile-dropdown">
                    <button type="button" class="profile-btn" id="profileToggle">
                        <img
                            src="{{ $fotoProfil }}"
                            alt="Foto Profil"
                            class="profile-avatar"
                            onerror="this.src='{{ asset('uploads/foto-profil/avatar.jpg') }}'"
                        >

                        <span>{{ $namaAdmin }}</span>
                        <i class="bi bi-chevron-down"></i>
                    </button>

                    <div class="profile-menu" id="profileMenu">
                        @if (Route::has('admin.profile.edit'))
                            <a href="{{ route('admin.profile.edit') }}">
                                <i class="bi bi-person-gear"></i>
                                Edit Profil
                            </a>
                        @elseif (Route::has('profile.edit'))
                            <a href="{{ route('profile.edit') }}">
                                <i class="bi bi-person-gear"></i>
                                Edit Profil
                            </a>
                        @else
                            <a href="#">
                                <i class="bi bi-person-gear"></i>
                                Edit Profil
                            </a>
                        @endif

                        <div class="profile-divider"></div>

                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf

                            <button type="submit" class="logout-dropdown-btn">
                                <i class="bi bi-box-arrow-left"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="row g-4 mb-4">
                <div class="col-md-6 col-xl-3">
                    <div class="card-soft stat-card">
                        <div class="stat-top">
                            <div>
                                <div class="stat-label">Total Barang</div>
                                <h3 class="stat-value">{{ $totalBarang ?? 0 }}</h3>
                            </div>

                            <div class="stat-icon icon-blue">
                                <i class="bi bi-box-seam"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card-soft stat-card">
                        <div class="stat-top">
                            <div>
                                <div class="stat-label">Supplier</div>
                                <h3 class="stat-value">{{ $totalSupplier ?? 0 }}</h3>
                            </div>

                            <div class="stat-icon icon-green">
                                <i class="bi bi-truck"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card-soft stat-card">
                        <div class="stat-top">
                            <div>
                                <div class="stat-label">Permintaan Masuk</div>
                                <h3 class="stat-value">{{ $jumlahPermintaanMenunggu ?? 0 }}</h3>
                            </div>

                            <div class="stat-icon icon-orange">
                                <i class="bi bi-clipboard-check"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card-soft stat-card">
                        <div class="stat-top">
                            <div>
                                <div class="stat-label">Stok Minimum</div>
                                <h3 class="stat-value">{{ $jumlahNotifikasiStok ?? 0 }}</h3>
                            </div>

                            <div class="stat-icon icon-red">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-lg-8">
                    <div class="card-soft section-card">
                        <h5>Akses Cepat</h5>

                        <div class="quick-menu">
                            <a href="{{ route('admin.barang.index') }}" class="quick-item">
                                <i class="bi bi-box-seam"></i>
                                <span>Data Barang</span>
                            </a>

                            <a href="{{ route('admin.supplier.index') }}" class="quick-item">
                                <i class="bi bi-truck"></i>
                                <span>Supplier</span>
                            </a>

                            <a href="{{ route('admin.user.index') }}" class="quick-item">
                                <i class="bi bi-people"></i>
                                <span>Data User</span>
                            </a>

                            <a href="{{ route('admin.barang-masuk.index') }}" class="quick-item">
                                <i class="bi bi-box-arrow-in-down"></i>
                                <span>Barang Masuk</span>
                            </a>

                            <a href="{{ route('admin.barang-keluar.index') }}" class="quick-item">
                                <i class="bi bi-box-arrow-up"></i>
                                <span>Barang Keluar</span>
                            </a>

                            <a href="{{ route('admin.laporan-transaksi.index') }}" class="quick-item">
                                <i class="bi bi-file-earmark-bar-graph"></i>
                                <span>Laporan</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card-soft section-card">
                        <h5>Notifikasi</h5>

                        <div class="notif-list">
                            @if (($jumlahNotifikasiStok ?? 0) > 0)
                                <div class="notif-item danger">
                                    <h6>Stok barang rendah</h6>
                                    <p>Ada {{ $jumlahNotifikasiStok }} barang yang sudah mencapai batas minimum.</p>
                                </div>
                            @else
                                <div class="notif-item success">
                                    <h6>Stok aman</h6>
                                    <p>Tidak ada barang yang berada di bawah batas minimum.</p>
                                </div>
                            @endif

                            @if (($jumlahPermintaanMenunggu ?? 0) > 0)
                                <div class="notif-item warning">
                                    <h6>Permintaan barang baru</h6>
                                    <p>Ada {{ $jumlahPermintaanMenunggu }} permintaan barang yang menunggu persetujuan.</p>
                                </div>
                            @else
                                <div class="notif-item success">
                                    <h6>Tidak ada permintaan baru</h6>
                                    <p>Semua permintaan barang sudah diproses.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card-soft section-card">
                        <h5>Barang dengan Stok Minimum</h5>

                        <div class="table-responsive">
                            <table class="table table-custom align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama Barang</th>
                                        <th>Stok</th>
                                        <th>Minimum</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse (($barangStokMinimum ?? collect()) as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->kode_barang }}</td>
                                            <td>{{ $item->nama_barang }}</td>
                                            <td>{{ $item->stok }}</td>
                                            <td>{{ $item->minimum_stok }}</td>
                                            <td>
                                                <span class="badge-status badge-danger-soft">
                                                    Stok Rendah
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                Tidak ada barang dengan stok rendah.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card-soft section-card">
                        <h5>Aktivitas Hari Ini</h5>

                        <div class="notif-list">
                            @forelse (($aktivitasHariIni ?? collect()) as $aktivitas)
                                <div class="notif-item">
                                    <div class="d-flex justify-content-between align-items-start gap-3">
                                        <div>
                                            <h6>{{ $aktivitas->aktivitas }}</h6>
                                            <p>{{ $aktivitas->deskripsi }}</p>
                                            <small class="text-muted">
                                                {{ $aktivitas->created_at->format('H:i') }}
                                                oleh {{ $aktivitas->user->name ?? 'Sistem' }}
                                            </small>
                                        </div>

                                        <form action="{{ route('admin.aktivitas.destroy', $aktivitas->id) }}" method="POST" onsubmit="return confirm('Hapus aktivitas ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn-delete-aktivitas" title="Hapus aktivitas">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="notif-item">
                                    <h6>Belum ada aktivitas</h6>
                                    <p>Aktivitas admin hari ini akan muncul di sini.</p>
                                </div>
                            @endforelse
                        </div>

                        <a href="{{ route('admin.aktivitas.index') }}" class="btn btn-light mt-3 w-100">
                            Lihat Semua Aktivitas
                        </a>
                    </div>
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

    const profileToggle = document.getElementById('profileToggle');
    const profileMenu = document.getElementById('profileMenu');

    if (profileToggle && profileMenu) {
        profileToggle.addEventListener('click', function (event) {
            event.stopPropagation();
            profileMenu.classList.toggle('show');
        });

        document.addEventListener('click', function (event) {
            if (!profileMenu.contains(event.target) && !profileToggle.contains(event.target)) {
                profileMenu.classList.remove('show');
            }
        });
    }
</script>

</body>
</html>