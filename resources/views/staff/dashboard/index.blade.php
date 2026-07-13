<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Staf - INVENDAM</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #86B6F6;
            --primary-dark: #0d6f9d;
            --primary-mid: #159bd8;
            --primary-soft: #e9f7fd;
            --primary-extra-soft: #f4faff;

            --bg: #f4f8fb;
            --white: #ffffff;
            --text: #24323d;
            --muted: #6c7a86;
            --border: #e7edf2;

            --sidebar: #0f5f86;
            --sidebar-dark: #0b4f70;

            --success: #198754;
            --success-soft: #eefbf3;
            --warning: #b7791f;
            --warning-soft: #fff8e8;
            --danger: #dc3545;
            --danger-soft: #fff1f1;

            --shadow: 0 18px 45px rgba(15, 95, 134, 0.10);
            --soft-shadow: 0 10px 28px rgba(15, 95, 134, 0.07);
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
            background:
                radial-gradient(circle at top right, rgba(134, 182, 246, 0.20), transparent 30%),
                linear-gradient(180deg, #f8fbff 0%, var(--bg) 100%);
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
            border-bottom: 1px solid rgba(255,255,255,0.14);
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
                drop-shadow(0 0 2px rgba(255,255,255,0.9))
                drop-shadow(0 0 7px rgba(255,255,255,0.7));
        }

        .brand-text h4 {
            margin: 0;
            font-size: 1rem;
            font-weight: 900;
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
            opacity: .82;
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
            font-weight: 700;
            transition: .2s ease;
            text-align: left;
        }

        .menu a:hover,
        .menu a.active,
        .logout-btn:hover {
            background: rgba(255,255,255,0.14);
        }

        .menu a.active {
            box-shadow: inset 4px 0 0 rgba(255,255,255,0.55);
        }

        .menu a i,
        .logout-btn i {
            font-size: 1.05rem;
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
            background: rgba(255,255,255,0.96);
            padding: 18px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 8px 22px rgba(15, 95, 134, 0.04);
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
            border-radius: 14px;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            cursor: pointer;
            box-shadow: 0 8px 18px rgba(15, 95, 134, 0.06);
        }

        .menu-toggle:hover {
            background: var(--primary-soft);
        }

        .topbar h3 {
            margin: 0;
            font-size: 1.35rem;
            font-weight: 900;
            color: var(--primary-dark);
            letter-spacing: .3px;
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

        .profile-dropdown {
            position: relative;
        }

        .profile-btn {
            border: 1px solid #d8edf8;
            background: var(--primary-soft);
            color: var(--primary-dark);
            padding: 8px 14px 8px 8px;
            border-radius: 999px;
            font-weight: 800;
            font-size: .9rem;
            display: flex;
            align-items: center;
            gap: 9px;
            white-space: nowrap;
            cursor: pointer;
            min-width: 210px;
        }

        .profile-btn:hover {
            background: #dff1fb;
        }

        .profile-avatar {
            width: 38px;
            height: 38px;
            border-radius: 999px;
            object-fit: cover;
            border: 2px solid var(--primary);
            background: #ffffff;
            display: block;
            flex-shrink: 0;
        }

        .profile-text {
            flex: 1;
            min-width: 0;
            text-align: left;
            line-height: 1.15;
        }

        .profile-name {
            color: var(--text);
            font-weight: 900;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 130px;
        }

        .profile-role {
            color: var(--muted);
            font-size: .78rem;
            font-weight: 700;
            margin-top: 2px;
        }

        .profile-menu {
            position: absolute;
            right: 0;
            top: 60px;
            width: 220px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: 0 16px 32px rgba(0,0,0,.12);
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
            padding: 12px 13px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            font-weight: 700;
            text-align: left;
        }

        .profile-menu a:hover {
            background: var(--primary-soft);
            color: var(--primary-dark);
        }

        .logout-dropdown-btn {
            color: var(--danger) !important;
        }

        .logout-dropdown-btn:hover {
            background: var(--danger-soft) !important;
            color: var(--danger) !important;
        }

        .profile-divider {
            height: 1px;
            background: #edf1f4;
            margin: 6px 0;
        }

        .content {
            flex: 1;
            overflow-y: auto;
            padding: 28px;
        }

        .hero-card {
            background:
                radial-gradient(circle at top right, rgba(255,255,255,0.28), transparent 30%),
                linear-gradient(135deg, var(--primary-mid), var(--primary-dark));
            color: #fff;
            border-radius: 26px;
            padding: 28px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 18px 38px rgba(13, 111, 157, 0.18);
        }

        .hero-card::after {
            content: "";
            position: absolute;
            right: -70px;
            bottom: -80px;
            width: 230px;
            height: 230px;
            background: rgba(255,255,255,0.16);
            border-radius: 50%;
        }

        .hero-card::before {
            content: "";
            position: absolute;
            right: 110px;
            top: 28px;
            width: 72px;
            height: 72px;
            background: rgba(255,255,255,0.12);
            border-radius: 22px;
            transform: rotate(18deg);
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-card h4 {
            font-size: 1.55rem;
            font-weight: 900;
            margin-bottom: 8px;
        }

        .hero-card p {
            margin: 0;
            max-width: 680px;
            color: #f4f9ff;
            line-height: 1.6;
        }

        .hero-actions {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .btn-hero {
            border: none;
            background: #fff;
            color: var(--primary-dark);
            border-radius: 15px;
            padding: 11px 18px;
            font-weight: 900;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            box-shadow: 0 10px 22px rgba(0,0,0,0.08);
        }

        .btn-hero:hover {
            color: var(--primary-dark);
            background: #f5f9ff;
            transform: translateY(-1px);
        }

        .btn-hero-outline {
            border: 1px solid rgba(255,255,255,0.55);
            background: rgba(255,255,255,0.14);
            color: #fff;
            border-radius: 15px;
            padding: 11px 18px;
            font-weight: 900;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .btn-hero-outline:hover {
            color: #fff;
            background: rgba(255,255,255,0.24);
            transform: translateY(-1px);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: rgba(255,255,255,0.98);
            border: 1px solid var(--border);
            border-radius: 22px;
            padding: 20px;
            box-shadow: var(--soft-shadow);
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: "";
            position: absolute;
            right: -32px;
            top: -32px;
            width: 96px;
            height: 96px;
            border-radius: 50%;
            background: var(--primary-extra-soft);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(15, 95, 134, 0.10);
        }

        .stat-inner {
            position: relative;
            z-index: 2;
        }

        .stat-icon {
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

        .icon-wait {
            background: var(--warning-soft);
            color: var(--warning);
        }

        .icon-approve {
            background: var(--success-soft);
            color: var(--success);
        }

        .icon-reject {
            background: var(--danger-soft);
            color: var(--danger);
        }

        .stat-label {
            color: var(--muted);
            font-size: .88rem;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 900;
            color: var(--text);
            line-height: 1;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 18px;
        }

        .card-soft {
            background: rgba(255,255,255,0.98);
            border: 1px solid var(--border);
            border-radius: 22px;
            box-shadow: var(--soft-shadow);
            overflow: hidden;
        }

        .card-head {
            padding: 20px 22px;
            border-bottom: 1px solid #edf2f7;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
        }

        .card-head h5 {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 900;
            color: var(--primary-dark);
        }

        .card-head p {
            margin: 4px 0 0;
            color: var(--muted);
            font-size: .86rem;
        }

        .btn-outline-primary {
            border-color: var(--primary);
            color: var(--primary-dark);
            font-weight: 800;
        }

        .btn-outline-primary:hover {
            background: var(--primary-mid);
            border-color: var(--primary-mid);
            color: #fff;
        }

        .card-body-soft {
            padding: 22px;
        }

        .request-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .request-item {
            border: 1px solid #edf2f7;
            border-radius: 18px;
            padding: 16px;
            display: flex;
            justify-content: space-between;
            gap: 14px;
            align-items: center;
            background: #fbfdff;
            transition: .2s ease;
        }

        .request-item:hover {
            background: #f6fbff;
            border-color: #dceefa;
            transform: translateY(-1px);
        }

        .request-title {
            font-weight: 900;
            color: var(--text);
            margin-bottom: 4px;
        }

        .request-meta {
            color: var(--muted);
            font-size: .86rem;
        }

        .status-badge {
            border-radius: 999px;
            padding: 8px 12px;
            font-size: .78rem;
            font-weight: 900;
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

        .empty-state {
            text-align: center;
            padding: 36px 18px;
            color: var(--muted);
        }

        .empty-state i {
            font-size: 2.5rem;
            color: var(--primary-dark);
            margin-bottom: 10px;
        }

        .empty-state strong {
            display: block;
            color: var(--text);
            font-weight: 900;
            margin-bottom: 4px;
        }

        @media (max-width: 992px) {
            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 576px) {
            .topbar {
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

            .profile-dropdown,
            .profile-btn {
                width: 100%;
            }

            .profile-menu {
                left: 0;
                right: auto;
                width: 100%;
            }

            .profile-name {
                max-width: none;
            }

            .content {
                padding: 18px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .hero-card {
                padding: 22px;
            }

            .request-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .card-head {
                flex-direction: column;
                align-items: flex-start;
            }

            .hero-actions a {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
@php
    $logoKantor = asset('images/logo.png');
    $userLogin = auth()->user();
    $namaUser = $userLogin->name ?? 'Staf';

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

    $roleName = optional($userLogin->role)->name ?? 'Staf';

    $statusClassStaff = function ($status) {
        $status = strtolower(trim($status ?? ''));

        if ($status === 'menunggu') {
            return 'status-menunggu';
        }

        if ($status === 'disetujui') {
            return 'status-disetujui';
        }

        if ($status === 'ditolak') {
            return 'status-ditolak';
        }

        return 'status-default';
    };
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
                <span>Staff Area</span>
            </div>
        </div>

        <div class="menu-title">Menu Staf</div>
        <ul class="menu">
            <li>
                <a href="{{ route('staff.dashboard') }}" class="active">
                    <i class="bi bi-grid-1x2-fill"></i>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('staff.permintaan-barang.index') }}">
                    <i class="bi bi-clipboard-check"></i>
                    Permintaan Barang
                </a>
            </li>

            <li>
                <a href="{{ route('staff.permintaan-barang.create') }}">
                    <i class="bi bi-plus-circle"></i>
                    Buat Permintaan
                </a>
            </li>

            <li>
                <a href="{{ route('staff.pengembalian-barang.index') }}">
                    <i class="bi bi-arrow-counterclockwise"></i>
                    Pengembalian Barang
                </a>
            </li>

            <li>
                <a href="{{ route('staff.pengembalian-barang.create') }}">
                    <i class="bi bi-plus-circle-dotted"></i>
                    Ajukan Pengembalian
                </a>
            </li>
        </ul>

        <div class="menu-title">Akun</div>
        <ul class="menu">
            <li>
                @if (Route::has('staff.profile.edit'))
                    <a href="{{ route('staff.profile.edit') }}">
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
                    <h3>DASHBOARD STAF</h3>
                    <p>Kelola permintaan barang dengan mudah dan cepat</p>
                </div>
            </div>

            <div class="topbar-right">
                <div class="profile-dropdown">
                    <button type="button" class="profile-btn" id="profileToggle">
                        <img
                            src="{{ $fotoProfil }}"
                            alt="Foto Profil"
                            class="profile-avatar"
                            onerror="this.src='{{ asset('uploads/foto-profil/avatar.jpg') }}'"
                        >

                        <div class="profile-text">
                            <div class="profile-name">{{ $namaUser }}</div>
                            <div class="profile-role">{{ $roleName ?: 'Staf' }}</div>
                        </div>

                        <i class="bi bi-chevron-down"></i>
                    </button>

                    <div class="profile-menu" id="profileMenu">
                        @if (Route::has('staff.profile.edit'))
                            <a href="{{ route('staff.profile.edit') }}">
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
            <div class="hero-card">
                <div class="hero-content">
                    <h4>Selamat Datang, {{ $namaUser }} 👋</h4>
                    <p>
                        Melalui dashboard ini, staf dapat membuat permintaan barang,
                        memantau status pengajuan, dan melihat riwayat permintaan terbaru.
                    </p>

                    <div class="hero-actions">
                        <a href="{{ route('staff.permintaan-barang.create') }}" class="btn-hero">
                            <i class="bi bi-plus-circle"></i>
                            Buat Permintaan
                        </a>

                        <a href="{{ route('staff.permintaan-barang.index') }}" class="btn-hero-outline">
                            <i class="bi bi-clock-history"></i>
                            Lihat Riwayat
                        </a>
                    </div>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-inner">
                        <div class="stat-icon icon-total">
                            <i class="bi bi-clipboard-data"></i>
                        </div>
                        <div class="stat-label">Total Permintaan</div>
                        <div class="stat-value">{{ $totalPermintaan ?? 0 }}</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-inner">
                        <div class="stat-icon icon-wait">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div class="stat-label">Menunggu</div>
                        <div class="stat-value">{{ $permintaanMenunggu ?? 0 }}</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-inner">
                        <div class="stat-icon icon-approve">
                            <i class="bi bi-check2-circle"></i>
                        </div>
                        <div class="stat-label">Disetujui</div>
                        <div class="stat-value">{{ $permintaanDisetujui ?? 0 }}</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-inner">
                        <div class="stat-icon icon-reject">
                            <i class="bi bi-x-circle"></i>
                        </div>
                        <div class="stat-label">Ditolak</div>
                        <div class="stat-value">{{ $permintaanDitolak ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <div class="content-grid">
                <div class="card-soft">
                    <div class="card-head">
                        <div>
                            <h5>Permintaan Terbaru</h5>
                            <p>Daftar pengajuan barang terakhir dari akun staf ini.</p>
                        </div>

                        <a href="{{ route('staff.permintaan-barang.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                            Lihat Semua
                        </a>
                    </div>

                    <div class="card-body-soft">
                        @if(isset($permintaanTerbaru) && $permintaanTerbaru->count() > 0)
                            <div class="request-list">
                                @foreach($permintaanTerbaru as $item)
                                    @php
                                        $namaBarang = $item->barang->nama_barang
                                            ?? $item->nama_barang
                                            ?? $item->barang_nama
                                            ?? 'Barang';

                                        $jumlah = $item->jumlah
                                            ?? $item->jumlah_barang
                                            ?? '-';

                                        $status = $item->status ?? 'Menunggu';
                                    @endphp

                                    <div class="request-item">
                                        <div>
                                            <div class="request-title">{{ $namaBarang }}</div>

                                            <div class="request-meta">
                                                <i class="bi bi-box-seam me-1"></i>
                                                Jumlah: {{ $jumlah }}
                                                <span class="mx-1">•</span>
                                                <i class="bi bi-calendar3 me-1"></i>
                                                {{ optional($item->created_at)->format('d M Y') ?? '-' }}
                                            </div>
                                        </div>

                                        <span class="status-badge {{ $statusClassStaff($status) }}">
                                            {{ $status }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <div>
                                    <i class="bi bi-inbox"></i>
                                </div>

                                <strong>Belum ada permintaan barang</strong>

                                <p class="mb-0 mt-1">
                                    Klik tombol Buat Permintaan untuk mengajukan barang pertama.
                                </p>
                            </div>
                        @endif
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