<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pengaturan - Siakad App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/pengaturan.css') }}">
</head>
<body>
<aside class="sidebar">
  <div class="sidebar-logo"><div class="logo-icon">S</div><span>Siakad App</span></div>
  <nav class="sidebar-nav">
    <a href="{{ route('admin.dashboard') }}" class="nav-item"><i class="bi bi-grid"></i> Dashboard</a>
    <div class="nav-label">Akademik</div>
    <div>
      <div class="nav-item"><i class="bi bi-mortarboard"></i> Akademik <i class="bi bi-chevron-down ms-auto" style="font-size:11px"></i></div>
      <div class="nav-sub" style="display:block">
        <a href="{{ route('admin.dashboard') }}" class="nav-item"><i class="bi bi-people"></i> Mahasiswa</a>
        <a href="{{ route('admin.dosen.index') }}" class="nav-item"><i class="bi bi-person-badge"></i> Dosen</a>
        <a href="{{ route('admin.mata-kuliah.index') }}" class="nav-item"><i class="bi bi-book"></i> Mata Kuliah</a>
      </div>
    </div>
    <a href="{{ route('admin.absensi.index') }}" class="nav-item"><i class="bi bi-calendar-check"></i> Absensi</a>
    <a href="{{ route('admin.tugas.index') }}" class="nav-item"><i class="bi bi-clipboard-check"></i> Tugas</a>
    <a href="{{ route('admin.pengaturan.index') }}" class="nav-item active"><i class="bi bi-gear"></i> Pengaturan</a>
  </nav>
</aside>

<div class="main">
  <div class="topbar">
    <div class="search-box"><i class="bi bi-search"></i><input type="text" placeholder="Search..."></div>
    <div class="topbar-right"><div class="notif"><i class="bi bi-bell"></i></div><div class="avatar">{{ strtoupper(substr(session('nama', 'Admin'), 0, 1)) }}</div></div>
  </div>

  <div class="content">
    <div class="page-header"><h1>Pengaturan</h1></div>

    <div class="pengaturan-card">
      <div class="pengaturan-card-header"><h2>Akun</h2></div>
      <div class="pengaturan-card-body">
        <div class="akun-info">
          <div class="akun-avatar">{{ strtoupper(substr(session('nama', 'Admin'), 0, 1)) }}</div>
          <div>
            <div class="akun-nama">{{ session('nama', 'Admin') }}</div>
            <span class="akun-role">{{ ucfirst(session('role', 'admin')) }}</span>
          </div>
        </div>

        <hr class="divider">

        <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Yakin ingin keluar?')">
          @csrf
          <button type="submit" class="btn-logout">
            <i class="bi bi-box-arrow-right"></i> Keluar dari Akun
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>
