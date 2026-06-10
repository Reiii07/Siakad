<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Siakad App - Dashboard</title>

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
        <a href="{{ route('admin.dashboard') }}" class="nav-item active">
            <i class="bi bi-grid"></i> Dashboard
        </a>

        <div class="nav-label">Akademik</div>

        <div>
            <div class="nav-item"
                 onclick="this.nextElementSibling.style.display = this.nextElementSibling.style.display === 'block' ? 'none' : 'block'">
                <i class="bi bi-mortarboard"></i>
                Akademik
                <i class="bi bi-chevron-down ms-auto" style="font-size:11px"></i>
            </div>

            <div class="nav-sub" style="display:block">
                <a href="{{ route('admin.dashboard') }}" class="nav-item">
                    <i class="bi bi-people"></i> Mahasiswa
                </a>

                <a href="{{ route('admin.dosen.index') }}" class="nav-item">
                    <i class="bi bi-person-badge"></i> Dosen
                </a>

                <a href="{{ route('admin.mata-kuliah.index') }}" class="nav-item">
                    <i class="bi bi-book"></i> Mata Kuliah
                </a>
            </div>
        </div>

        <a href="{{ route('admin.absensi.index') }}" class="nav-item">
            <i class="bi bi-calendar-check"></i> Absensi
        </a>

        <a href="{{ route('admin.tugas.index') }}" class="nav-item">
            <i class="bi bi-clipboard-check"></i> Tugas
        </a>

        <a href="{{ route('admin.pengaturan.index') }}" class="nav-item">
            <i class="bi bi-gear"></i> Pengaturan
        </a>
    </nav>
</aside>

<div class="main">

    <div class="topbar">
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Search...">
        </div>

        <div class="topbar-right">
            <div class="notif">
                <i class="bi bi-bell"></i>
            </div>

            <div class="avatar">
                {{ strtoupper(substr(session('nama', 'Admin'), 0, 1)) }}
            </div>
        </div>
    </div>

    <div class="content">

        <div class="page-header">
            <h1>Dashboard</h1>

            <a href="{{ route('admin.mahasiswa.create') }}" class="btn-add">
                <i class="bi bi-plus-lg"></i>
                Tambah Mahasiswa
            </a>
        </div>

        <div class="stats">

            <div class="stat-card">
                <div class="label">Total Mahasiswa</div>
                <div class="value">{{ $total_mhs }}</div>
                <div class="sub">Terdaftar di sistem</div>
            </div>

            <div class="stat-card">
                <div class="label">Total Dosen</div>
                <div class="value">{{ $total_dosen }}</div>
                <div class="sub">Aktif mengajar</div>
            </div>

            <div class="stat-card">
                <div class="label">Mata Kuliah</div>
                <div class="value">{{ $total_mk }}</div>
                <div class="sub">Semester ini</div>
            </div>

            <div class="stat-card" style="flex:1.5">
                <div class="search-inline" style="width:100%">
                    <i class="bi bi-search"></i>
                    <input
                        type="text"
                        placeholder="Cari nama mahasiswa..."
                        id="searchMhs"
                        onkeyup="filterTable()">
                </div>
            </div>

        </div>

        <div class="table-card">

            <div class="table-card-header">
                <h2>Daftar Mahasiswa</h2>
            </div>

            <table id="mhsTable">
                <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
                </thead>

                <tbody>
                @foreach($mahasiswa as $row)
                    <tr>
                        <td>{{ $row->nim }}</td>

                        <td>
                            <div class="name-cell">
                                <div class="avatar-sm">
                                    {{ strtoupper(substr($row->nama_mahasiswa, 0, 1)) }}
                                </div>

                                {{ $row->nama_mahasiswa }}
                            </div>
                        </td>

                        <td>{{ $row->username }}</td>

                        <td>
                            <span class="badge-mhs">
                                Mahasiswa
                            </span>
                        </td>

                        <td>
                            <a href="#" class="action-btn edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <a href="#" class="action-btn del">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

            <div class="table-footer">
                <span>
                    Menampilkan {{ $total_mhs }} data mahasiswa
                </span>
            </div>

        </div>

    </div>

</div>

<script>
function filterTable() {
    const input = document.getElementById('searchMhs').value.toLowerCase();
    const rows = document.querySelectorAll('#mhsTable tbody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(input) ? '' : 'none';
    });
}
</script>

</body>
</html>
