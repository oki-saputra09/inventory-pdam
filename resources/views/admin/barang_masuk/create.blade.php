<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang Masuk - INVENDAM</title>
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

        * { box-sizing: border-box; }
        html, body { height: 100%; margin: 0; }

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
            filter: drop-shadow(0 0 2px rgba(255,255,255,0.9))
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
            background: rgba(255,255,255,0.14);
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

        .btn-light-soft {
            background: #f5f9ff;
            border: 1px solid #dbe6ef;
            color: var(--primary-dark);
            border-radius: 14px;
            padding: 11px 18px;
            font-weight: 700;
            text-decoration: none;
        }

        .invalid-feedback {
            display: block;
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
                    <span>Admin Panel PDAM</span>
                </div>
            </div>

            <div class="menu-title">Menu Utama</div>
            <ul class="menu">
                <li><a href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a></li>
                <li><a href="{{ route('admin.barang.index') }}"><i class="bi bi-box-seam"></i> Data Barang</a></li>
                <li><a href="{{ route('admin.kategori.index') }}"><i class="bi bi-tags"></i> Kategori</a></li>
                <li><a href="{{ route('admin.supplier.index') }}"><i class="bi bi-truck"></i> Supplier</a></li>
            </ul>

            <div class="menu-title">Transaksi</div>
            <ul class="menu">
                <li><a href="{{ route('admin.barang-masuk.index') }}" class="active"><i class="bi bi-box-arrow-in-down"></i> Barang Masuk</a></li>
                <li><a href="#"><i class="bi bi-box-arrow-up"></i> Barang Keluar</a></li>
                <li><a href="#"><i class="bi bi-clipboard-check"></i> Permintaan Barang</a></li>
            </ul>
        </aside>

        <main class="main">
            <div class="topbar">
                <div class="topbar-left">
                    <button class="menu-toggle" id="menuToggle" type="button">
                        <i class="bi bi-list"></i>
                    </button>
                    <div>
                        <h3>TAMBAH BARANG MASUK</h3>
                        <p>Input transaksi barang masuk</p>
                    </div>
                </div>

                <div class="admin-badge">
                    <i class="bi bi-person-circle"></i> Admin
                </div>
            </div>

            <div class="content">
                <div class="page-header">
                    <h4>Tambah Barang Masuk</h4>
                    <p>Masukkan data barang masuk dengan lengkap dan benar.</p>
                </div>

                <div class="card-soft form-card">
                    <form action="{{ route('admin.barang-masuk.store') }}" method="POST">
                        @csrf

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="barang_id" class="form-label">Barang</label>
                                <select name="barang_id" id="barang_id" class="form-select @error('barang_id') is-invalid @enderror">
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach ($barang as $item)
                                        <option value="{{ $item->id }}" {{ old('barang_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->kode_barang }} - {{ $item->nama_barang }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('barang_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="supplier_id" class="form-label">Supplier</label>
                                <select name="supplier_id" id="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror">
                                    <option value="">-- Pilih Supplier --</option>
                                    @foreach ($supplier as $item)
                                        <option value="{{ $item->id }}" {{ old('supplier_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_supplier }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                                <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control @error('tanggal_masuk') is-invalid @enderror" value="{{ old('tanggal_masuk') }}">
                                @error('tanggal_masuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" name="jumlah" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah') }}" min="1">
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" rows="4" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary-soft">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>

                            <a href="{{ route('admin.barang-masuk.index') }}" class="btn-light-soft">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
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

        menuToggle.addEventListener('click', function () {
            sidebarMenu.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
        });

        sidebarOverlay.addEventListener('click', function () {
            sidebarMenu.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        });
    </script>
</body>
</html>