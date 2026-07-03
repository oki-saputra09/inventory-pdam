<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang - INVENDAM</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #159bd8;
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
            background: rgba(255,255,255,0.14);
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

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
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
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
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
            border: 1px solid #e7edf2;
            border-radius: 20px;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.04);
        }

        .form-card {
            padding: 24px;
        }

        .section-card {
            padding: 24px;
            margin-bottom: 24px;
        }

        .section-title {
            margin: 0;
            font-size: 1.08rem;
            font-weight: 800;
            color: var(--primary-dark);
        }

        .section-subtitle {
            margin: 5px 0 0;
            color: var(--muted);
            font-size: .92rem;
        }

        .import-icon {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            background: var(--primary-soft);
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.55rem;
            flex-shrink: 0;
        }

        .format-box {
            margin-top: 18px;
            border: 1px solid #e7edf2;
            border-radius: 16px;
            overflow: hidden;
        }

        .format-box table {
            margin: 0;
            white-space: nowrap;
        }

        .format-box thead th {
            background: #f5f9ff;
            color: var(--primary-dark);
            font-size: .86rem;
        }

        .format-note {
            margin-top: 12px;
            font-size: .85rem;
            color: var(--muted);
        }

        .alert {
            border-radius: 16px;
            font-weight: 600;
            border: none;
        }

        .form-label {
            font-weight: 700;
            color: #3e5567;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border-radius: 14px;
            border: 1px solid #dbe6ef;
            min-height: 46px;
            padding: 10px 14px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.15rem rgba(134, 182, 246, 0.25);
        }

        .btn-primary-soft {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            color: #fff;
            border-radius: 14px;
            padding: 11px 18px;
            font-weight: 700;
        }

        .btn-primary-soft:hover {
            color: #fff;
            background: linear-gradient(135deg, #148bc2, #0b5f87);
        }

        .btn-light-soft {
            background: #f5f9ff;
            border: 1px solid #dbe6ef;
            color: var(--primary-dark);
            border-radius: 14px;
            padding: 11px 18px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-light-soft:hover {
            background: var(--primary-soft);
            color: var(--primary-dark);
        }

        .invalid-feedback {
            display: block;
            font-weight: 600;
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

            .content {
                padding: 18px;
            }

            .section-card,
            .form-card {
                padding: 18px;
            }
        }
    </style>
</head>

<body>
@php
    $logoKantor = asset('images/logo.png');
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
                <a href="{{ route('admin.barang.index') }}" class="active">
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
                <a href="{{ route('admin.laporan-stok.index') }}">
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
                    <h3>TAMBAH BARANG</h3>
                    <p>Form input data barang inventory PDAM</p>
                </div>
            </div>

            <div class="topbar-right">
                <div class="admin-badge">
                    <i class="bi bi-person-circle"></i>
                    <span>{{ auth()->user()->name ?? 'Admin' }}</span>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="page-header">
                <h4>Tambah Data Barang</h4>
                <p>Masukkan data barang baru secara manual atau upload file Excel agar data masuk otomatis.</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success mb-4">
                    <i class="bi bi-check-circle me-1"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger mb-4">
                    <i class="bi bi-x-circle me-1"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if(session('import_errors'))
                <div class="alert alert-warning mb-4">
                    <div class="fw-bold mb-2">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        Beberapa baris gagal diimport:
                    </div>

                    <ul class="mb-0 ps-3">
                        @foreach(session('import_errors') as $importError)
                            <li>{{ $importError }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card-soft section-card">
                <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 mb-4">
                    <div class="d-flex gap-3">
                        <div class="import-icon">
                            <i class="bi bi-file-earmark-excel"></i>
                        </div>

                        <div>
                            <h5 class="section-title">Import Data Barang dari Excel</h5>
                            <p class="section-subtitle">
                                Upload file Excel agar banyak data barang bisa masuk otomatis ke sistem.
                            </p>
                        </div>
                    </div>

                    <div>
                        <a href="{{ route('admin.barang.template-excel') }}" class="btn-light-soft">
                            <i class="bi bi-download me-1"></i>
                            Download Template Excel
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.barang.import-excel') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3 align-items-end">
                        <div class="col-lg-8">
                            <label for="file_excel" class="form-label">Upload File Excel</label>
                            <input
                                type="file"
                                name="file_excel"
                                id="file_excel"
                                accept=".xlsx,.xls,.csv"
                                class="form-control @error('file_excel') is-invalid @enderror"
                                required
                            >

                            @error('file_excel')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="format-note">
                                Format file yang didukung: <strong>.xlsx, .xls, .csv</strong>. Maksimal 5MB.
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <button type="submit" class="btn btn-primary-soft w-100">
                                <i class="bi bi-upload me-1"></i>
                                Import Sekarang
                            </button>
                        </div>
                    </div>
                </form>

                <div class="format-box">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>kode_barang</th>
                                    <th>nama_barang</th>
                                    <th>kategori</th>
                                    <th>satuan</th>
                                    <th>stok</th>
                                    <th>minimum_stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>BRG001</td>
                                    <td>Pipa PVC 1 Inch</td>
                                    <td>Pipa</td>
                                    <td>Pcs</td>
                                    <td>100</td>
                                    <td>10</td>
                                </tr>
                                <tr>
                                    <td>BRG002</td>
                                    <td>Meteran Air</td>
                                    <td>Alat</td>
                                    <td>Unit</td>
                                    <td>50</td>
                                    <td>5</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <p class="format-note mb-0">
                    Catatan: nama kolom di Excel harus sama seperti tabel di atas.
                    Jika <strong>kode_barang</strong> sudah ada, sistem akan memperbarui data barang tersebut.
                    Jika <strong>kategori</strong> belum ada, sistem akan membuat kategori baru otomatis.
                </p>
            </div>

            <div class="card-soft form-card">
                <div class="mb-4">
                    <h5 class="section-title">Tambah Barang Manual</h5>
                    <p class="section-subtitle">
                        Gunakan form ini jika ingin menambahkan satu data barang secara manual.
                    </p>
                </div>

                <form action="{{ route('admin.barang.store') }}" method="POST" autocomplete="off">
                    @csrf

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="kode_barang" class="form-label">Kode Barang</label>
                            <input
                                type="text"
                                name="kode_barang"
                                id="kode_barang"
                                class="form-control @error('kode_barang') is-invalid @enderror"
                                value="{{ old('kode_barang') }}"
                                placeholder="Contoh: BRG-001"
                                required
                            >
                            @error('kode_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input
                                type="text"
                                name="nama_barang"
                                id="nama_barang"
                                class="form-control @error('nama_barang') is-invalid @enderror"
                                value="{{ old('nama_barang') }}"
                                placeholder="Masukkan nama barang"
                                required
                            >
                            @error('nama_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select
                                name="kategori"
                                id="kategori"
                                class="form-select @error('kategori') is-invalid @enderror"
                                required
                            >
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->nama_kategori }}" {{ old('kategori') == $item->nama_kategori ? 'selected' : '' }}>
                                        {{ $item->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="satuan" class="form-label">Satuan</label>
                            <select
                                name="satuan"
                                id="satuan"
                                class="form-select @error('satuan') is-invalid @enderror"
                                required
                            >
                                <option value="">-- Pilih Satuan --</option>
                                <option value="Pcs" {{ old('satuan') == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                                <option value="Meter" {{ old('satuan') == 'Meter' ? 'selected' : '' }}>Meter</option>
                                <option value="Unit" {{ old('satuan') == 'Unit' ? 'selected' : '' }}>Unit</option>
                                <option value="Batang" {{ old('satuan') == 'Batang' ? 'selected' : '' }}>Batang</option>
                            </select>
                            @error('satuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="stok" class="form-label">Stok</label>
                            <input
                                type="number"
                                name="stok"
                                id="stok"
                                class="form-control @error('stok') is-invalid @enderror"
                                value="{{ old('stok') }}"
                                placeholder="Masukkan jumlah stok"
                                min="0"
                                required
                            >
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="minimum_stok" class="form-label">Minimum Stok</label>
                            <input
                                type="number"
                                name="minimum_stok"
                                id="minimum_stok"
                                class="form-control @error('minimum_stok') is-invalid @enderror"
                                value="{{ old('minimum_stok') }}"
                                placeholder="Masukkan minimum stok"
                                min="0"
                                required
                            >
                            @error('minimum_stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <button type="submit" class="btn btn-primary-soft">
                            <i class="bi bi-save me-1"></i>
                            Simpan
                        </button>

                        <a href="{{ route('admin.barang.index') }}" class="btn-light-soft">
                            <i class="bi bi-arrow-left me-1"></i>
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