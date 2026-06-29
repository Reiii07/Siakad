<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Dosen - SiaCentral</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon"><i class="bi bi-mortarboard-fill"></i></div>
        <span>SiaCentral</span>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('dosen.dashboard') }}" class="nav-item active">
            <i class="bi bi-grid"></i> Dashboard
        </a>

        <div class="nav-label">Dosen</div>

        <a href="{{ route('dosen.jadwal.index') }}" class="nav-item">
            <i class="bi bi-calendar-event"></i> Jadwal Mengajar
        </a>

        <a href="{{ route('dosen.tugas.index') }}" class="nav-item">
            <i class="bi bi-clipboard-check"></i> Tugas
        </a>

        <a href="{{ route('dosen.absensi.index') }}" class="nav-item">
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
            <input type="text" value="{{ $dosen->nip ?? '-' }}" readonly>
        </div>

        <div class="topbar-right">
            <div class="notif">
                <i class="bi bi-bell"></i>
            </div>

            <div class="avatar">
                {{ strtoupper(substr($dosen->nama_dosen ?? 'D', 0, 1)) }}
            </div>
        </div>
    </div>

    <div class="content">
        <div class="page-header">
            <div>
                <h1>Dashboard Dosen</h1>
                <div style="font-size:13px;color:#6b7280;margin-top:6px">
                    {{ $dosen->nama_dosen ?? 'N/A' }} - {{ $dosen->nip ?? 'N/A' }}
                </div>
            </div>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="label">Mata Kuliah</div>
                <div class="value">{{ $totalMataKuliah }}</div>
                <div class="sub">Mata kuliah diampu</div>
            </div>

            <div class="stat-card">
                <div class="label">Total Tugas</div>
                <div class="value">{{ $totalTugas }}</div>
                <div class="sub">Tugas diberikan</div>
            </div>

            <div class="stat-card">
                <div class="label">Absensi</div>
                <div class="value">{{ $totalAbsensi }}</div>
                <div class="sub">Total absensi tercatat</div>
            </div>

            <div class="stat-card">
                <div class="label">Jadwal</div>
                <div class="value">{{ count($jadwalKuliah) }}</div>
                <div class="sub">Jadwal mengajar</div>
            </div>
        </div>

        <div class="table-card" id="jadwal" style="margin-bottom:24px">
            <div class="table-card-header">
                <h2>Jadwal Mengajar</h2>
            </div>

            <table>
                <thead>
                <tr>
                    <th>Hari</th>
                    <th>Waktu</th>
                    <th>Mata Kuliah</th>
                    <th>Ruangan</th>
                </tr>
                </thead>
                <tbody>
                @forelse($jadwalKuliah as $jadwal)
                    <tr>
                        <td><strong>{{ $jadwal->hari }}</strong></td>
                        <td>
                            {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - 
                            {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                        </td>
                        <td>{{ $jadwal->mataKuliah->nama_mk ?? '-' }}</td>
                        <td>
                            <span class="badge-mhs">{{ $jadwal->ruangan }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">Belum ada jadwal mengajar yang tersedia.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
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
                            @if($row->deadline->isPast())
                                <span class="badge-mhs" style="background:#fecaca;color:#7f1d1d">Lewat</span>
                            @elseif($row->deadline->diffInDays(now()) < 3)
                                <span class="badge-mhs" style="background:#fed7aa;color:#92400e">Segera</span>
                            @else
                                <span class="badge-mhs" style="background:#dcfce7;color:#15803d">Aktif</span>
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
                    <th>Mahasiswa</th>
                    <th>Status</th>
                </tr>
                </thead>

                <tbody>
                @forelse($absensiTerbaru as $row)
                    <tr>
                        <td>{{ $row->tanggal?->format('d M Y') }}</td>
                        <td>{{ $row->mataKuliah->nama_mk ?? $row->id_mk }}</td>
                        <td>{{ $row->nim }}</td>
                        <td>
                            <span class="badge-mhs">{{ $row->status }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Belum ada absensi.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
