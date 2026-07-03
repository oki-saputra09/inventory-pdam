<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data User Staf - INVENDAM</title>
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
            --white: #ffffff;
            --text: #24323d;
            --muted: #6c7a86;
            --border: #e7edf2;
            --sidebar: #0f5f86;
            --sidebar-dark: #0b4f70;
            --danger: #dc3545;
            --danger-soft: #fff1f1;
            --success: #198754;
            --success-soft: #eefbf3;
            --warning: #b7791f;
            --warning-soft: #fff8e8;
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
        }

        .btn-reset:hover {
            background: var(--primary-soft);
            color: var(--primary-dark);
        }

        .btn-primary-soft {
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-dark));
            border: none;
            color: #fff;
            border-radius: 14px;
            padding: 11px 18px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 18px rgba(13, 111, 157, 0.18);
        }

        .btn-primary-soft:hover {
            color: #fff;
            background: linear-gradient(135deg, var(--primary-dark), #095b82);
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

        .user-name {
            font-weight: 800;
            color: var(--text);
        }

        .user-sub {
            font-size: .84rem;
            color: var(--muted);
        }

        .badge-role,
        .badge-active,
        .badge-inactive {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: .78rem;
            font-weight: 800;
            white-space: nowrap;
        }

        .badge-role {
            background: var(--primary-soft);
            color: var(--primary-dark);
        }

        .badge-active {
            background: var(--success-soft);
            color: var(--success);
        }

        .badge-inactive {
            background: var(--danger-soft);
            color: var(--danger);
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

        .btn-edit {
            background: var(--primary-soft);
            color: var(--primary-dark);
        }

        .btn-edit:hover {
            background: #d7ecfb;
            color: var(--primary-dark);
        }

        .btn-delete {
            background: var(--danger-soft);
            color: #c64545;
        }

        .btn-delete:hover {
            background: var(--danger);
            color: #fff;
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
            .btn-primary-soft {
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
                    <h3>DATA USER STAF</h3>
                    <p>Kelola akun staf yang dapat login ke dashboard staf</p>
                </div>
            </div>

            <div class="admin-badge">
                <i class="bi bi-person-circle"></i>
                {{ $namaAdmin }}
            </div>
        </div>

        <div class="content">
            <div class="page-header">
                <h4>Data User Staf</h4>
                <p>Halaman ini digunakan untuk mengelola akun staf yang dapat mengajukan permintaan barang.</p>
            </div>

            @if(session('success'))
                <div class="alert-soft-success">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert-soft-danger">
                    <i class="bi bi-exclamation-circle-fill me-1"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="card-soft toolbar-card mb-4">
                <div class="row g-3 align-items-center">
                    <div class="col-md-8">
                        <form method="GET" action="{{ route('admin.user.index') }}" class="search-form">
                            <div class="search-box">
                                <i class="bi bi-search"></i>

                                <input
                                    type="text"
                                    name="search"
                                    class="search-input"
                                    value="{{ $search ?? '' }}"
                                    placeholder="Cari nama / username / email / no HP"
                                >
                            </div>

                            <button type="submit" class="btn-search">
                                <i class="bi bi-search"></i>
                                Cari
                            </button>

                            @if(!empty($search))
                                <a href="{{ route('admin.user.index') }}" class="btn-reset">
                                    Reset
                                </a>
                            @endif
                        </form>
                    </div>

                    <div class="col-md-4 text-md-end">
                        <a href="{{ route('admin.user.create') }}" class="btn-primary-soft">
                            <i class="bi bi-plus-circle me-1"></i>
                            Tambah Staf
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-soft table-card">
                @if(!empty($search))
                    <div class="result-info">
                        Hasil pencarian untuk:
                        <strong>"{{ $search }}"</strong>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-custom table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>No HP</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th width="170" class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>
                                        {{ method_exists($users, 'firstItem') ? $users->firstItem() + $loop->index : $loop->iteration }}
                                    </td>

                                    <td>
                                        <div class="user-name">
                                            {{ $user->name }}
                                        </div>
                                        <div class="user-sub">
                                            ID: {{ $user->id }}
                                        </div>
                                    </td>

                                    <td>{{ $user->username ?: '-' }}</td>

                                    <td>{{ $user->email ?: '-' }}</td>

                                    <td>{{ $user->no_hp ?: '-' }}</td>

                                    <td>
                                        <span class="badge-role">
                                            <i class="bi bi-person-badge"></i>
                                            {{ optional($user->role)->name ?? '-' }}
                                        </span>
                                    </td>

                                    <td>
                                        @if(strtolower($user->status ?? '') === 'aktif')
                                            <span class="badge-active">
                                                <i class="bi bi-check-circle"></i>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="badge-inactive">
                                                <i class="bi bi-x-circle"></i>
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('admin.user.edit', $user->id) }}" class="btn-action btn-edit">
                                            <i class="bi bi-pencil-square"></i>
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('admin.user.destroy', $user->id) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus akun staf ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn-action btn-delete">
                                                <i class="bi bi-trash"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <i class="bi bi-people"></i>

                                            @if(!empty($search))
                                                <h5>Data tidak ditemukan</h5>
                                                <p class="mb-0">
                                                    Tidak ada akun staf yang cocok dengan pencarian "{{ $search }}".
                                                </p>
                                            @else
                                                <h5>Belum ada akun staf</h5>
                                                <p class="mb-0">
                                                    Klik tombol Tambah Staf untuk membuat akun staf baru.
                                                </p>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($users, 'links'))
                    <div class="pagination-wrapper">
                        {{ $users->withQueryString()->links() }}
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
</script>

</body>
</html>