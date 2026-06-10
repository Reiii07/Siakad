<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Mahasiswa - Siakad App</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon">S</div>
        <span>Siakad App</span>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('mahasiswa.dashboard') }}" class="nav-item active">
            <i class="bi bi-grid"></i> Dashboard
        </a>

        <div class="nav-label">Mahasiswa</div>

        <a href="{{ route('mahasiswa.tugas.index') }}" class="nav-item">
            <i class="bi bi-clipboard-check"></i> Tugas
        </a>

        <a href="{{ route('mahasiswa.absensi.index') }}" class="nav-item">
            <i class="bi bi-calendar-check"></i> Absensi
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
                <h1>Dashboard Mahasiswa</h1>
                <div style="font-size:13px;color:#6b7280;margin-top:6px">
                    {{ $mahasiswa->nama_mahasiswa }} - {{ $mahasiswa->nim }}
                </div>
            </div>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="label">Total Absensi</div>
                <div class="value">{{ $totalAbsensi }}</div>
                <div class="sub">Riwayat absensi Anda</div>
            </div>

            <div class="stat-card">
                <div class="label">Hadir</div>
                <div class="value">{{ $totalHadir }}</div>
                <div class="sub">Status hadir tercatat</div>
            </div>

            <div class="stat-card">
                <div class="label">Total Tugas</div>
                <div class="value">{{ $totalTugas }}</div>
                <div class="sub">Tugas tersedia</div>
            </div>

            <div class="stat-card">
                <div class="label">Dikumpulkan</div>
                <div class="value">{{ $totalDikumpulkan }}</div>
                <div class="sub">Tugas sudah dikirim</div>
            </div>
        </div>

        <div class="table-card" id="tugas" style="margin-bottom:24px">
            <div class="table-card-header">
                <h2>Daftar Tugas</h2>
            </div>

            <table>
                <thead>
                <tr>
                    <th>Mata Kuliah</th>
                    <th>Judul</th>
                    <th>Deadline</th>
                    <th>Status</th>
                </tr>
                </thead>

                <tbody>
                @forelse($tugas as $row)
                    <tr>
                        <td>{{ $row->mataKuliah->nama_mk ?? $row->id_mk }}</td>
                        <td>{{ $row->judul }}</td>
                        <td>{{ $row->deadline?->format('d M Y H:i') }}</td>
                        <td>
                            @if($row->pengumpulan_mahasiswa)
                                <span class="badge-mhs">Sudah dikumpulkan</span>
                            @else
                                <span class="badge-mhs" style="background:#fff7ed;color:#c2410c">Belum dikumpulkan</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Belum ada tugas.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-card" id="absensi">
            <div class="table-card-header">
                <h2>Absensi Terbaru</h2>
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
                @forelse($absensiTerbaru as $row)
                    <tr>
                        <td>{{ $row->tanggal?->format('d M Y') }}</td>
                        <td>{{ $row->mataKuliah->nama_mk ?? $row->id_mk }}</td>
                        <td>
                            <span class="badge-mhs">{{ $row->status }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">Belum ada absensi.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
