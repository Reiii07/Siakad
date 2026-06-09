<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Siakad App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }
    body { background: #f0f4ff; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
    .login-wrapper { display: flex; width: 900px; min-height: 560px; background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 60px rgba(79,91,213,.13); }
    .login-left { width: 420px; background: linear-gradient(145deg, #4f5bd5 0%, #5c6ee0 50%, #7b89ee 100%); padding: 48px 40px; display: flex; flex-direction: column; justify-content: space-between; color: #fff; position: relative; overflow: hidden; }
    .login-left::before { content: ''; position: absolute; width: 300px; height: 300px; border-radius: 50%; background: rgba(255,255,255,.07); top: -80px; right: -80px; }
    .login-left::after { content: ''; position: absolute; width: 200px; height: 200px; border-radius: 50%; background: rgba(255,255,255,.05); bottom: -50px; left: -50px; }
    .left-logo { display: flex; align-items: center; gap: 12px; font-weight: 700; font-size: 18px; }
    .logo-icon { width: 38px; height: 38px; background: rgba(255,255,255,.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 18px; }
    .left-body { position: relative; z-index: 1; }
    .left-body h1 { font-size: 26px; font-weight: 800; line-height: 1.3; margin-bottom: 14px; }
    .left-body p { font-size: 14px; opacity: .8; line-height: 1.6; }
    .left-features { position: relative; z-index: 1; }
    .feature-item { display: flex; align-items: center; gap: 10px; font-size: 13.5px; opacity: .85; margin-bottom: 10px; }
    .login-right { flex: 1; padding: 52px 44px; display: flex; flex-direction: column; justify-content: center; }
    .login-right h2 { font-size: 24px; font-weight: 800; color: #1a1d2e; margin-bottom: 6px; }
    .login-right > p { font-size: 14px; color: #8a90a2; margin-bottom: 32px; }
    .alert-error { background: #fff2f2; border: 1px solid #ffc5c5; color: #c0392b; border-radius: 10px; padding: 11px 14px; font-size: 13.5px; display: flex; align-items: center; gap: 8px; margin-bottom: 20px; }
    .form-group { margin-bottom: 18px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: #3d4263; margin-bottom: 7px; }
    .input-wrap { position: relative; }
    .input-wrap i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #aab0c4; font-size: 15px; pointer-events: none; }
    .form-control-custom { width: 100%; padding: 11px 14px 11px 40px; border: 1.5px solid #e4e7f0; border-radius: 10px; font-family: inherit; font-size: 14px; color: #1a1d2e; background: #f8f9fd; transition: border .2s, box-shadow .2s; outline: none; }
    .form-control-custom:focus { border-color: #4f5bd5; background: #fff; box-shadow: 0 0 0 3px rgba(79,91,213,.1); }
    .form-hint { display: flex; align-items: center; gap: 6px; font-size: 12.5px; color: #8a90a2; margin-top: 7px; cursor: pointer; user-select: none; }
    .btn-login { width: 100%; padding: 12px; background: linear-gradient(135deg, #4f5bd5, #6c78e6); color: #fff; border: none; border-radius: 10px; font-family: inherit; font-size: 15px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 8px; transition: opacity .2s, transform .15s; }
    .btn-login:hover { opacity: .92; transform: translateY(-1px); }
  </style>
</head>
<body>
<div class="login-wrapper">
  <div class="login-left">
    <div class="left-logo">
      <div class="logo-icon">S</div>
      <span>Siakad App</span>
    </div>
    <div class="left-body">
      <h1>Sistem Informasi Akademik Terpadu</h1>
      <p>Kelola data akademik mahasiswa, dosen, absensi, dan tugas dalam satu platform.</p>
    </div>
    <div class="left-features">
      <div class="feature-item"><i class="bi bi-people"></i><span>Manajemen Mahasiswa & Dosen</span></div>
      <div class="feature-item"><i class="bi bi-calendar-check"></i><span>Absensi Digital</span></div>
      <div class="feature-item"><i class="bi bi-clipboard-check"></i><span>Pengumpulan Tugas</span></div>
    </div>
  </div>
  <div class="login-right">
    <h2>Selamat Datang</h2>
    <p>Masuk ke akun Anda</p>
    <form method="POST" action="{{ route('login.post') }}">
      @csrf
      @if(session('error'))
      <div class="alert-error"><i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}</div>
      @endif
      <div class="form-group">
        <label>Username</label>
        <div class="input-wrap">
          <i class="bi bi-person"></i>
          <input type="text" name="username" class="form-control-custom" placeholder="Masukkan username" required autofocus>
        </div>
      </div>
      <div class="form-group">
        <label>Password</label>
        <div class="input-wrap">
          <i class="bi bi-lock"></i>
          <input type="password" name="password" id="passInput" class="form-control-custom" placeholder="Masukkan password" required>
        </div>
        <div class="form-hint">
          <input type="checkbox" onchange="document.getElementById('passInput').type = this.checked ? 'text' : 'password'">
          Tampilkan password
        </div>
      </div>
      <button type="submit" class="btn-login"><i class="bi bi-box-arrow-in-right"></i> Masuk</button>
    </form>
  </div>
</div>
</body>
</html>