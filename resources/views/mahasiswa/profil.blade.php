<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Mahasiswa - SiaCentral</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pengaturan.css') }}">
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon"><i class="bi bi-mortarboard-fill"></i></div>
        <span>SiaCentral</span>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('mahasiswa.dashboard') }}" class="nav-item {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid"></i> Dashboard
        </a>

        <div class="nav-label">Mahasiswa</div>

        <a href="{{ route('mahasiswa.jadwal.index') }}" class="nav-item {{ request()->routeIs('mahasiswa.jadwal.index') ? 'active' : '' }}">
            <i class="bi bi-calendar-event"></i> Jadwal Kuliah
        </a>

        <a href="{{ route('mahasiswa.tugas.index') }}" class="nav-item {{ request()->routeIs('mahasiswa.tugas.index') ? 'active' : '' }}">
            <i class="bi bi-clipboard-check"></i> Tugas
        </a>

        <a href="{{ route('mahasiswa.absensi.index') }}" class="nav-item {{ request()->routeIs('mahasiswa.absensi.index') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i> Absensi
        </a>

        <a href="{{ route('mahasiswa.profil.index') }}" class="nav-item {{ request()->routeIs('mahasiswa.profil.index') ? 'active' : '' }}">
            <i class="bi bi-person"></i> Profil
        </a>

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
        <div class="search-box">
            <i class="bi bi-mortarboard"></i>
            <input type="text" value="{{ $mahasiswa->nim }}" readonly>
        </div>

        <div class="topbar-right">
            <div class="notif">
                <i class="bi bi-bell"></i>
            </div>

            <div class="avatar">
                {{ strtoupper(substr($mahasiswa->nama_mahasiswa, 0, 1)) }}
            </div>
        </div>
    </div>

    <div class="content">
        <div class="page-header">
            <div>
                <h1>Profil Mahasiswa</h1>
                <div style="font-size:13px;color:#6b7280;margin-top:6px">
                    {{ $mahasiswa->nama_mahasiswa }} - {{ $mahasiswa->nim }}
                </div>
            </div>
        </div>

        <div class="table-card" style="margin-bottom:24px">
            <div class="table-card-header">
                <h2>Pengaturan Profil</h2>
            </div>

            <div style="padding: 20px 24px;">

                @if(session('success'))
                    <div class="alert alert-success" role="alert" style="border-radius:12px">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger" role="alert" style="border-radius:12px">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('mahasiswa.profil.update') }}">
                    @csrf

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label" style="font-size:13px;font-weight:800;color:#1e3a5f">NIM</label>
                            <input type="text" class="form-control" value="{{ $mahasiswa->nim }}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="font-size:13px;font-weight:800;color:#1e3a5f">Nama Mahasiswa</label>
                            <input type="text" name="nama_mahasiswa" class="form-control" value="{{ old('nama_mahasiswa', $mahasiswa->nama_mahasiswa) }}" required>
                            @error('nama_mahasiswa')
                                <div class="text-danger" style="font-size:12.5px;margin-top:6px">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="font-size:13px;font-weight:800;color:#1e3a5f">Username</label>
                            <input type="text" name="username" class="form-control" value="{{ old('username', $mahasiswa->username) }}" required>
                            @error('username')
                                <div class="text-danger" style="font-size:12.5px;margin-top:6px">{{ $message }}</div>
                            @enderror
                            <div class="form-text" style="font-size:12.5px;color:#6b7280">
                                Username hanya untuk informasi profil (login mahasiswa memakai <b>nama_mahasiswa</b>).
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="font-size:13px;font-weight:800;color:#1e3a5f">Password (opsional)</label>
                            <input type="password" name="password_baru" class="form-control" placeholder="Kosongkan jika tidak ingin ganti password">
                            @error('password_baru')
                                <div class="text-danger" style="font-size:12.5px;margin-top:6px">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" style="font-size:13px;font-weight:800;color:#1e3a5f">Konfirmasi Password</label>
                            <input type="password" name="password_konfirmasi" class="form-control" placeholder="Ulangi password baru">
                            @error('password_konfirmasi')
                                <div class="text-danger" style="font-size:12.5px;margin-top:6px">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div style="display:flex;justify-content:flex-end;gap:12px;margin-top:18px">
                        <a href="{{ route('mahasiswa.dashboard') }}" class="btn-add" style="background:#f3f4f6;color:#111827;text-decoration:none">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn-add">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-card">
            <div class="table-card-header">
                <h2>📚 Mata Kuliah yang Diambil</h2>
            </div>

            <div style="padding: 20px 24px;">
                @if($jadwalKuliah->isEmpty())
                    <div style="text-align:center;color:#9ca3af;padding:20px 0;">
                        <i class="bi bi-inbox" style="font-size:24px"></i>
                        <div style="margin-top:8px;font-weight:700">Belum ada mata kuliah</div>
                    </div>
                @else
                    @php
                        $mataKuliahUnik = $jadwalKuliah
                            ->pluck('mataKuliah.nama_mk')
                            ->filter()
                            ->unique()
                            ->values();
                    @endphp

                    <div style="display:flex;flex-wrap:wrap;gap:10px;">
                        @foreach($mataKuliahUnik as $namaMk)
                            <span class="badge-mhs" style="font-size:12px;">{{ $namaMk }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

</body>
</html>

