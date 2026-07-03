<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil Staf</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
            --border: #e7edf2;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background:
                radial-gradient(circle at top right, rgba(134, 182, 246, 0.28), transparent 35%),
                linear-gradient(180deg, #f8fbff 0%, #f4f8fb 100%);
            color: var(--text);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .wrapper {
            min-height: 100vh;
            padding: 32px;
        }

        .profile-card {
            max-width: 760px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 28px;
            box-shadow: 0 16px 36px rgba(15, 95, 134, 0.08);
            padding: 30px;
        }

        .header-box {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 28px;
        }

        .header-box h3 {
            margin: 0;
            font-weight: 900;
            color: var(--primary-dark);
        }

        .header-box p {
            margin: 5px 0 0;
            color: var(--muted);
        }

        .foto-preview {
            width: 150px;
            height: 150px;
            border-radius: 999px;
            object-fit: cover;
            border: 4px solid var(--primary);
            display: block;
            margin: 0 auto 18px;
            background: #fff;
        }

        .foto-preview-text {
            width: 150px;
            height: 150px;
            border-radius: 999px;
            background: var(--primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            font-weight: 900;
            margin: 0 auto 18px;
            border: 4px solid var(--primary);
        }

        .form-label {
            font-weight: 800;
            color: var(--text);
            margin-bottom: 8px;
        }

        .form-control-custom {
            width: 100%;
            border: 1px solid #d9e5ee;
            background: #fff;
            color: var(--text);
            padding: 14px 16px;
            border-radius: 16px;
            outline: none;
        }

        .form-control-custom:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(134, 182, 246, 0.18);
        }

        .form-error {
            margin-top: 7px;
            color: #dc3545;
            font-size: .86rem;
            font-weight: 700;
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
        }

        .btn-main:hover {
            color: #fff;
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
        }

        .btn-secondary-custom:hover {
            background: var(--primary-soft);
            color: var(--primary-dark);
        }

        .action-box {
            display: flex;
            gap: 10px;
            margin-top: 24px;
        }

        @media (max-width: 576px) {
            .wrapper {
                padding: 18px;
            }

            .header-box {
                flex-direction: column;
            }

            .action-box {
                flex-direction: column;
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
    $fotoProfil = $user && $user->foto ? asset('storage/' . $user->foto) : null;
@endphp

<div class="wrapper">
    <div class="profile-card">
        <div class="header-box">
            <div>
                <h3>Edit Profil</h3>
                <p>Upload atau ganti foto profil staf.</p>
            </div>

            <a href="{{ route('staff.dashboard') }}" class="btn-secondary-custom">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>
        </div>

        @if($fotoProfil)
            <img src="{{ $fotoProfil }}" alt="Foto Profil" class="foto-preview" id="previewFoto">
        @else
            <div class="foto-preview-text" id="previewText">
                {{ strtoupper(substr($user->name ?? 'S', 0, 1)) }}
            </div>

            <img src="" alt="Preview Foto" class="foto-preview d-none" id="previewFoto">
        @endif

        <form action="{{ route('staff.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <label class="form-label">Pilih Foto Baru</label>
                <input
                    type="file"
                    name="foto"
                    id="fotoInput"
                    class="form-control-custom"
                    accept="image/*"
                    required
                >

                @error('foto')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="action-box">
                <button type="submit" class="btn-main">
                    <i class="bi bi-check-circle"></i>
                    Simpan Foto
                </button>

                <a href="{{ route('staff.dashboard') }}" class="btn-secondary-custom">
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    const fotoInput = document.getElementById('fotoInput');
    const previewFoto = document.getElementById('previewFoto');
    const previewText = document.getElementById('previewText');

    if (fotoInput && previewFoto) {
        fotoInput.addEventListener('change', function () {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function (event) {
                    previewFoto.src = event.target.result;
                    previewFoto.classList.remove('d-none');

                    if (previewText) {
                        previewText.classList.add('d-none');
                    }
                };

                reader.readAsDataURL(file);
            }
        });
    }
</script>

</body>
</html>