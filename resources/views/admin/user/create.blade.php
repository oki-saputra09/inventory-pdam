<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Akun Staf - INVENDAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #86B6F6;
            --primary-dark: #0d6f9d;
            --primary-blue: #159bd8;
            --primary-soft: #e9f7fd;
            --bg: #f4f8fb;
            --white: #ffffff;
            --text: #24323d;
            --muted: #6c7a86;
            --border: #e7edf2;
            --sidebar: #0f5f86;
            --sidebar-dark: #0b4f70;
            --danger: #dc3545;
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
            background: var(--bg);
            color: var(--text);
            overflow: hidden;
        }

        .layout {
            width: 100%;
            height: 100vh;
            display: flex;
        }

        .main {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
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

        .menu a i,
        .logout-btn i {
            font-size: 1.05rem;
        }

        .logout-form {
            margin: 0;
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
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .content {
            flex: 1;
            overflow-y: auto;
            padding: 28px;
        }

        .page-header {
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-dark));
            color: #fff;
            border-radius: 22px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .page-header h4 {
            margin: 0 0 8px;
            font-weight: 800;
        }

        .page-header p {
            margin: 0;
            color: #eef6ff;
        }

        .card-soft {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 20px;
            box-shadow: var(--soft-shadow);
        }

        .form-card {
            padding: 24px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 22px 24px;
        }

        .form-label {
            display: block;
            margin-bottom: 9px;
            color: var(--text);
            font-weight: 800;
            font-size: .94rem;
        }

        .form-control-custom,
        .form-select-custom {
            width: 100%;
            min-height: 48px;
            border: 1px solid #dbe6ef;
            background: #fff;
            color: var(--text);
            padding: 10px 14px;
            border-radius: 14px;
            outline: none;
            font-size: .95rem;
            transition: .2s ease;
        }

        .form-control-custom:focus,
        .form-select-custom:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(134, 182, 246, .16);
        }

        .form-control-custom[readonly] {
            background: #f7fbfd;
            color: var(--muted);
            cursor: not-allowed;
        }

        .form-error {
            margin-top: 7px;
            color: var(--danger);
            font-size: .84rem;
            font-weight: 650;
        }

        .alert-error-custom {
            background: #fff1f1;
            color: var(--danger);
            border: 1px solid #ffd1d1;
            border-radius: 16px;
            padding: 14px 16px;
            font-weight: 700;
            margin-bottom: 18px;
        }

        .form-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #edf2f6;
        }

        .btn-primary-soft,
        .btn-light-soft {
            min-height: 46px;
            border-radius: 14px;
            padding: 0 18px;
            font-weight: 800;
            font-size: .92rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: .2s ease;
        }

        .btn-primary-soft {
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-dark));
            border: none;
            color: #fff;
        }

        .btn-primary-soft:hover {
            color: #fff;
            background: linear-gradient(135deg, #148bc2, #0b5f87);
        }

        .btn-light-soft {
            background: #f5f9ff;
            border: 1px solid #dbe6ef;
            color: var(--primary-dark);
        }

        .btn-light-soft:hover {
            background: var(--primary-soft);
            color: var(--primary-dark);
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-primary-soft,
            .btn-light-soft {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .topbar {
                padding: 16px 18px;
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .content {
                padding: 18px;
            }

            .form-card {
                padding: 20px;
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
            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.barang.index') }}" class="{{ request()->routeIs('admin.barang.*') ? 'active' : '' }}"><i class="bi bi-box-seam"></i> Data Barang</a></li>
            <li><a href="{{ route('admin.kategori.index') }}" class="{{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}"><i class="bi bi-tags"></i> Kategori</a></li>
            <li><a href="{{ route('admin.supplier.index') }}" class="{{ request()->routeIs('admin.supplier.*') ? 'active' : '' }}"><i class="bi bi-truck"></i> Supplier</a></li>
            <li><a href="{{ route('admin.user.index') }}" class="{{ request()->routeIs('admin.user.*') ? 'active' : '' }}"><i class="bi bi-people"></i> User</a></li>
        </ul>

        <div class="menu-title">Transaksi</div>
        <ul class="menu">
            <li><a href="{{ route('admin.barang-masuk.index') }}" class="{{ request()->routeIs('admin.barang-masuk.*') ? 'active' : '' }}"><i class="bi bi-box-arrow-in-down"></i> Barang Masuk</a></li>
            <li><a href="{{ route('admin.barang-keluar.index') }}" class="{{ request()->routeIs('admin.barang-keluar.*') ? 'active' : '' }}"><i class="bi bi-box-arrow-up"></i> Barang Keluar</a></li>
            <li><a href="{{ route('admin.permintaan-barang.index') }}" class="{{ request()->routeIs('admin.permintaan-barang.*') ? 'active' : '' }}"><i class="bi bi-clipboard-check"></i> Permintaan Barang</a></li>
        </ul>

        <div class="menu-title">Laporan</div>
        <ul class="menu">
            <li><a href="{{ route('admin.laporan-stok.index') }}" class="{{ request()->routeIs('admin.laporan-stok.*') ? 'active' : '' }}"><i class="bi bi-file-earmark-text"></i> Laporan Stok</a></li>
            <li><a href="{{ route('admin.laporan-transaksi.index') }}" class="{{ request()->routeIs('admin.laporan-transaksi.*') ? 'active' : '' }}"><i class="bi bi-file-earmark-bar-graph"></i> Laporan Transaksi</a></li>
            <li><a href="{{ route('admin.notifikasi-stok.index') }}" class="{{ request()->routeIs('admin.notifikasi-stok.*') ? 'active' : '' }}"><i class="bi bi-bell"></i> Notifikasi Stok</a></li>
            <li>
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="logout-btn"><i class="bi bi-box-arrow-left"></i> Logout</button>
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
                    <h3>TAMBAH AKUN STAF</h3>
                    <p>Buat akun staf agar dapat login ke dashboard staf</p>
                </div>
            </div>

            <div class="admin-badge">
                <i class="bi bi-person-circle"></i>
                <span>{{ $namaAdmin }}</span>
            </div>
        </div>

        <div class="content">
            <div class="page-header">
                <h4>Tambah Akun Staf</h4>
                <p>Admin dapat membuat akun staf baru untuk mengakses dashboard staf.</p>
            </div>

            @if(session('error'))
                <div class="alert-error-custom">
                    <i class="bi bi-exclamation-circle-fill me-1"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="card-soft form-card">
                <form method="POST" action="{{ route('admin.user.store') }}" autocomplete="off">
                    @csrf

                    <div class="form-grid">
                        <div>
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control-custom" required>
                            @error('name') <div class="form-error">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <label class="form-label">Username</label>
                            <input type="text" name="username" value="{{ old('username') }}" class="form-control-custom" required>
                            @error('username') <div class="form-error">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control-custom" required>
                            @error('email') <div class="form-error">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <label class="form-label">No HP</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="form-control-custom">
                            @error('no_hp') <div class="form-error">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select-custom" required>
                                <option value="aktif" {{ old('status', 'aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status') <div class="form-error">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <label class="form-label">Role</label>
                            <input type="text" value="Staf" class="form-control-custom" readonly>
                        </div>

                        <div>
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control-custom" required>
                            @error('password') <div class="form-error">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control-custom" required>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary-soft">
                            <i class="bi bi-check-circle"></i>
                            Simpan Akun
                        </button>

                        <a href="{{ route('admin.user.index') }}" class="btn-light-soft">
                            <i class="bi bi-arrow-left"></i>
                            Kembali
                        </a>
                    </div>
                </form>
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