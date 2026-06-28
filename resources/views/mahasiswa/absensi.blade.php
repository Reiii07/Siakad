<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Absensi Mahasiswa - Siakad App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/absensi.css') }}">
</head>
<body>
<aside class="sidebar">
  <div class="sidebar-logo"><div class="logo-icon">S</div><span>Siakad App</span></div>
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
    <div class="page-header"><h1>Absensi Mahasiswa</h1></div>

    <div class="stats">
      <div class="stat-card"><div class="label">Hadir</div><div class="value">{{ $rekap['Hadir'] }}</div><div class="sub">Total kehadiran</div></div>
      <div class="stat-card"><div class="label">Sakit</div><div class="value">{{ $rekap['Sakit'] }}</div><div class="sub">Tercatat sakit</div></div>
      <div class="stat-card"><div class="label">Izin</div><div class="value">{{ $rekap['Izin'] }}</div><div class="sub">Tercatat izin</div></div>
      <div class="stat-card"><div class="label">Alfa</div><div class="value">{{ $rekap['Alfa'] }}</div><div class="sub">Tanpa keterangan</div></div>
    </div>

    <div class="table-card">
      <div class="table-card-header">
        <h2>Riwayat Absensi</h2>
        <form method="GET" action="{{ route('mahasiswa.absensi.index') }}" class="filter-row">
          <select name="filter_mk" class="filter-select">
            <option value="">Semua MK</option>
            @foreach($mataKuliahList as $mataKuliah)
              <option value="{{ $mataKuliah->id_mk }}" @selected(request('filter_mk') === $mataKuliah->id_mk)>{{ $mataKuliah->nama_mk }}</option>
            @endforeach
          </select>
          <input type="date" name="filter_tgl" class="filter-select" value="{{ request('filter_tgl') }}">
          <button type="submit" class="btn-filter">Filter</button>
          <a href="{{ route('mahasiswa.absensi.index') }}" class="btn-reset">Reset</a>
        </form>
      </div>

      <table>
        <thead>
        <tr>
          <th>Tanggal</th>
          <th>Mata Kuliah</th>
          <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @forelse($absensiList as $row)
          @php
            $badge = match ($row->status) {
              'Hadir' => 'hadir',
              'Sakit' => 'sakit',
              'Alfa' => 'alfa',
              default => 'izin',
            };
          @endphp
          <tr>
            <td>{{ $row->tanggal->format('d/m/Y') }}</td>
            <td>{{ $row->mataKuliah->nama_mk ?? '-' }}</td>
            <td><span class="badge-{{ $badge }}">{{ $row->status }}</span></td>
          </tr>
        @empty
          <tr><td colspan="3" class="empty-state">Belum ada data absensi.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
