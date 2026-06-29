<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Portal - SiaCentral</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body class="auth-page auth-{{ $loginRole }}">

<div class="login-wrapper">
    <div class="login-left">
        <div class="left-logo">
            <div class="logo-icon"><i class="bi bi-mortarboard-fill"></i></div>
            <span>SiaCentral</span>
        </div>

        <div class="left-body">
            <h1>{{ $loginRole === 'dosen' ? 'Ruang dosen' : 'Ruang mahasiswa' }}</h1>
            <p>{{ $loginRole === 'dosen' ? 'Masuk untuk melihat jadwal mengajar, tugas, dan absensi kelas yang Anda ampu.' : 'Masuk untuk melihat jadwal, absensi, tugas, dan informasi akademik Anda.' }}</p>
        </div>

        <div class="left-features">
            <div class="feature-item">
                <i class="bi bi-{{ $loginRole === 'dosen' ? 'person-badge' : 'person-check' }}"></i>
                <span>{{ $loginRole === 'dosen' ? 'Akun dosen terdaftar' : 'Gunakan nama lengkap' }}</span>
            </div>

            <div class="feature-item">
                <i class="bi bi-shield-lock"></i>
                <span>{{ $loginRole === 'dosen' ? 'Kelola kelas dan absensi' : 'NIM sebagai kata sandi' }}</span>
            </div>

            <div class="feature-item">
                <i class="bi bi-{{ $loginRole === 'dosen' ? 'graph-up' : 'speedometer2' }}"></i>
                <span>{{ $loginRole === 'dosen' ? 'Pantau tugas mahasiswa' : 'Informasi akademik pribadi' }}</span>
            </div>
        </div>
    </div>

    <div class="login-right">
        <h2>{{ $loginRole === 'dosen' ? 'Masuk sebagai dosen' : 'Masuk sebagai mahasiswa' }}</h2>
        <p>{{ $loginRole === 'dosen' ? 'Gunakan username dan password dosen.' : 'Gunakan nama lengkap dan NIM Anda.' }}</p>

        <div class="login-switch">
            <a href="{{ route('login') }}" class="{{ $loginRole === 'mahasiswa' ? 'active' : '' }}">Mahasiswa</a>
            <a href="{{ route('login', ['role' => 'dosen']) }}" class="{{ $loginRole === 'dosen' ? 'active' : '' }}">Dosen</a>
        </div>

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <input type="hidden" name="role" value="{{ $loginRole }}">

            @if(session('error'))
            <div class="alert-error">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ session('error') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert-error">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ $errors->first() }}
            </div>
            @endif

            <div class="form-group">
                <label>{{ $loginRole === 'dosen' ? 'Username' : 'Nama Lengkap' }}</label>
                <div class="input-wrap">
                    <i class="bi bi-person"></i>
                    <input type="text" name="username" class="form-control-custom" placeholder="{{ $loginRole === 'dosen' ? 'Username dosen' : 'Contoh: Dzul Kifly Rustam' }}" value="{{ old('username') }}" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label>{{ $loginRole === 'dosen' ? 'Password' : 'NIM' }}</label>
                <div class="input-wrap">
                    <i class="bi bi-lock"></i>
                    <input type="password" name="password" id="passInput" class="form-control-custom" placeholder="{{ $loginRole === 'dosen' ? 'Password dosen' : 'Nomor induk mahasiswa' }}" required>
                </div>

                <div class="form-hint">
                    <input type="checkbox" onchange="document.getElementById('passInput').type = this.checked ? 'text' : 'password'">
                    {{ $loginRole === 'dosen' ? 'Tampilkan password' : 'Tampilkan NIM' }}
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right"></i>
                Masuk ke portal
            </button>

        </form>
    </div>
</div>

</body>
</html>
