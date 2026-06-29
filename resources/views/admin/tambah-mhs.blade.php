<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Mahasiswa - Siakad App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/dosen.css') }}">
</head>
<body id="top">
<aside class="sidebar">
  <a href="{{ route('admin.dashboard') }}" class="sidebar-logo"><div class="logo-icon">S</div><span>Siakad App</span></a>
  <nav class="sidebar-nav">
    <a href="{{ route('admin.dashboard') }}" class="nav-item"><i class="bi bi-grid"></i> Dashboard</a>
    <div class="nav-label">Akademik</div>
    <div>
      <div class="nav-item"><i class="bi bi-mortarboard"></i> Akademik <i class="bi bi-chevron-down ms-auto" style="font-size:11px"></i></div>
      <div class="nav-sub" style="display:block">
        <a href="{{ route('admin.dashboard') }}" class="nav-item active"><i class="bi bi-people"></i> Mahasiswa</a>
        <a href="{{ route('admin.dosen.index') }}" class="nav-item"><i class="bi bi-person-badge"></i> Dosen</a>
        <a href="{{ route('admin.mata-kuliah.index') }}" class="nav-item"><i class="bi bi-book"></i> Mata Kuliah</a>
      </div>
    </div>
    <a href="{{ route('admin.pengaturan.index') }}" class="nav-item"><i class="bi bi-gear"></i> Pengaturan</a>
  </nav>
</aside>

<div class="main">
  <div class="topbar">
    <div class="search-box"><i class="bi bi-search"></i><input type="text" placeholder="Search..."></div>
    <div class="topbar-right">
      <div class="topbar-menu">
        @include('admin.partials.notifications')
      </div>
      <div class="topbar-menu">
        <button type="button" class="avatar" data-menu-toggle="accountMenu" aria-label="Akun">{{ strtoupper(substr(session('nama', 'Admin'), 0, 1)) }}</button>
        <div class="dropdown-panel account-panel" id="accountMenu">
          <div class="account-summary"><div class="avatar mini">{{ strtoupper(substr(session('nama', 'Admin'), 0, 1)) }}</div><div><div class="account-name">{{ session('nama', 'Admin') }}</div><div class="account-role">{{ ucfirst(session('role', 'admin')) }}</div></div></div>
          <a href="{{ route('admin.pengaturan.index') }}" class="dropdown-link"><i class="bi bi-gear"></i> Pengaturan</a>
          <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="dropdown-link danger"><i class="bi bi-box-arrow-right"></i> Keluar</button></form>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="page-header"><h1>Tambah Mahasiswa</h1></div>

    <div class="form-card" style="max-width:680px">
      <div class="form-card-header">
        <div class="icon"><i class="bi bi-person-plus"></i></div>
        <h2>Data Mahasiswa Baru</h2>
      </div>

      <form method="POST" action="{{ route('admin.mahasiswa.store') }}">
        @csrf
        <div class="form-card-body">
          @if($errors->any())
            <div class="alert-error"><i class="bi bi-exclamation-circle-fill"></i>{{ $errors->first() }}</div>
          @endif

          <div class="form-group">
            <label>NIM <span>*</span></label>
            <div class="input-wrap"><i class="bi bi-hash"></i><input type="text" name="nim" class="form-control-custom" placeholder="Contoh: 241011065" value="{{ old('nim') }}" required></div>
            <div class="form-hint">Nomor Induk Mahasiswa harus unik</div>
          </div>

          <div class="form-group">
            <label>Nama Mahasiswa <span>*</span></label>
            <div class="input-wrap"><i class="bi bi-person"></i><input type="text" name="nama_mahasiswa" class="form-control-custom" placeholder="Nama lengkap mahasiswa" value="{{ old('nama_mahasiswa') }}" required></div>
            <div class="form-hint">Nama lengkap ini dipakai sebagai username login mahasiswa</div>
          </div>

          <div class="form-group">
            <label>Akun Login</label>
            <div class="input-wrap"><i class="bi bi-info-circle"></i><input type="text" class="form-control-custom" value="Username: nama lengkap, Password: NIM" readonly></div>
            <div class="form-hint">Kredensial dibuat otomatis dari data mahasiswa</div>
          </div>
        </div>

        <div class="form-footer">
          <a href="{{ route('admin.dashboard') }}" class="btn-cancel">Batal</a>
          <button type="submit" class="btn-save"><i class="bi bi-check-lg"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="{{ asset('js/admin-topbar.js') }}"></script>
</body>
</html>
