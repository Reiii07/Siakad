<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tugas Dosen - Siakad App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/tugas.css') }}">
</head>
<body id="top">
<aside class="sidebar">
  <a href="{{ route('dosen.dashboard') }}" class="sidebar-logo"><div class="logo-icon">S</div><span>Siakad App</span></a>
  <nav class="sidebar-nav">
    <a href="{{ route('dosen.dashboard') }}" class="nav-item"><i class="bi bi-grid"></i> Dashboard</a>
    <div class="nav-label">Dosen</div>
    <a href="{{ route('dosen.jadwal.index') }}" class="nav-item"><i class="bi bi-calendar-event"></i> Jadwal Mengajar</a>
    <a href="{{ route('dosen.tugas.index') }}" class="nav-item active"><i class="bi bi-clipboard-check"></i> Tugas</a>
    <a href="{{ route('dosen.absensi.index') }}" class="nav-item"><i class="bi bi-calendar-check"></i> Absensi</a>
    <form method="POST" action="{{ route('logout') }}" style="margin-top:14px">@csrf<button type="submit" class="nav-item" style="width:100%;border:0;background:transparent"><i class="bi bi-box-arrow-left"></i> Logout</button></form>
  </nav>
</aside>

<div class="main">
  <div class="topbar">
    <div class="search-box"><i class="bi bi-person-badge"></i><input type="text" value="{{ $dosen->nip }}" readonly></div>
    <div class="topbar-right"><div class="avatar">{{ strtoupper(substr($dosen->nama_dosen, 0, 1)) }}</div></div>
  </div>

  <div class="content">
    <div class="page-header"><h1>Tugas</h1></div>

    <div class="grid-layout">
      <div class="tugas-list">
        @forelse($tugasList as $row)
          @php
            $lewat = $row->deadline->isPast();
            $soon = ! $lewat && $row->deadline->diffInDays(now()) < 3;
          @endphp
          <div class="tugas-card">
            <div class="tugas-top">
              <div>
                <span class="badge-mk">{{ $row->mataKuliah->nama_mk ?? $row->id_mk }}</span>
                <div class="tugas-title" style="margin-top:8px">{{ $row->judul }}</div>
              </div>
              <div class="tugas-actions">
                <a href="{{ route('dosen.tugas.index', ['edit' => $row->id_tugas]) }}" class="action-btn edit"><i class="bi bi-pencil-square"></i></a>
                <form action="{{ route('dosen.tugas.destroy', $row) }}" method="POST" class="delete-form" onsubmit="return confirm('Hapus tugas ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="action-btn del"><i class="bi bi-trash"></i></button>
                </form>
              </div>
            </div>
            <div class="tugas-desc">{{ $row->deskripsi }}</div>
            <div class="tugas-meta">
              <div class="meta-item {{ $lewat || $soon ? 'deadline-soon' : '' }}">
                <i class="bi bi-clock{{ $lewat ? '-history' : '' }}"></i>
                Deadline: {{ $row->deadline->format('d M Y, H:i') }}
                {{ $lewat ? ' (Lewat)' : ($soon ? ' (Segera)' : '') }}
              </div>
              <div class="meta-item" style="margin-top:8px">
                <i class="bi bi-upload"></i>
                {{ $row->pengumpulan_count }} pengumpulan
              </div>
            </div>
          </div>
        @empty
          <div class="empty-state"><i class="bi bi-clipboard-x"></i>Belum ada tugas</div>
        @endforelse
      </div>

      <div class="form-card">
        <div class="form-card-header">
          <div class="icon"><i class="bi bi-clipboard-plus"></i></div>
          <h2>{{ $editData ? 'Edit Tugas' : 'Tambah Tugas' }}</h2>
        </div>

        <form method="POST" action="{{ $editData ? route('dosen.tugas.update', $editData) : route('dosen.tugas.store') }}">
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
              <label>Mata Kuliah <span>*</span></label>
              <select name="id_mk" class="form-control-custom" required>
                <option value="">-- Pilih Mata Kuliah --</option>
                @foreach($mataKuliahList as $mataKuliah)
                  <option value="{{ $mataKuliah->id_mk }}" @selected(old('id_mk', $editData->id_mk ?? '') === $mataKuliah->id_mk)>{{ $mataKuliah->nama_mk }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>Judul Tugas <span>*</span></label>
              <div class="input-wrap"><i class="bi bi-pencil"></i><input type="text" name="judul" class="form-control-custom" value="{{ old('judul', $editData->judul ?? '') }}" required></div>
            </div>

            <div class="form-group">
              <label>Deskripsi</label>
              <textarea name="deskripsi" class="form-control-custom textarea-custom">{{ old('deskripsi', $editData->deskripsi ?? '') }}</textarea>
            </div>

            <div class="form-group">
              <label>Deadline <span>*</span></label>
              <div class="input-wrap"><i class="bi bi-calendar3"></i><input type="datetime-local" name="deadline" class="form-control-custom" value="{{ old('deadline', $editData?->deadline?->format('Y-m-d\TH:i') ?? '') }}" required></div>
            </div>
          </div>

          <div class="form-footer">
            @if($editData)
              <a href="{{ route('dosen.tugas.index') }}" class="btn-cancel">Batal</a>
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
