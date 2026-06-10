<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Absensi - Siakad App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/absensi.css') }}">
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
    <a href="{{ route('admin.absensi.index') }}" class="nav-item active"><i class="bi bi-calendar-check"></i> Absensi</a>
    <a href="{{ route('admin.tugas.index') }}" class="nav-item"><i class="bi bi-clipboard-check"></i> Tugas</a>
    <a href="{{ route('admin.pengaturan.index') }}" class="nav-item"><i class="bi bi-gear"></i> Pengaturan</a>
  </nav>
</aside>

<div class="main">
  <div class="topbar">
    <div class="search-box"><i class="bi bi-search"></i><input type="text" placeholder="Search..."></div>
    <div class="topbar-right"><div class="notif"><i class="bi bi-bell"></i></div><div class="avatar">{{ strtoupper(substr(session('nama', 'Admin'), 0, 1)) }}</div></div>
  </div>

  <div class="content">
    <div class="page-header"><h1>Absensi</h1></div>

    <div class="grid-layout">
      <div class="table-card">
        <div class="table-card-header">
          <h2>Rekap Absensi</h2>
          <form method="GET" action="{{ route('admin.absensi.index') }}" class="filter-row">
            <select name="filter_mk" class="filter-select">
              <option value="">Semua MK</option>
              @foreach($mataKuliahList as $mataKuliah)
                <option value="{{ $mataKuliah->id_mk }}" @selected(request('filter_mk') === $mataKuliah->id_mk)>{{ $mataKuliah->nama_mk }}</option>
              @endforeach
            </select>
            <input type="date" name="filter_tgl" class="filter-select" value="{{ request('filter_tgl') }}">
            <button type="submit" class="btn-filter">Filter</button>
            <a href="{{ route('admin.absensi.index') }}" class="btn-reset">Reset</a>
          </form>
        </div>

        <table>
          <thead><tr><th>Tanggal</th><th>Mahasiswa</th><th>Mata Kuliah</th><th>Status</th><th>Aksi</th></tr></thead>
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
              <td>{{ $row->mahasiswa->nama_mahasiswa ?? '-' }}</td>
              <td>{{ $row->mataKuliah->nama_mk ?? '-' }}</td>
              <td><span class="badge-{{ $badge }}">{{ $row->status }}</span></td>
              <td>
                <form action="{{ route('admin.absensi.destroy', $row) }}" method="POST" class="delete-form" onsubmit="return confirm('Hapus data absensi ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="action-btn del"><i class="bi bi-trash"></i></button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="empty-state">Belum ada data absensi.</td></tr>
          @endforelse
          </tbody>
        </table>
      </div>

      <div class="form-card">
        <div class="form-card-header">
          <div class="icon"><i class="bi bi-calendar-plus"></i></div>
          <h2>Catat Absensi</h2>
        </div>

        <form method="POST" action="{{ route('admin.absensi.store') }}">
          @csrf
          <div class="form-card-body">
            @if($errors->any())
              <div class="alert-error"><i class="bi bi-exclamation-circle-fill"></i>{{ $errors->first() }}</div>
            @endif
            @if(session('success'))
              <div class="alert-success"><i class="bi bi-check-circle-fill"></i>{{ session('success') }}</div>
            @endif

            <div class="form-group">
              <label>Mata Kuliah <span>*</span></label>
              <select name="id_mk" class="form-control-custom" required>
                <option value="">-- Pilih Mata Kuliah --</option>
                @foreach($mataKuliahList as $mataKuliah)
                  <option value="{{ $mataKuliah->id_mk }}" @selected(old('id_mk') === $mataKuliah->id_mk)>{{ $mataKuliah->nama_mk }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>Mahasiswa <span>*</span></label>
              <select name="nim" class="form-control-custom" required>
                <option value="">-- Pilih Mahasiswa --</option>
                @foreach($mahasiswaList as $mahasiswa)
                  <option value="{{ $mahasiswa->nim }}" @selected(old('nim') === $mahasiswa->nim)>{{ $mahasiswa->nama_mahasiswa }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>Tanggal <span>*</span></label>
              <div class="input-wrap"><i class="bi bi-calendar3"></i><input type="date" name="tanggal" class="form-control-custom" value="{{ old('tanggal', now()->format('Y-m-d')) }}" required></div>
            </div>

            <div class="form-group">
              <label>Status <span>*</span></label>
              <select name="status" class="form-control-custom" required>
                @foreach(['Hadir', 'Sakit', 'Izin', 'Alfa'] as $status)
                  <option value="{{ $status }}" @selected(old('status', 'Hadir') === $status)>{{ $status }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-footer">
            <button type="submit" class="btn-save"><i class="bi bi-check-lg"></i> Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>
