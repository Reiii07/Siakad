<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Dosen - SiaCentral</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body class="auth-page auth-dosen">

<div class="login-wrapper">
    <div class="login-left">
        <div class="left-logo">
            <div class="logo-icon"><i class="bi bi-mortarboard-fill"></i></div>
            <span>SiaCentral</span>
        </div>

        <div class="left-body">
            <h1>Ruang dosen</h1>
            <p>Masuk untuk melihat jadwal mengajar, tugas, dan absensi kelas yang Anda ampu.</p>
        </div>

        <div class="left-features">
            <div class="feature-item">
                <i class="bi bi-person-badge"></i>
                <span>Akun dosen terdaftar</span>
            </div>

            <div class="feature-item">
                <i class="bi bi-shield-lock"></i>
                <span>Kelola kelas dan absensi</span>
            </div>

            <div class="feature-item">
                <i class="bi bi-graph-up"></i>
                <span>Pantau tugas mahasiswa</span>
            </div>
        </div>
    </div>

    <div class="login-right">
        <h2>Masuk sebagai dosen</h2>
        <p>Gunakan username dan password dosen.</p>

        <form method="POST" action="{{ route('dosen.login.post') }}">
            @csrf

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
                <label>Username</label>
                <div class="input-wrap">
                    <i class="bi bi-person"></i>
                    <input type="text" name="username" class="form-control-custom" placeholder="Username dosen" value="{{ old('username') }}" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-wrap">
                    <i class="bi bi-lock"></i>
                    <input type="password" name="password" id="passInput" class="form-control-custom" placeholder="Password dosen" required>
                </div>

                <div class="form-hint">
                    <input type="checkbox" onchange="document.getElementById('passInput').type = this.checked ? 'text' : 'password'">
                    Tampilkan password
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right"></i>
                Masuk ke portal
            </button>

            <div class="form-hint" style="margin-top:14px">
                <a href="{{ route('login') }}">Kembali ke login utama</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
