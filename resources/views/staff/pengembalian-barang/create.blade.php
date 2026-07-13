<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ajukan Pengembalian Barang - Staf</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Bootstrap --}}
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

            --danger: #dc3545;
            --danger-soft: #fff1f1;
            --success: #198754;
            --success-soft: #eefbf3;
            --warning: #b7791f;
            --warning-soft: #fff8e8;

            --shadow: 0 18px 45px rgba(15, 95, 134, 0.10);
            --soft-shadow: 0 10px 28px rgba(15, 95, 134, 0.07);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background:
                radial-gradient(circle at top right, rgba(134, 182, 246, 0.20), transparent 30%),
                linear-gradient(180deg, #f8fbff 0%, var(--bg) 100%);
            color: var(--text);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .staff-wrapper {
            min-height: 100vh;
            padding: 32px;
        }

        .topbar {
            background: rgba(255,255,255,0.96);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow);
            margin-bottom: 26px;
        }

        .topbar h3 {
            margin: 0;
            font-weight: 900;
            color: var(--primary-dark);
            letter-spacing: .3px;
        }

        .topbar p {
            margin: 4px 0 0;
            color: var(--muted);
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
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            min-width: 210px;
        }

        .profile-btn:hover {
            background: #dff1fb;
        }

        .profile-avatar,
        .profile-avatar-text {
            width: 44px;
            height: 44px;
            border-radius: 999px;
            flex-shrink: 0;
        }

        .profile-avatar {
            object-fit: cover;
            border: 2px solid var(--primary);
            background: #ffffff;
        }

        .profile-avatar-text {
            background: var(--primary);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            box-shadow: 0 8px 18px rgba(134, 182, 246, 0.45);
        }

        .profile-name {
            color: var(--text);
            line-height: 1.1;
            text-align: left;
        }

        .profile-role {
            font-size: .82rem;
            color: var(--muted);
            text-align: left;
        }

        .profile-menu {
            position: absolute;
            right: 0;
            top: 62px;
            width: 220px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: 0 16px 32px rgba(0,0,0,.12);
            padding: 8px;
            display: none;
            z-index: 1000;
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

        .page-card {
            background: rgba(255, 255, 255, 0.98);
            border: 1px solid var(--border);
            border-radius: 28px;
            box-shadow: var(--soft-shadow);
            padding: 30px;
        }

        .page-header {
            background:
                radial-gradient(circle at top right, rgba(255,255,255,0.28), transparent 30%),
                linear-gradient(135deg, var(--primary-mid), var(--primary-dark));
            color: #fff;
            border-radius: 24px;
            padding: 24px;
            margin-bottom: 26px;
            position: relative;
            overflow: hidden;
        }

        .page-header::after {
            content: "";
            position: absolute;
            right: -55px;
            bottom: -70px;
            width: 190px;
            height: 190px;
            background: rgba(255,255,255,0.15);
            border-radius: 50%;
        }

        .page-header h2 {
            position: relative;
            z-index: 2;
            margin: 0;
            font-weight: 900;
            letter-spacing: -.3px;
        }

        .page-header p {
            position: relative;
            z-index: 2;
            margin: 7px 0 0;
            color: #f4f9ff;
            max-width: 760px;
        }

        .empty-barang {
            background: var(--danger-soft);
            color: var(--danger);
            border: 1px solid #ffd1d1;
            border-radius: 16px;
            padding: 14px 16px;
            font-weight: 700;
            margin-bottom: 18px;
        }

        .request-form {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 26px;
            padding: 26px;
            box-shadow: 0 12px 30px rgba(15, 95, 134, 0.06);
        }

        .request-layout {
            display: grid;
            grid-template-columns: 1.2fr .8fr;
            gap: 22px;
            align-items: start;
        }

        .panel {
            border: 1px solid var(--border);
            border-radius: 22px;
            background: #fff;
            overflow: hidden;
        }

        .panel-header {
            padding: 18px 20px;
            border-bottom: 1px solid #edf2f6;
            background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
        }

        .panel-header h5 {
            margin: 0;
            font-size: 1.03rem;
            font-weight: 900;
            color: var(--primary-dark);
        }

        .panel-header p {
            margin: 5px 0 0;
            color: var(--muted);
            font-size: .88rem;
        }

        .panel-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .form-label {
            display: block;
            margin-bottom: 9px;
            color: var(--text);
            font-weight: 850;
            font-size: .94rem;
        }

        .form-control-custom,
        .form-textarea-custom {
            width: 100%;
            border: 1px solid #d9e5ee;
            background: #fff;
            color: var(--text);
            padding: 15px 17px;
            border-radius: 18px;
            outline: none;
            font-size: .98rem;
            transition: .22s ease;
            box-shadow: 0 8px 18px rgba(15, 95, 134, 0.03);
        }

        .form-control-custom {
            min-height: 58px;
        }

        .form-textarea-custom {
            min-height: 140px;
            resize: vertical;
        }

        .form-control-custom:hover,
        .form-textarea-custom:hover {
            border-color: #bdd7ea;
        }

        .form-control-custom:focus,
        .form-textarea-custom:focus {
            border-color: var(--primary);
            box-shadow:
                0 0 0 4px rgba(134, 182, 246, 0.20),
                0 12px 24px rgba(15, 95, 134, 0.06);
        }

        .form-control-custom[readonly] {
            background: #f8fbfd;
            color: var(--muted);
            cursor: not-allowed;
        }

        .help-text {
            color: var(--muted);
            font-size: .84rem;
            font-weight: 700;
            margin-top: 8px;
        }

        .form-error {
            margin-top: 7px;
            color: var(--danger);
            font-size: .84rem;
            font-weight: 700;
        }

        .barang-search-wrapper {
            position: relative;
        }

        .barang-search-input {
            padding-left: 48px;
        }

        .barang-search-icon {
            position: absolute;
            top: 50%;
            left: 18px;
            transform: translateY(-50%);
            color: var(--primary-dark);
            font-size: 1.08rem;
            z-index: 2;
        }

        .barang-list {
            margin-top: 15px;
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            max-height: 430px;
            overflow-y: auto;
            background: #fff;
            box-shadow: 0 10px 24px rgba(15, 95, 134, 0.04);
        }

        .barang-item {
            width: 100%;
            border: none;
            background: #fff;
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            border-bottom: 1px solid #edf2f6;
            text-align: left;
            cursor: pointer;
            transition: .18s ease;
        }

        .barang-item:last-child {
            border-bottom: none;
        }

        .barang-item:hover {
            background: #f6fbff;
        }

        .barang-item.active {
            background: var(--primary-soft);
            border-left: 6px solid var(--primary-mid);
        }

        .barang-title {
            font-weight: 900;
            color: var(--text);
            margin-bottom: 4px;
        }

        .barang-meta {
            color: var(--muted);
            font-size: .86rem;
            font-weight: 700;
            line-height: 1.55;
        }

        .barang-stock {
            background: var(--primary-soft);
            color: var(--primary-dark);
            border: 1px solid #d8edf8;
            border-radius: 999px;
            padding: 8px 12px;
            font-size: .82rem;
            font-weight: 900;
            white-space: nowrap;
        }

        .selected-barang-box {
            margin-top: 14px;
            background: var(--success-soft);
            color: var(--success);
            border: 1px solid #cdeedb;
            border-radius: 18px;
            padding: 13px 15px;
            font-weight: 800;
            display: none;
        }

        .barang-empty-search {
            display: none;
            padding: 26px 16px;
            text-align: center;
            color: var(--muted);
            font-weight: 700;
        }

        .barang-empty-search i {
            color: var(--primary-dark);
            font-size: 2rem;
            display: block;
            margin-bottom: 8px;
        }

        .summary-box {
            background: var(--primary-extra-soft);
            border: 1px solid #d8edf8;
            border-radius: 18px;
            padding: 16px;
            margin-bottom: 18px;
        }

        .summary-box h6 {
            margin: 0 0 6px;
            font-weight: 900;
            color: var(--primary-dark);
        }

        .summary-box p {
            margin: 0;
            font-size: .88rem;
            color: var(--muted);
            font-weight: 700;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 24px;
            padding-top: 22px;
            border-top: 1px solid #edf2f6;
        }

        .btn-main {
            border: none;
            background: linear-gradient(135deg, var(--primary-mid), var(--primary-dark));
            color: #ffffff;
            padding: 13px 18px;
            border-radius: 16px;
            font-weight: 900;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 12px 22px rgba(13, 111, 157, 0.22);
            transition: .2s ease;
        }

        .btn-main:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 16px 28px rgba(13, 111, 157, 0.30);
        }

        .btn-main:disabled {
            opacity: .65;
            cursor: not-allowed;
            transform: none;
        }

        .btn-secondary-custom {
            border: 1px solid #dbe5ec;
            background: #fff;
            color: var(--text);
            padding: 13px 18px;
            border-radius: 16px;
            font-weight: 900;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: .2s ease;
        }

        .btn-secondary-custom:hover {
            background: var(--primary-soft);
            color: var(--primary-dark);
        }

        @media (max-width: 992px) {
            .request-layout {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .staff-wrapper {
                padding: 18px;
            }

            .topbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 14px;
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

            .page-card,
            .request-form {
                padding: 20px;
            }

            .page-header {
                padding: 22px;
            }

            .barang-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .barang-stock {
                white-space: normal;
            }

            .form-actions {
                flex-direction: column-reverse;
                align-items: stretch;
            }

            .btn-main,
            .btn-secondary-custom {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
@php
    $userLogin = auth()->user();
    $namaStaf = $userLogin->name ?? 'Staf';
    $fotoProfil = $userLogin && $userLogin->foto ? asset('storage/' . $userLogin->foto) : null;
    $oldBarangId = old('barang_id');
@endphp

<div class="staff-wrapper">
    <div class="topbar">
        <div>
            <h3>Ajukan Pengembalian</h3>
            <p>Cari barang terlebih dahulu, lalu isi detail pengembalian.</p>
        </div>

        <div class="profile-dropdown">
            <button type="button" class="profile-btn" id="profileToggle">
                @if($fotoProfil)
                    <img src="{{ $fotoProfil }}" alt="Foto Profil" class="profile-avatar">
                @else
                    <div class="profile-avatar-text">
                        {{ strtoupper(substr($namaStaf, 0, 1)) }}
                    </div>
                @endif

                <div class="flex-grow-1">
                    <div class="profile-name">{{ $namaStaf }}</div>
                    <div class="profile-role">Staf</div>
                </div>

                <i class="bi bi-chevron-down"></i>
            </button>

            <div class="profile-menu" id="profileMenu">
                <a href="{{ route('staff.profile.edit') }}">
                    <i class="bi bi-person-gear"></i>
                    Edit Profil
                </a>

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

    <div class="page-card">
        <div class="page-header">
            <h2>Form Pengembalian Barang</h2>
            <p>
                Pilih barang dari daftar pencarian, lalu lengkapi jumlah dan keterangan.
                Pengembalian akan berstatus <strong>Menunggu</strong> sampai diproses admin.
            </p>
        </div>

        @if($barang->count() < 1)
            <div class="empty-barang">
                <i class="bi bi-exclamation-circle-fill me-1"></i>
                Belum ada data barang. Silakan hubungi admin untuk menambahkan data barang terlebih dahulu.
            </div>
        @endif

        <form method="POST" action="{{ route('staff.pengembalian-barang.store') }}" autocomplete="off" id="pengembalianForm" class="request-form" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="barang_id" id="barangIdInput" value="{{ old('barang_id') }}">

            <div class="request-layout">
                <div class="panel">
                    <div class="panel-header">
                        <h5>
                            <i class="bi bi-search me-1"></i>
                            Pilih Barang
                        </h5>
                        <p>Cari berdasarkan nama barang, kode barang, kategori, atau satuan.</p>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label class="form-label">Pencarian Barang</label>

                            <div class="barang-search-wrapper">
                                <i class="bi bi-search barang-search-icon"></i>
                                <input
                                    type="text"
                                    id="barangSearchInput"
                                    class="form-control-custom barang-search-input"
                                    placeholder="Contoh: pipa, meteran, BRG001..."
                                    {{ $barang->count() < 1 ? 'disabled' : '' }}
                                >
                            </div>

                            <div class="help-text">
                                Klik salah satu barang dari daftar di bawah untuk dipilih.
                            </div>
                        </div>

                        <div class="barang-list" id="barangList">
                            @foreach($barang as $item)
                                @php
                                    $isSelected = (string) $oldBarangId === (string) $item->id;
                                    $searchText = strtolower(
                                        ($item->nama_barang ?? '') . ' ' .
                                        ($item->kode_barang ?? '') . ' ' .
                                        ($item->kategori ?? '') . ' ' .
                                        ($item->satuan ?? '') . ' ' .
                                        ($item->stok ?? '')
                                    );
                                @endphp

                                <button
                                    type="button"
                                    class="barang-item {{ $isSelected ? 'active' : '' }}"
                                    data-id="{{ $item->id }}"
                                    data-name="{{ $item->nama_barang }}"
                                    data-code="{{ $item->kode_barang ?? '' }}"
                                    data-stock="{{ $item->stok ?? 0 }}"
                                    data-satuan="{{ $item->satuan ?? '' }}"
                                    data-search="{{ $searchText }}"
                                >
                                    <div>
                                        <div class="barang-title">
                                            {{ $item->nama_barang }}
                                        </div>

                                        <div class="barang-meta">
                                            Kode: {{ $item->kode_barang ?: '-' }}

                                            @if(!empty($item->kategori))
                                                <span class="mx-1">•</span>
                                                Kategori: {{ $item->kategori }}
                                            @endif

                                            @if(!empty($item->satuan))
                                                <span class="mx-1">•</span>
                                                Satuan: {{ $item->satuan }}
                                            @endif
                                        </div>
                                    </div>

                                    <div class="barang-stock">
                                        Stok: {{ $item->stok ?? 0 }} {{ $item->satuan ?? '' }}
                                    </div>
                                </button>
                            @endforeach

                            <div class="barang-empty-search" id="barangEmptySearch">
                                <i class="bi bi-search"></i>
                                Barang tidak ditemukan.
                            </div>
                        </div>

                        <div class="selected-barang-box" id="selectedBarangBox">
                            <i class="bi bi-check-circle-fill me-1"></i>
                            <span id="selectedBarangText">Barang sudah dipilih.</span>
                        </div>

                        @error('barang_id')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-header">
                        <h5>
                            <i class="bi bi-clipboard-check me-1"></i>
                            Detail Pengembalian
                        </h5>
                        <p>Lengkapi tanggal, jumlah, dan keterangan pengembalian.</p>
                    </div>

                    <div class="panel-body">
                        <div class="summary-box">
                            <h6>Status Pengembalian</h6>
                            <p>Pengembalian baru otomatis masuk sebagai Menunggu.</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tanggal Pengembalian</label>
                            <input
                                type="date"
                                name="tanggal_pengembalian"
                                value="{{ old('tanggal_pengembalian', date('Y-m-d')) }}"
                                class="form-control-custom"
                                required
                            >

                            @error('tanggal_pengembalian')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jumlah Barang</label>
                            <input
                                type="number"
                                name="jumlah"
                                id="jumlahInput"
                                value="{{ old('jumlah') }}"
                                class="form-control-custom"
                                min="1"
                                required
                                placeholder="Masukkan jumlah barang"
                            >

                            <div class="help-text" id="stokHelpText">
                                Pilih barang terlebih dahulu untuk melihat stok tersedia.
                            </div>

                            @error('jumlah')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <input
                                type="text"
                                value="Menunggu"
                                class="form-control-custom"
                                readonly
                            >
                        </div>

                        <div class="form-group">
                            <label class="form-label">Keterangan</label>
                            <textarea
                                name="keterangan"
                                class="form-textarea-custom"
                                placeholder="Contoh: Barang dikembalikan dalam kondisi baik..."
                            >{{ old('keterangan') }}</textarea>

                            @error('keterangan')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Foto Bukti Pengembalian <span style="color: var(--danger);">*</span></label>
                            <input
                                type="file"
                                name="foto_bukti"
                                id="fotoBuktiInput"
                                class="form-control-custom"
                                accept="image/jpeg,image/jpg,image/png"
                                required
                            >
                            <div style="color: var(--muted); font-size: .82rem; margin-top: 6px;">
                                Unggah foto barang yang dikembalikan sebagai bukti (JPG/PNG, maks 4 MB).
                            </div>

                            <img id="fotoBuktiPreview" src="" alt="Preview Bukti"
                                 style="display:none; margin-top:10px; max-width:220px; border-radius:14px; border:1px solid var(--border);">

                            @error('foto_bukti')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('staff.pengembalian-barang.index') }}" class="btn-secondary-custom">
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>

                <a href="{{ route('staff.dashboard') }}" class="btn-secondary-custom">
                    <i class="bi bi-grid-1x2"></i>
                    Dashboard
                </a>

                <button type="submit" class="btn-main" id="submitButton" {{ $barang->count() < 1 ? 'disabled' : '' }}>
                    <i class="bi bi-send-check"></i>
                    Kirim Pengembalian
                </button>
            </div>
        </form>
    </div>
</div>

<script>
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

    const barangSearchInput = document.getElementById('barangSearchInput');
    const barangItems = document.querySelectorAll('.barang-item');
    const barangIdInput = document.getElementById('barangIdInput');
    const selectedBarangBox = document.getElementById('selectedBarangBox');
    const selectedBarangText = document.getElementById('selectedBarangText');
    const barangEmptySearch = document.getElementById('barangEmptySearch');
    const jumlahInput = document.getElementById('jumlahInput');
    const stokHelpText = document.getElementById('stokHelpText');
    const pengembalianForm = document.getElementById('pengembalianForm');

    function setSelectedBarang(item) {
        barangItems.forEach(function (button) {
            button.classList.remove('active');
        });

        item.classList.add('active');

        const id = item.getAttribute('data-id');
        const name = item.getAttribute('data-name') || 'Barang';
        const code = item.getAttribute('data-code') || '-';
        const stock = item.getAttribute('data-stock') || '0';
        const satuan = item.getAttribute('data-satuan') || '';

        barangIdInput.value = id;

        if (selectedBarangBox && selectedBarangText) {
            selectedBarangText.textContent = name + ' (' + code + ') dipilih. Stok tersedia: ' + stock + ' ' + satuan;
            selectedBarangBox.style.display = 'block';
        }

        if (stokHelpText) {
            stokHelpText.textContent = 'Stok tersedia: ' + stock + ' ' + satuan;
        }

        if (jumlahInput) {
            jumlahInput.setAttribute('max', stock);
        }
    }

    function filterBarangList() {
        const keyword = (barangSearchInput?.value || '').toLowerCase().trim();
        let visibleCount = 0;

        barangItems.forEach(function (item) {
            const searchText = item.getAttribute('data-search') || '';

            if (keyword === '' || searchText.includes(keyword)) {
                item.style.display = 'flex';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        if (barangEmptySearch) {
            barangEmptySearch.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    barangItems.forEach(function (item) {
        item.addEventListener('click', function () {
            setSelectedBarang(item);
        });
    });

    if (barangSearchInput) {
        barangSearchInput.addEventListener('keyup', filterBarangList);
    }

    const oldSelectedItem = document.querySelector('.barang-item.active');

    if (oldSelectedItem) {
        setSelectedBarang(oldSelectedItem);
    }

    if (pengembalianForm) {
        pengembalianForm.addEventListener('submit', function (event) {
            if (!barangIdInput || barangIdInput.value === '') {
                event.preventDefault();
                alert('Silakan pilih barang terlebih dahulu.');
                return;
            }

            const selectedItem = document.querySelector('.barang-item.active');

            if (selectedItem && jumlahInput) {
                const stock = parseInt(selectedItem.getAttribute('data-stock') || '0');
                const jumlah = parseInt(jumlahInput.value || '0');

                if (stock > 0 && jumlah > stock) {
                    event.preventDefault();
                    alert('Jumlah pengembalian melebihi stok yang tersedia.');
                }
            }
        });
    }

    const fotoBuktiInput = document.getElementById('fotoBuktiInput');
    const fotoBuktiPreview = document.getElementById('fotoBuktiPreview');

    if (fotoBuktiInput && fotoBuktiPreview) {
        fotoBuktiInput.addEventListener('change', function () {
            const file = this.files && this.files[0];

            if (file) {
                fotoBuktiPreview.src = URL.createObjectURL(file);
                fotoBuktiPreview.style.display = 'block';
            } else {
                fotoBuktiPreview.style.display = 'none';
            }
        });
    }
</script>

</body>
</html>