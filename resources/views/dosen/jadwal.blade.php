<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Jadwal Mengajar - Siakad App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
<aside class="sidebar">
  <a href="{{ route('dosen.dashboard') }}" class="sidebar-logo"><div class="logo-icon">S</div><span>Siakad App</span></a>
  <nav class="sidebar-nav">
    <a href="{{ route('dosen.dashboard') }}" class="nav-item"><i class="bi bi-grid"></i> Dashboard</a>
    <div class="nav-label">Dosen</div>
    <a href="{{ route('dosen.jadwal.index') }}" class="nav-item active"><i class="bi bi-calendar-event"></i> Jadwal Mengajar</a>
    <a href="{{ route('dosen.tugas.index') }}" class="nav-item"><i class="bi bi-clipboard-check"></i> Tugas</a>
    <a href="{{ route('dosen.absensi.index') }}" class="nav-item"><i class="bi bi-calendar-check"></i> Absensi</a>
    <form method="POST" action="{{ route('logout') }}" style="margin-top:14px">
      @csrf
      <button type="submit" class="nav-item" style="width:100%;border:0;background:transparent"><i class="bi bi-box-arrow-left"></i> Logout</button>
    </form>
  </nav>
</aside>

<div class="main">
  <div class="topbar">
    <div class="search-box"><i class="bi bi-person-badge"></i><input type="text" value="{{ $dosen->nip }}" readonly></div>
    <div class="topbar-right"><div class="avatar">{{ strtoupper(substr($dosen->nama_dosen, 0, 1)) }}</div></div>
  </div>

  <div class="content">
    <div class="page-header">
      <div>
        <h1>Jadwal Mengajar</h1>
        <div style="font-size:13px;color:#6b7280;margin-top:6px">{{ $dosen->nama_dosen }} - {{ $mataKuliahList->count() }} mata kuliah</div>
      </div>
    </div>

    <div class="table-card">
      <div class="table-card-header"><h2>Daftar Jadwal</h2></div>
      <table>
        <thead>
        <tr><th>Hari</th><th>Waktu</th><th>Mata Kuliah</th><th>Ruangan</th></tr>
        </thead>
        <tbody>
        @forelse($jadwalKuliah as $jadwal)
          <tr>
            <td><strong>{{ $jadwal->hari }}</strong></td>
            <td>{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
            <td>{{ $jadwal->mataKuliah->nama_mk ?? $jadwal->id_mk }}</td>
            <td><span class="badge-mhs">{{ $jadwal->ruangan }}</span></td>
          </tr>
        @empty
          <tr><td colspan="4" style="text-align:center">Belum ada jadwal mengajar.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
