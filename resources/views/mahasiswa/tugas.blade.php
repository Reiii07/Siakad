<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tugas Mahasiswa - SiaCentral</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/tugas.css') }}">
  <link rel="stylesheet" href="{{ asset('css/absensi.css') }}">
</head>
<body>
<aside class="sidebar">
  <div class="sidebar-logo"><div class="logo-icon"><i class="bi bi-mortarboard-fill"></i></div><span>SiaCentral</span></div>
  <nav class="sidebar-nav">
    <a href="{{ route('mahasiswa.dashboard') }}" class="nav-item {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}"><i class="bi bi-grid"></i> Dashboard</a>
    <div class="nav-label">Mahasiswa</div>
    <a href="{{ route('mahasiswa.jadwal.index') }}" class="nav-item {{ request()->routeIs('mahasiswa.jadwal.index') ? 'active' : '' }}"><i class="bi bi-calendar2"></i> Jadwal</a>
    <a href="{{ route('mahasiswa.tugas.index') }}" class="nav-item {{ request()->routeIs('mahasiswa.tugas.index') ? 'active' : '' }}"><i class="bi bi-clipboard-check"></i> Tugas</a>
    <a href="{{ route('mahasiswa.absensi.index') }}" class="nav-item {{ request()->routeIs('mahasiswa.absensi.index') ? 'active' : '' }}"><i class="bi bi-calendar-check"></i> Absensi</a>
    <form method="POST" action="{{ route('logout') }}" style="margin-top:14px">
      @csrf
      <button type="submit" class="nav-item" style="width:100%;border:0;background:transparent">
        <i class="bi bi-box-arrow-left"></i> Logout
      </button>
    </form>
  </nav>
</aside>

<div class="main">
  <div class="topbar">
    <div class="search-box"><i class="bi bi-person"></i><input type="text" value="{{ session('nama') }}" readonly></div>
    <div class="topbar-right"><div class="notif"><i class="bi bi-bell"></i></div><a href="{{ route('mahasiswa.profil.index') }}" class="avatar" style="text-decoration:none">{{ strtoupper(substr(session('nama', 'M'), 0, 1)) }}</a></div>
  </div>

  <div class="content">
    <div class="page-header"><h1>Tugas Mahasiswa</h1></div>

    @if($errors->any())
      <div class="alert-error"><i class="bi bi-exclamation-circle-fill"></i>{{ $errors->first() }}</div>
    @endif
    @if(session('success'))
      <div class="alert-success"><i class="bi bi-check-circle-fill"></i>{{ session('success') }}</div>
    @endif

    <div class="tugas-list">
      @forelse($tugasList as $row)
        @php
          $pengumpulan = $row->pengumpulan_mahasiswa;
          $lewat = $row->deadline->isPast();
          $soon = ! $lewat && $row->deadline->diffInDays(now()) < 3;
        @endphp
        <div class="tugas-card">
          <div class="tugas-top">
            <div>
              <span class="badge-mk">{{ $row->mataKuliah->nama_mk ?? $row->id_mk }}</span>
              <div class="tugas-title" style="margin-top:8px">{{ $row->judul }}</div>
            </div>
            @if($pengumpulan)
              <span class="badge-hadir">Sudah dikumpulkan</span>
            @else
              <span class="badge-alfa">Belum dikumpulkan</span>
            @endif
          </div>

          <div class="tugas-desc">{{ $row->deskripsi }}</div>

          <div class="tugas-meta" style="display:grid;gap:12px">
            <div class="meta-item {{ $lewat || $soon ? 'deadline-soon' : '' }}">
              <i class="bi bi-clock{{ $lewat ? '-history' : '' }}"></i>
              Deadline: {{ $row->deadline->format('d M Y, H:i') }}
              {{ $lewat ? ' (Lewat)' : ($soon ? ' (Segera)' : '') }}
            </div>

            @if($pengumpulan)
              <div class="meta-item">
                <i class="bi bi-file-earmark-check"></i>
                {{ basename($pengumpulan->file_tugas) }} - {{ $pengumpulan->tanggal_kumpul?->format('d M Y, H:i') }}
              </div>
              <a href="{{ asset('storage/'.$pengumpulan->file_tugas) }}" class="btn-cancel" style="width:max-content" target="_blank">
                <i class="bi bi-download"></i> Lihat File
              </a>
            @endif

            <form method="POST" action="{{ route('mahasiswa.tugas.store', $row) }}" enctype="multipart/form-data" class="filter-row">
              @csrf
              <input type="file" name="file_tugas" class="filter-select" required>
              <button type="submit" class="btn-filter">
                <i class="bi bi-upload"></i> {{ $pengumpulan ? 'Upload File' : 'Kumpulkan' }}
              </button>
            </form>
          </div>
        </div>
      @empty
        <div class="empty-state"><i class="bi bi-clipboard-x"></i> Belum ada tugas.</div>
      @endforelse
    </div>
  </div>
</div>
</body>
</html>
