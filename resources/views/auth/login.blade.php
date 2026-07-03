<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Login Sistem</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @php
        // GANTI BACKGROUND DI SINI
        $bgImage = asset('images/bg login.jpg');

        // LOGO
        $logoKantor = asset('images/logo.png');

        // TOMBOL KEMBALI KE DASHBOARD AWAL
        $backHomeUrl = \Illuminate\Support\Facades\Route::has('home')
            ? route('home')
            : url('/');
    @endphp

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            min-height: 100vh;
            background:
                linear-gradient(rgba(9, 61, 108, 0.45), rgba(0, 119, 182, 0.35)),
                url('{{ $bgImage }}') center/cover no-repeat fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }

        .login-card {
            max-width: 360px;
            width: 100%;
            background: rgba(255, 255, 255, 0.90);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.45);
            border-radius: 22px;
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.30);
            padding: 22px 22px 24px;
        }

        .logo-center {
            text-align: center;
            margin-bottom: 12px;
        }

        .logo-center img {
            width: 88px;
            height: 88px;
            object-fit: contain;
            display: inline-block;
            filter: drop-shadow(0 0 2px rgba(255,255,255,0.9))
                    drop-shadow(0 0 6px rgba(255,255,255,0.9));
        }

        .title-wrapper {
            text-align: center;
            margin-bottom: 18px;
        }

        .login-title {
            font-size: 30px;
            font-weight: 800;
            color: #005b96;
            margin-bottom: 4px;
        }

        .login-subtitle {
            font-size: 13px;
            color: #3d6e8f;
        }

        .status-box {
            background: #fee9e6;
            border-radius: 14px;
            padding: 10px 14px;
            margin-bottom: 16px;
            font-size: 12px;
            color: #bc3900;
            border-left: 4px solid #e25c1c;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #0a4f84;
            margin-bottom: 7px;
        }

        .input-wrap {
            position: relative;
        }

        .form-input {
            width: 100%;
            height: 48px;
            background: #f7fbfd;
            border: 1.5px solid #cfe3ef;
            border-radius: 12px;
            padding: 0 42px 0 14px;
            font-size: 14px;
            color: #1a2f36;
            outline: none;
            transition: 0.2s;
        }

        .form-input:focus {
            border-color: #00a8cc;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(0, 168, 204, 0.12);
        }

        .form-input::placeholder {
            color: #93a9b8;
        }

        .input-icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            color: #0077b6;
            pointer-events: none;
        }

        .field-error {
            font-size: 11px;
            color: #da3e2d;
            margin-top: 6px;
            margin-left: 4px;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin: 6px 0 18px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #0a4f84;
            font-weight: 500;
        }

        .remember-me input {
            width: 15px;
            height: 15px;
            accent-color: #00a8cc;
        }

        .forgot-link {
            font-size: 13px;
            font-weight: 600;
            color: #0077b6;
            text-decoration: none;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .button-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            align-items: center;
        }

        .btn-login {
            width: 100%;
            height: 48px;
            background: linear-gradient(180deg, #00a8cc, #0077b6);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
            box-shadow: 0 8px 18px rgba(0, 119, 182, 0.20);
        }

        .btn-login:hover {
            background: linear-gradient(180deg, #0096c7, #005f99);
            transform: translateY(-1px);
        }

        .btn-back-home {
            width: 100%;
            height: 48px;
            background: #ffffff;
            border: 1.5px solid #cfe3ef;
            border-radius: 12px;
            color: #005b96;
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            transition: 0.2s;
            box-shadow: 0 8px 18px rgba(0, 119, 182, 0.08);
        }

        .btn-back-home:hover {
            background: #f4fbff;
            color: #0077b6;
            border-color: #00a8cc;
            transform: translateY(-1px);
        }

        @media (max-width: 500px) {
            .login-card {
                max-width: 330px;
                padding: 20px 16px 22px;
            }

            .logo-center img {
                width: 78px;
                height: 78px;
            }

            .login-title {
                font-size: 26px;
            }

            .btn-login,
            .btn-back-home {
                height: 46px;
                font-size: 15px;
            }

            .btn-back-home {
                font-size: 13px;
            }

            .form-options {
                flex-direction: column;
                align-items: flex-start;
            }

            .button-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="logo-center">
        <img src="{{ $logoKantor }}" alt="Logo Perusahaan">
    </div>

    <div class="title-wrapper">
        <h1 class="login-title">INVENDAM LOGIN</h1>
    </div>

    @if (session('status'))
        <div class="status-box">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="status-box">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="username">Username / Email</label>
            <div class="input-wrap">
                <input
                    id="username"
                    class="form-input"
                    type="text"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Masukkan username / email"
                >
                <span class="input-icon">✉</span>
            </div>

            @error('email')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <div class="input-wrap">
                <input
                    id="password"
                    class="form-input"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Masukkan password"
                >
                <span class="input-icon">🔒</span>
            </div>

            @error('password')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-options">
            <label class="remember-me">
                <input type="checkbox" name="remember">
                <span>Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="forgot-link" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @else
                <a class="forgot-link" href="#">
                    Lupa password?
                </a>
            @endif
        </div>

        <div class="button-row">
            <button type="submit" class="btn-login">
                LOGIN
            </button>

            <a href="{{ $backHomeUrl }}" class="btn-back-home">
                ← Kembali
            </a>
        </div>
    </form>
</div>

</body>
</html>