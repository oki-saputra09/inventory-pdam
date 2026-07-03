<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Permintaan Barang - Staf</title>
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
            padding: 28px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 24px;
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
            white-space: nowrap;
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
            white-space: nowrap;
        }

        .btn-secondary-custom:hover {
            background: var(--primary-soft);
            color: var(--primary-dark);
        }

        .alert-success-custom {
            background: #eefbf3;
            color: var(--success);
            border: 1px solid #caefd8;
            border-radius: 16px;
            padding: 14px 16px;
            font-weight: 700;
            margin-bottom: 18px;
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

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .table-request {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px;
            min-width: 900px;
        }

        .table-request thead th {
            background: #edf6ff;
            color: var(--primary-dark);
            font-size: .82rem;
            text-transform: uppercase;
            letter-spacing: .5px;
            padding: 15px 16px;
            font-weight: 900;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .table-request thead th:first-child {
            border-left: 1px solid var(--border);
            border-radius: 18px 0 0 18px;
        }

        .table-request thead th:last-child {
            border-right: 1px solid var(--border);
            border-radius: 0 18px 18px 0;
        }

        .table-request tbody tr {
            background: #fff;
            box-shadow: 0 8px 18px rgba(15, 95, 134, 0.04);
            transition: .22s ease;
        }

        .table-request tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 26px rgba(15, 95, 134, 0.08);
        }

        .table-request tbody td {
            background: #fff;
            padding: 16px;
            vertical-align: middle;
            border-top: 1px solid #eef3f7;
            border-bottom: 1px solid #eef3f7;
        }

        .table-request tbody td:first-child {
            border-left: 1px solid #eef3f7;
            border-radius: 18px 0 0 18px;
        }

        .table-request tbody td:last-child {
            border-right: 1px solid #eef3f7;
            border-radius: 0 18px 18px 0;
        }

        .barang-name {
            font-weight: 900;
            color: var(--text);
        }

        .barang-code {
            color: var(--muted);
            font-size: .84rem;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: .78rem;
            font-weight: 900;
        }

        .status-menunggu {
            background: #fff8e8;
            color: #b7791f;
        }

        .status-disetujui {
            background: #eefbf3;
            color: var(--success);
        }

        .status-ditolak {
            background: #fff1f1;
            color: var(--danger);
        }

        .btn-edit {
            border: none;
            background: #fff8e8;
            color: var(--warning);
            padding: 9px 14px;
            border-radius: 14px;
            font-weight: 800;
            font-size: .88rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-edit:hover {
            background: #f8df9b;
            color: #7c520d;
        }

        .btn-delete {
            border: none;
            background: #fff1f1;
            color: var(--danger);
            padding: 9px 14px;
            border-radius: 14px;
            font-weight: 800;
            font-size: .88rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-delete:hover {
            background: var(--danger);
            color: #fff;
        }

        .empty-state {
            text-align: center;
            padding: 56px 16px;
            color: var(--muted);
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--primary-dark);
            margin-bottom: 12px;
            display: block;
        }

        .empty-state h5 {
            font-weight: 900;
            color: var(--text);
            margin-bottom: 6px;
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
@endphp

<div class="staff-wrapper">
    <div class="topbar">
        <div>
            <h3>Permintaan Barang</h3>
            <p>Kelola permintaan barang yang kamu ajukan.</p>
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

    @if(session('success'))
        <div class="alert-success-custom">
            <i class="bi bi-check-circle-fill me-1"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-error-custom">
            <i class="bi bi-exclamation-circle-fill me-1"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="page-card">
        <div class="page-header">
            <div>
                <h2>Daftar Permintaan Barang</h2>
                <p>Status permintaan akan berubah setelah diproses oleh admin.</p>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('staff.dashboard') }}" class="btn-secondary-custom">
                    <i class="bi bi-arrow-left"></i>
                    Dashboard
                </a>

                <a href="{{ route('staff.permintaan-barang.create') }}" class="btn-main">
                    <i class="bi bi-plus-circle"></i>
                    Ajukan Permintaan
                </a>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="table-request">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($permintaanBarang as $item)
                        @php
                            $status = strtolower(trim($item->status ?? ''));
                        @endphp

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($item->tanggal_permintaan)->format('d/m/Y') }}
                            </td>
                            <td>
                                <div class="barang-name">
                                    {{ $item->barang->nama_barang ?? '-' }}
                                </div>
                                <div class="barang-code">
                                    {{ $item->barang->kode_barang ?? '' }}
                                </div>
                            </td>
                            <td>
                                <strong>{{ $item->jumlah }}</strong>
                                {{ $item->barang->satuan ?? '' }}
                            </td>
                            <td>
                                {{ $item->keterangan ?: '-' }}
                            </td>
                            <td>
                                @if($status === 'menunggu')
                                    <span class="badge-status status-menunggu">
                                        <i class="bi bi-hourglass-split"></i>
                                        Menunggu
                                    </span>
                                @elseif($status === 'disetujui')
                                    <span class="badge-status status-disetujui">
                                        <i class="bi bi-check-circle"></i>
                                        Disetujui
                                    </span>
                                @elseif($status === 'ditolak')
                                    <span class="badge-status status-ditolak">
                                        <i class="bi bi-x-circle"></i>
                                        Ditolak
                                    </span>
                                @else
                                    <span class="badge-status status-menunggu">
                                        {{ $item->status ?? '-' }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($status === 'menunggu')
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('staff.permintaan-barang.edit', $item->id) }}" class="btn-edit">
                                            <i class="bi bi-pencil-square"></i>
                                            Edit
                                        </a>

                                        <form action="{{ route('staff.permintaan-barang.destroy', $item->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus permintaan ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn-delete">
                                                <i class="bi bi-trash"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="text-center text-muted fw-semibold">
                                        Sudah diproses
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="bi bi-clipboard-plus"></i>
                                    <h5>Belum ada permintaan barang</h5>
                                    <p>Klik tombol Ajukan Permintaan untuk membuat permintaan barang baru.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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