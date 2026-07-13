<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pengembalian Barang - Staf</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #86B6F6;
            --primary-dark: #0d6f9d;
            --primary-soft: #e9f7fd;
            --bg: #f4f8fb;
            --white: #ffffff;
            --text: #24323d;
            --muted: #6c7a86;
            --border: #e7edf2;
            --danger: #dc3545;
            --success: #198754;
            --warning: #b7791f;
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
                radial-gradient(circle at top right, rgba(134, 182, 246, 0.30), transparent 34%),
                linear-gradient(180deg, #f8fbff 0%, #f4f8fb 100%);
            color: var(--text);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .staff-wrapper {
            min-height: 100vh;
            padding: 32px;
        }

        .topbar {
            background: var(--white);
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
            border: none;
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
            background: #fff1f1 !important;
            color: var(--danger) !important;
        }

        .profile-divider {
            height: 1px;
            background: #edf1f4;
            margin: 6px 0;
        }

        .page-card {
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid var(--border);
            border-radius: 28px;
            box-shadow: var(--soft-shadow);
            padding: 30px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 26px;
        }

        .page-header h2 {
            margin: 0;
            font-weight: 900;
            color: var(--text);
            letter-spacing: -.3px;
        }

        .page-header p {
            margin: 6px 0 0;
            color: var(--muted);
        }

        .form-card {
            max-width: 920px;
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 26px;
            padding: 28px;
            box-shadow: 0 12px 30px rgba(15, 95, 134, 0.06);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 22px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;
            margin-bottom: 9px;
            color: var(--text);
            font-weight: 850;
            font-size: .94rem;
        }

        .form-control-custom,
        .form-select-custom,
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

        .form-control-custom,
        .form-select-custom {
            min-height: 58px;
        }

        .form-textarea-custom {
            min-height: 130px;
            resize: vertical;
        }

        .form-control-custom:hover,
        .form-select-custom:hover,
        .form-textarea-custom:hover {
            border-color: #bdd7ea;
        }

        .form-control-custom:focus,
        .form-select-custom:focus,
        .form-textarea-custom:focus {
            border-color: var(--primary);
            box-shadow:
                0 0 0 4px rgba(134, 182, 246, 0.20),
                0 12px 24px rgba(15, 95, 134, 0.06);
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
            font-weight: 700;
        }

        .info-box {
            margin-top: 24px;
            background: #fff8e8;
            border: 1px dashed #e8c878;
            border-radius: 18px;
            padding: 16px;
            color: #8a6212;
            font-size: .92rem;
            display: flex;
            gap: 12px;
        }

        .info-box i {
            color: #b7791f;
            font-size: 1.2rem;
            margin-top: 1px;
        }

        .form-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 28px;
            padding-top: 22px;
            border-top: 1px solid #edf2f6;
        }

        .btn-main {
            border: none;
            background: linear-gradient(135deg, var(--primary), #5ea4f7);
            color: #ffffff;
            padding: 13px 18px;
            border-radius: 16px;
            font-weight: 800;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 12px 22px rgba(134, 182, 246, 0.35);
            transition: .2s ease;
        }

        .btn-main:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 16px 28px rgba(134, 182, 246, 0.48);
        }

        .btn-secondary-custom {
            border: 1px solid #dbe5ec;
            background: #fff;
            color: var(--text);
            padding: 13px 18px;
            border-radius: 16px;
            font-weight: 800;
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

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: .8rem;
            font-weight: 900;
            background: #fff8e8;
            color: #b7791f;
        }

        @media (max-width: 768px) {
            .staff-wrapper {
                padding: 18px;
            }

            .topbar,
            .page-header {
                flex-direction: column;
                align-items: flex-start;
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

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-main,
            .btn-secondary-custom {
                width: 100%;
                justify-content: center;
            }

            .page-card,
            .form-card {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
@php
    $userLogin = auth()->user();
    $namaStaf = $userLogin->name ?? 'Staf';
    $fotoProfil = $userLogin && $userLogin->foto ? asset('storage/' . $userLogin->foto) : null;
@endphp

<div class="staff-wrapper">
    <div class="topbar">
        <div>
            <h3>Edit Pengembalian</h3>
            <p>Ubah pengembalian barang yang masih berstatus menunggu.</p>
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
            <div>
                <h2>Edit Pengembalian Barang</h2>
                <p>Pengembalian hanya bisa diubah selama status masih <strong>Menunggu</strong>.</p>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('staff.pengembalian-barang.index') }}" class="btn-secondary-custom">
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>

                <a href="{{ route('staff.dashboard') }}" class="btn-secondary-custom">
                    <i class="bi bi-house"></i>
                    Dashboard
                </a>
            </div>
        </div>

        <div class="form-card">
            <form method="POST" action="{{ route('staff.pengembalian-barang.update', $pengembalianBarang->id) }}" autocomplete="off" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Barang</label>
                        <select name="barang_id" class="form-select-custom" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($barang as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('barang_id', $pengembalianBarang->barang_id) == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_barang }}
                                    @if(!empty($item->kode_barang))
                                        - {{ $item->kode_barang }}
                                    @endif
                                    @if(!empty($item->stok))
                                        | Stok: {{ $item->stok }} {{ $item->satuan ?? '' }}
                                    @endif
                                </option>
                            @endforeach
                        </select>

                        @error('barang_id')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggal Pengembalian</label>
                        <input
                            type="date"
                            name="tanggal_pengembalian"
                            value="{{ old('tanggal_pengembalian', \Carbon\Carbon::parse($pengembalianBarang->tanggal_pengembalian)->format('Y-m-d')) }}"
                            class="form-control-custom"
                            required
                        >

                        @error('tanggal_pengembalian')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jumlah</label>
                        <input
                            type="number"
                            name="jumlah"
                            value="{{ old('jumlah', $pengembalianBarang->jumlah) }}"
                            class="form-control-custom"
                            min="1"
                            required
                        >

                        @error('jumlah')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="form-control-custom d-flex align-items-center">
                            <span class="badge-status">
                                <i class="bi bi-hourglass-split"></i>
                                {{ $pengembalianBarang->status ?? 'Menunggu' }}
                            </span>
                        </div>
                    </div>

                    <div class="form-group full">
                        <label class="form-label">Keterangan</label>
                        <textarea
                            name="keterangan"
                            class="form-textarea-custom"
                        >{{ old('keterangan', $pengembalianBarang->keterangan) }}</textarea>

                        @error('keterangan')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Foto Bukti Pengembalian</label>

                        @if ($pengembalianBarang->foto_bukti)
                            <div style="margin-bottom: 10px;">
                                <a href="{{ asset($pengembalianBarang->foto_bukti) }}" target="_blank">
                                    <img src="{{ asset($pengembalianBarang->foto_bukti) }}" alt="Bukti Pengembalian"
                                         style="max-width:220px; border-radius:14px; border:1px solid var(--border);">
                                </a>
                            </div>
                        @endif

                        <input
                            type="file"
                            name="foto_bukti"
                            class="form-control-custom"
                            accept="image/jpeg,image/jpg,image/png"
                        >
                        <div style="color: var(--muted); font-size: .82rem; margin-top: 6px;">
                            Biarkan kosong jika tidak ingin mengganti foto bukti (JPG/PNG, maks 4 MB).
                        </div>

                        @error('foto_bukti')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="info-box">
                    <i class="bi bi-info-circle-fill"></i>
                    <div>
                        Setelah admin memproses pengembalian menjadi <strong>Disetujui</strong> atau <strong>Ditolak</strong>,
                        pengembalian tidak bisa diedit atau dihapus lagi.
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-main">
                        <i class="bi bi-check-circle"></i>
                        Update Pengembalian
                    </button>

                    <a href="{{ route('staff.pengembalian-barang.index') }}" class="btn-secondary-custom">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </form>
        </div>
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
</script>

</body>
</html>