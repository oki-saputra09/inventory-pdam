<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - INVENDAM</title>

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
            --danger: #dc3545;
            --danger-soft: #fff1f1;
            --border: #e7edf2;
            --success: #198754;
            --success-soft: #eefbf3;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background:
                radial-gradient(circle at top right, rgba(134, 182, 246, 0.28), transparent 35%),
                linear-gradient(180deg, #f8fbff 0%, #f4f8fb 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text);
            min-height: 100vh;
            margin: 0;
        }

        .page-wrapper {
            min-height: 100vh;
            padding: 40px 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-card {
            width: 100%;
            max-width: 900px;
            background: #ffffff;
            border-radius: 26px;
            border: 1px solid var(--border);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.07);
            overflow: hidden;
        }

        .profile-header {
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-dark));
            color: #ffffff;
            padding: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .profile-header h3 {
            margin: 0;
            font-weight: 900;
            font-size: 2rem;
        }

        .profile-header p {
            margin: 8px 0 0;
            color: #eef9ff;
            font-size: 1rem;
        }

        .header-icon {
            width: 58px;
            height: 58px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .16);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            flex-shrink: 0;
        }

        .profile-body {
            padding: 30px;
        }

        .section-box {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 22px;
            padding: 26px;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.035);
        }

        .section-title {
            color: var(--primary-dark);
            font-weight: 900;
            margin-bottom: 6px;
        }

        .section-desc {
            color: var(--muted);
            margin-bottom: 22px;
            font-size: .95rem;
        }

        .photo-layout {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 28px;
            align-items: center;
        }

        .photo-left {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .avatar-preview {
            width: 135px;
            height: 135px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid var(--primary);
            background: var(--primary-soft);
            display: block;
            flex-shrink: 0;
            box-shadow: 0 12px 26px rgba(134, 182, 246, 0.35);
        }

        .avatar-name {
            margin-top: 12px;
            font-weight: 900;
            color: var(--primary-dark);
            text-align: center;
            word-break: break-word;
        }

        .avatar-role {
            text-align: center;
            font-size: 13px;
            color: var(--muted);
            margin-top: 2px;
            text-transform: capitalize;
        }

        .avatar-info {
            color: var(--muted);
            font-size: 12px;
            margin-top: 8px;
        }

        .form-label {
            font-weight: 800;
            color: var(--text);
        }

        .form-control {
            min-height: 48px;
            border-radius: 14px;
            border: 1px solid #dbe6ef;
        }

        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 .2rem rgba(21, 155, 216, .12);
        }

        .btn-save {
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-dark));
            border: none;
            color: #ffffff;
            border-radius: 14px;
            padding: 11px 20px;
            font-weight: 800;
        }

        .btn-save:hover {
            color: #ffffff;
            opacity: .95;
            transform: translateY(-1px);
        }

        .btn-delete-photo {
            background: var(--danger-soft);
            color: var(--danger);
            border: 1px solid #ffd0d0;
            border-radius: 14px;
            padding: 11px 20px;
            font-weight: 800;
        }

        .btn-delete-photo:hover {
            background: #ffe2e2;
            color: var(--danger);
            transform: translateY(-1px);
        }

        .btn-back {
            border-radius: 14px;
            padding: 11px 20px;
            font-weight: 800;
        }

        .alert {
            border-radius: 16px;
            font-weight: 700;
        }

        .alert-danger {
            background: #ffdfe3;
            border-color: #f5a9b2;
            color: #5f1018;
        }

        .alert-success {
            background: var(--success-soft);
            border-color: #cfe9d9;
            color: var(--success);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .form-grid .full {
            grid-column: 1 / -1;
        }

        .action-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .photo-action-row {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 16px;
        }

        @media (max-width: 768px) {
            .photo-layout {
                grid-template-columns: 1fr;
            }

            .photo-left {
                align-items: flex-start;
            }

            .avatar-name,
            .avatar-role {
                text-align: left;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .page-wrapper {
                padding: 20px 12px;
            }

            .profile-header {
                align-items: flex-start;
                padding: 24px;
            }

            .profile-header h3 {
                font-size: 1.65rem;
            }

            .profile-body {
                padding: 20px;
            }

            .section-box {
                padding: 20px;
            }

            .avatar-preview {
                width: 115px;
                height: 115px;
            }

            .action-row,
            .photo-action-row {
                flex-direction: column;
                align-items: stretch;
            }

            .action-row .btn,
            .action-row a,
            .action-row button,
            .photo-action-row .btn,
            .photo-action-row button,
            .photo-action-row form {
                width: 100%;
            }
        }
    </style>
</head>

<body>
@php
    $user = $user ?? auth()->user();

    $roleName = optional($user->role)->name;

    if (!$roleName && isset($user->getAttributes()['role'])) {
        $roleName = $user->getAttributes()['role'];
    }

    $roleName = strtolower(trim($roleName ?? ''));

    if ($roleName === 'staff') {
        $roleName = 'staf';
    }

    $backRoute = route('dashboard');

    if ($roleName === 'admin' && \Illuminate\Support\Facades\Route::has('admin.dashboard')) {
        $backRoute = route('admin.dashboard');
    } elseif ($roleName === 'staf' && \Illuminate\Support\Facades\Route::has('staff.dashboard')) {
        $backRoute = route('staff.dashboard');
    }

    $avatarDefault = asset('uploads/foto-profil/avatar.png');
    $fotoUrl = $avatarDefault;

    if ($user && !empty($user->foto)) {
        $foto = ltrim($user->foto, '/');
        $versiFoto = optional($user->updated_at)->timestamp ?? time();

        if (str_starts_with($foto, 'http://') || str_starts_with($foto, 'https://')) {
            $fotoUrl = $foto;
        } elseif (str_starts_with($foto, 'storage/')) {
            $fotoUrl = asset($foto) . '?v=' . $versiFoto;
        } elseif (str_starts_with($foto, 'uploads/')) {
            $fotoUrl = asset($foto) . '?v=' . $versiFoto;
        } elseif (file_exists(public_path('storage/' . $foto))) {
            $fotoUrl = asset('storage/' . $foto) . '?v=' . $versiFoto;
        } elseif (file_exists(public_path($foto))) {
            $fotoUrl = asset($foto) . '?v=' . $versiFoto;
        }
    }
@endphp

<div class="page-wrapper">
    <div class="profile-card">
        <div class="profile-header">
            <div>
                <h3>Edit Profil</h3>
                <p>Perbarui data akun dan foto profil Anda.</p>
            </div>

            <div class="header-icon">
                <i class="bi bi-person-circle"></i>
            </div>
        </div>

        <div class="profile-body">
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('status') === 'profile-updated')
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    Profil berhasil diperbarui.
                </div>
            @endif

            @if (session('status') === 'foto-updated')
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    Foto profil berhasil diperbarui.
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi kesalahan.</strong>

                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="section-box mb-4">
                <h5 class="section-title">Foto Profil</h5>
                <p class="section-desc">
                    Upload, ganti, atau hapus foto profil. Jika foto dihapus, sistem akan kembali memakai avatar default.
                </p>

                <div class="photo-layout">
                    <div class="photo-left">
                        <img
                            src="{{ $fotoUrl }}"
                            alt="Foto Profil"
                            class="avatar-preview"
                            id="avatarPreview"
                            onerror="this.onerror=null; this.src='{{ $avatarDefault }}';"
                        >

                        <div class="avatar-name">
                            {{ $user->name ?? 'User' }}
                        </div>

                        <div class="avatar-role">
                            {{ $roleName ?: 'user' }}
                        </div>
                    </div>

                    <div>
                        <form action="{{ route('profile.foto.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <label for="fotoInput" class="form-label">
                                Pilih Foto Baru
                            </label>

                            <input
                                type="file"
                                name="foto"
                                id="fotoInput"
                                class="form-control @error('foto') is-invalid @enderror"
                                accept="image/png,image/jpg,image/jpeg"
                                required
                            >

                            @error('foto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="avatar-info">
                                Format JPG, JPEG, PNG. Maksimal 2MB.
                            </div>

                            <div class="photo-action-row">
                                <button type="submit" class="btn btn-save">
                                    <i class="bi bi-image"></i>
                                    Simpan / Ganti Foto
                                </button>
                            </div>
                        </form>

                        <form action="{{ route('profile.foto.destroy') }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-delete-photo"
                                onclick="return confirm('Yakin ingin menghapus foto profil? Foto akan kembali ke avatar default.')"
                            >
                                <i class="bi bi-trash"></i>
                                Hapus Foto
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="section-box">
                <h5 class="section-title">Data Akun</h5>
                <p class="section-desc">
                    Perbarui nama, username, dan email akun Anda.
                </p>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="form-grid">
                        <div>
                            <label for="name" class="form-label">Nama</label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}"
                                required
                            >

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div>
                            <label for="username" class="form-label">Username</label>

                            <input
                                type="text"
                                id="username"
                                name="username"
                                class="form-control @error('username') is-invalid @enderror"
                                value="{{ old('username', $user->username) }}"
                                required
                            >

                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="full">
                            <label for="email" class="form-label">Email</label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}"
                                required
                            >

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="action-row mt-4">
                        <a href="{{ $backRoute }}" class="btn btn-light btn-back">
                            <i class="bi bi-arrow-left"></i>
                            Kembali
                        </a>

                        <button type="submit" class="btn btn-save">
                            <i class="bi bi-save"></i>
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const fotoInput = document.getElementById('fotoInput');
    const avatarPreview = document.getElementById('avatarPreview');

    if (fotoInput && avatarPreview) {
        fotoInput.addEventListener('change', function () {
            const file = this.files[0];

            if (!file) {
                return;
            }

            avatarPreview.src = URL.createObjectURL(file);
        });
    }
</script>
</body>
</html>