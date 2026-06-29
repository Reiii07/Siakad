<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Jadwal Kuliah - SiaCentral</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/dosen.css') }}">
</head>
<body id="top">
<aside class="sidebar">
  <a href="{{ route('admin.dashboard') }}" class="sidebar-logo"><div class="logo-icon"><i class="bi bi-mortarboard-fill"></i></div><span>SiaCentral</span></a>
  <nav class="sidebar-nav">
    <a href="{{ route('admin.dashboard') }}" class="nav-item"><i class="bi bi-grid"></i> Dashboard</a>
    <div class="nav-label">Akademik</div>
    <div>
      <div class="nav-item"><i class="bi bi-mortarboard"></i> Akademik <i class="bi bi-chevron-down ms-auto" style="font-size:11px"></i></div>
      <div class="nav-sub" style="display:block">
        <a href="{{ route('admin.dashboard') }}" class="nav-item"><i class="bi bi-people"></i> Mahasiswa</a>
        <a href="{{ route('admin.dosen.index') }}" class="nav-item"><i class="bi bi-person-badge"></i> Dosen</a>
        <a href="{{ route('admin.mata-kuliah.index') }}" class="nav-item"><i class="bi bi-book"></i> Mata Kuliah</a>
        <a href="{{ route('admin.jadwal-kuliah.index') }}" class="nav-item active"><i class="bi bi-calendar-week"></i> Jadwal Kuliah</a>
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
    <div class="page-header"><h1>Jadwal Kuliah</h1></div>

    <div class="grid-layout">
      <div class="table-card">
        <div class="table-card-header">
          <div>
            <h2>Daftar Jadwal</h2>
            <div class="table-subtitle">Jadwal terhubung ke mata kuliah dan dosen pengampu.</div>
          </div>
        </div>
        <table>
          <thead><tr><th>Hari</th><th>Jam</th><th>Mata Kuliah</th><th>Dosen</th><th>Ruangan</th><th>Aksi</th></tr></thead>
          <tbody>
          @forelse($jadwalList as $row)
            <tr>
              <td><span class="badge-dosen">{{ $row->hari }}</span></td>
              <td>{{ \Carbon\Carbon::parse($row->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($row->jam_selesai)->format('H:i') }}</td>
              <td>{{ $row->mataKuliah->nama_mk ?? '-' }}</td>
              <td>
                <div class="name-cell">
                  <div class="avatar-sm">{{ strtoupper(substr($row->dosen->nama_dosen ?? 'D', 0, 1)) }}</div>
                  <div>
                    <div>{{ $row->dosen->nama_dosen ?? '-' }}</div>
                    <div class="muted-text">{{ $row->nip_dosen }}</div>
                  </div>
                </div>
              </td>
              <td>{{ $row->ruangan }}</td>
              <td>
                <a href="{{ route('admin.jadwal-kuliah.index', ['edit' => $row->id_jadwal]) }}" class="action-btn edit"><i class="bi bi-pencil-square"></i></a>
                <form action="{{ route('admin.jadwal-kuliah.destroy', $row) }}" method="POST" class="delete-form" onsubmit="return confirm('Hapus jadwal kuliah ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="action-btn del"><i class="bi bi-trash"></i></button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="6" class="empty-state">Belum ada jadwal kuliah.</td></tr>
          @endforelse
          </tbody>
        </table>
      </div>

      <div class="form-card">
        <div class="form-card-header">
          <div class="icon"><i class="bi bi-calendar-plus"></i></div>
          <h2>{{ $editData ? 'Edit Jadwal' : 'Tambah Jadwal' }}</h2>
        </div>

        <form method="POST" action="{{ $editData ? route('admin.jadwal-kuliah.update', $editData) : route('admin.jadwal-kuliah.store') }}">
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
              <label>Dosen <span>*</span></label>
              <select name="nip_dosen" id="nipDosen" class="form-control-custom" required>
                <option value="">Pilih Dosen</option>
                @foreach($dosenList as $dosen)
                  <option value="{{ $dosen->nip }}" @selected(old('nip_dosen', $editData->nip_dosen ?? '') === $dosen->nip)>{{ $dosen->nama_dosen }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>Mata Kuliah <span>*</span></label>
              <select name="id_mk" id="idMk" class="form-control-custom" required>
                <option value="">Pilih Mata Kuliah</option>
                @foreach($mataKuliahList as $mataKuliah)
                  <option value="{{ $mataKuliah->id_mk }}" data-dosen="{{ $mataKuliah->nip_dosen }}" @selected(old('id_mk', $editData->id_mk ?? '') === $mataKuliah->id_mk)>
                    {{ $mataKuliah->nama_mk }}
                  </option>
                @endforeach
              </select>
              <div class="field-hint">Pilihan mata kuliah akan mengikuti dosen yang dipilih.</div>
            </div>

            <div class="form-group">
              <label>Hari <span>*</span></label>
              <select name="hari" class="form-control-custom" required>
                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                  <option value="{{ $hari }}" @selected(old('hari', $editData->hari ?? 'Senin') === $hari)>{{ $hari }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>Jam Mulai <span>*</span></label>
              <div class="input-wrap"><i class="bi bi-clock"></i><input type="time" name="jam_mulai" class="form-control-custom" value="{{ old('jam_mulai', $editData ? \Carbon\Carbon::parse($editData->jam_mulai)->format('H:i') : '') }}" required></div>
            </div>

            <div class="form-group">
              <label>Jam Selesai <span>*</span></label>
              <div class="input-wrap"><i class="bi bi-clock-history"></i><input type="time" name="jam_selesai" class="form-control-custom" value="{{ old('jam_selesai', $editData ? \Carbon\Carbon::parse($editData->jam_selesai)->format('H:i') : '') }}" required></div>
            </div>

            <div class="form-group">
              <label>Ruangan <span>*</span></label>
              <select name="ruangan" class="form-control-custom" required>
                <option value="">Pilih Ruangan</option>
                @foreach($ruanganList as $ruangan)
                  <option value="{{ $ruangan }}" @selected(old('ruangan', $editData->ruangan ?? '') === $ruangan)>
                    {{ $ruangan }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-footer">
            @if($editData)
              <a href="{{ route('admin.jadwal-kuliah.index') }}" class="btn-cancel">Batal</a>
            @endif
            <button type="submit" class="btn-save"><i class="bi bi-check-lg"></i>{{ $editData ? 'Simpan' : 'Tambah' }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="{{ asset('js/admin-topbar.js') }}"></script>
<script>
function filterMataKuliah() {
  const nipDosen = document.getElementById('nipDosen').value;
  const selectMk = document.getElementById('idMk');

  Array.from(selectMk.options).forEach(option => {
    if (!option.value) {
      option.hidden = false;
      return;
    }

    const visible = !nipDosen || option.dataset.dosen === nipDosen;
    option.hidden = !visible;

    if (!visible && option.selected) {
      selectMk.value = '';
    }
  });
}

document.getElementById('nipDosen').addEventListener('change', filterMataKuliah);
filterMataKuliah();
</script>
</body>
</html>
