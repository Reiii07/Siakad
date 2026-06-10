<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Mata Kuliah - Siakad App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/dosen.css') }}">
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
        <a href="{{ route('admin.mata-kuliah.index') }}" class="nav-item active"><i class="bi bi-book"></i> Mata Kuliah</a>
      </div>
    </div>
    <a href="{{ route('admin.absensi.index') }}" class="nav-item"><i class="bi bi-calendar-check"></i> Absensi</a>
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
    <div class="page-header"><h1>Mata Kuliah</h1></div>

    <div class="grid-layout">
      <div class="table-card">
        <div class="table-card-header"><h2>Daftar Mata Kuliah</h2></div>
        <table>
          <thead><tr><th>ID MK</th><th>Nama Mata Kuliah</th><th>Dosen</th><th>Aksi</th></tr></thead>
          <tbody>
          @forelse($mataKuliahList as $row)
            <tr>
              <td><span class="badge-dosen">{{ $row->id_mk }}</span></td>
              <td>{{ $row->nama_mk }}</td>
              <td>{{ $row->dosen->nama_dosen ?? '-' }}</td>
              <td>
                <a href="{{ route('admin.mata-kuliah.index', ['edit' => $row->id_mk]) }}" class="action-btn edit"><i class="bi bi-pencil-square"></i></a>
                <form action="{{ route('admin.mata-kuliah.destroy', $row) }}" method="POST" class="delete-form" onsubmit="return confirm('Hapus mata kuliah ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="action-btn del"><i class="bi bi-trash"></i></button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="4" class="empty-state">Belum ada data mata kuliah.</td></tr>
          @endforelse
          </tbody>
        </table>
      </div>

      <div class="form-card">
        <div class="form-card-header">
          <div class="icon"><i class="bi bi-book"></i></div>
          <h2>{{ $editData ? 'Edit Mata Kuliah' : 'Tambah Mata Kuliah' }}</h2>
        </div>

        <form method="POST" action="{{ $editData ? route('admin.mata-kuliah.update', $editData) : route('admin.mata-kuliah.store') }}">
          @csrf
          @if($editData)
            @method('PUT')
          @endif

          <div class="form-card-body">
            @if($errors->any())
              <div class="alert-error"><i class="bi bi-exclamation-circle-fill"></i>{{ $errors->first() }}</div>
            @endif
            @if(session('success'))
              <div class="alert-success"><i class="bi bi-check-circle-fill"></i>{{ session('success') }}</div>
            @endif

            <div class="form-group">
              <label>ID Mata Kuliah <span>*</span></label>
              <div class="input-wrap"><i class="bi bi-hash"></i><input type="text" name="id_mk" class="form-control-custom" value="{{ old('id_mk', $editData->id_mk ?? '') }}" placeholder="MK001" required></div>
            </div>

            <div class="form-group">
              <label>Nama Mata Kuliah <span>*</span></label>
              <div class="input-wrap"><i class="bi bi-book"></i><input type="text" name="nama_mk" class="form-control-custom" value="{{ old('nama_mk', $editData->nama_mk ?? '') }}" required></div>
            </div>

            <div class="form-group">
              <label>Dosen Pengampu <span>*</span></label>
              <select name="nip_dosen" class="form-control-custom" required>
                <option value="">-- Pilih Dosen --</option>
                @foreach($dosenList as $dosen)
                  <option value="{{ $dosen->nip }}" @selected(old('nip_dosen', $editData->nip_dosen ?? '') === $dosen->nip)>{{ $dosen->nama_dosen }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-footer">
            @if($editData)
              <a href="{{ route('admin.mata-kuliah.index') }}" class="btn-cancel">Batal</a>
            @endif
            <button type="submit" class="btn-save"><i class="bi bi-check-lg"></i>{{ $editData ? 'Simpan' : 'Tambah' }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>
