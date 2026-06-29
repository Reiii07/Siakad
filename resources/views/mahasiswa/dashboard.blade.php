<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Mahasiswa - SiaCentral</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jadwal.css') }}">
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon"><i class="bi bi-mortarboard-fill"></i></div>
        <span>SiaCentral</span>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('mahasiswa.dashboard') }}" class="nav-item active">
            <i class="bi bi-grid"></i> Dashboard
        </a>

        <div class="nav-label">Mahasiswa</div>

        <a href="{{ route('mahasiswa.jadwal.index') }}" class="nav-item {{ request()->routeIs('mahasiswa.jadwal.index') ? 'active' : '' }}">
        <i class="bi bi-calendar-event"></i> Jadwal Kuliah
        </a>


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

            {{-- Klik avatar: pilih Edit Profil atau Keluar --}}
            <button type="button" class="avatar" onclick="document.getElementById('accountConfirm').style.display='block'">
                {{ strtoupper(substr($mahasiswa->nama_mahasiswa, 0, 1)) }}
            </button>

            <div id="accountConfirm" style="display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,.4);z-index:9999;">
                <div style="max-width:420px;margin:12vh auto;background:#fff;border-radius:14px;padding:18px 18px;box-shadow:0 10px 30px rgba(0,0,0,.2)">
                    <div style="font-weight:800;font-size:16px">Akun</div>
                    <div style="color:#6b7280;font-size:13px;margin-top:6px">Pilih tindakan untuk akun Anda</div>

                    <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:16px">
                        <a href="{{ route('mahasiswa.profil.index') }}" class="btn-add" style="text-decoration:none;display:inline-flex;align-items:center;gap:8px;background:#111827;color:#fff;border-radius:10px;padding:10px 14px">
                            <i class="bi bi-pencil-square"></i> Edit Profil
                        </a>

                        <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Anda yakin ingin log out?')" style="margin:0">
                            @csrf
                            <button type="submit" class="btn-add" style="background:#fff;color:#111827;border:1px solid #e5e7eb;border-radius:10px;padding:10px 14px;display:inline-flex;align-items:center;gap:8px">
                                <i class="bi bi-box-arrow-left"></i> Log out
                            </button>
                        </form>

                        <button type="button" class="btn-add" onclick="document.getElementById('accountConfirm').style.display='none'" style="background:#f3f4f6;color:#111827;border-radius:10px;padding:10px 14px;border:0;display:inline-flex;align-items:center;gap:8px">
                            Batal
                        </button>
                    </div>
                </div>
            </div>

            {{-- pastikan profil aktif di menu sidebar --}}
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

        <div class="table-card" id="jadwal" style="margin-bottom:24px">
            <div class="table-card-header">
                <h2>📅 Jadwal Perkuliahan</h2>
            </div>

            @if($jadwalKuliah->isEmpty())
            <div class="no-schedule">
                <i class="bi bi-calendar-x"></i>
                <p>Jadwal perkuliahan belum tersedia</p>
            </div>
            @else
            @php
                $hariOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                $jadwalByDay = $jadwalKuliah->groupBy('hari')->sortBy(fn($group, $key) => array_search($key, $hariOrder));
            @endphp

            <div class="schedule-days-grid">
                @foreach($jadwalByDay as $hari => $jadwalHari)
                <div class="schedule-day-group">
                    <div class="schedule-day-title">
                        <i class="bi bi-calendar-event"></i> {{ $hari }}
                    </div>
                    <div class="schedule-day-cards">
                        @foreach($jadwalHari as $jadwal)
                        <div class="schedule-card {{ strtolower($hari) }}">
                            <div class="schedule-time">
                                <i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                            </div>
                            <div class="schedule-subject">{{ $jadwal->mataKuliah->nama_mk ?? '-' }}</div>
                            <div class="schedule-lecturer">
                                <i class="bi bi-person-fill"></i> {{ $jadwal->mataKuliah->dosen->nama_dosen ?? '-' }}
                            </div>
                            <div class="schedule-room">
                                <i class="bi bi-door-closed"></i> {{ $jadwal->ruangan }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Tugas dan Absensi Side by Side -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
            <!-- Tugas -->
            <div class="table-card" id="tugas">
                <div class="table-card-header">
                    <h2>📋 Daftar Tugas</h2>
                </div>

                <table>
                    <thead>
                    <tr>
                        <th>Mata Kuliah</th>
                        <th>Judul</th>
                        <th>Status</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($tugas as $row)
                        <tr>
                            <td style="font-size: 12px;">{{ $row->mataKuliah->nama_mk ?? $row->id_mk }}</td>
                            <td style="font-size: 12px;">{{ $row->judul }}</td>
                            <td>
                                @if($row->pengumpulan_mahasiswa)
                                    <span class="badge-mhs" style="font-size: 11px;">✓ Dikumpulkan</span>
                                @else
                                    <span class="badge-mhs" style="background:#fff7ed;color:#c2410c;font-size: 11px;">⏳ Belum</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center; padding: 20px; color: #999;">
                                <i class="bi bi-inbox"></i> Belum ada tugas
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Absensi -->
            <div class="table-card" id="absensi">
                <div class="table-card-header">
                    <h2>📍 Absensi Terbaru</h2>
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
                            <td style="font-size: 12px;">{{ $row->tanggal?->format('d M Y') }}</td>
                            <td style="font-size: 12px;">{{ $row->mataKuliah->nama_mk ?? $row->id_mk }}</td>
                            <td>
                                <span class="badge-mhs" style="font-size: 11px;">{{ $row->status }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center; padding: 20px; color: #999;">
                                <i class="bi bi-calendar-x"></i> Belum ada absensi
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>