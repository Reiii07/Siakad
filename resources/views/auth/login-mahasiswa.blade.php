<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Mahasiswa - Siakad App</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

<div class="login-wrapper">
    <div class="login-left">
        <div class="left-logo">
            <div class="logo-icon">S</div>
            <span>Siakad App</span>
        </div>

        <div class="left-body">
            <h1>Portal Mahasiswa</h1>
            <p>Akses dashboard akademik, absensi, dan tugas menggunakan data mahasiswa Anda.</p>
        </div>

        <div class="left-features">
            <div class="feature-item">
                <i class="bi bi-person-check"></i>
                <span>Login dengan nama lengkap</span>
            </div>

            <div class="feature-item">
                <i class="bi bi-shield-lock"></i>
                <span>Password menggunakan NIM</span>
            </div>

            <div class="feature-item">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard khusus mahasiswa</span>
            </div>
        </div>
    </div>

    <div class="login-right">
        <h2>Login Mahasiswa</h2>
        <p>Masukkan nama lengkap dan NIM</p>

        <form method="POST" action="{{ route('mahasiswa.login.post') }}">
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
                <label>Nama Lengkap</label>
                <div class="input-wrap">
                    <i class="bi bi-person"></i>
                    <input type="text" name="username" class="form-control-custom" placeholder="Contoh: Dzul Kifly Rustam" value="{{ old('username') }}" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label>NIM</label>
                <div class="input-wrap">
                    <i class="bi bi-lock"></i>
                    <input type="password" name="password" id="passInput" class="form-control-custom" placeholder="Masukkan NIM" required>
                </div>

                <div class="form-hint">
                    <input type="checkbox" onchange="document.getElementById('passInput').type = this.checked ? 'text' : 'password'">
                    Tampilkan NIM
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right"></i>
                Masuk
            </button>
        </form>
    </div>
</div>

</body>
</html>
