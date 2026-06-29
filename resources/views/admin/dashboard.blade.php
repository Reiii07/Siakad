<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SiaCentral - Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body id="top">

<aside class="sidebar">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
        <div class="logo-icon"><i class="bi bi-mortarboard-fill"></i></div>
        <span>SiaCentral</span>
    </a>

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

                <a href="{{ route('admin.jadwal-kuliah.index') }}" class="nav-item">
                    <i class="bi bi-calendar-week"></i> Jadwal Kuliah
                </a>
            </div>
        </div>

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
            <div class="topbar-menu">
            @include('admin.partials.notifications')
            </div>

            <div class="topbar-menu">
            <button type="button" class="avatar" data-menu-toggle="accountMenu" aria-label="Akun">
                {{ strtoupper(substr(session('nama', 'Admin'), 0, 1)) }}
            </button>
            <div class="dropdown-panel account-panel" id="accountMenu">
                <div class="account-summary">
                    <div class="avatar mini">{{ strtoupper(substr(session('nama', 'Admin'), 0, 1)) }}</div>
                    <div>
                        <div class="account-name">{{ session('nama', 'Admin') }}</div>
                        <div class="account-role">{{ ucfirst(session('role', 'admin')) }}</div>
                    </div>
                </div>
                <a href="{{ route('admin.pengaturan.index') }}" class="dropdown-link">
                    <i class="bi bi-gear"></i> Pengaturan
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-link danger">
                        <i class="bi bi-box-arrow-right"></i> Keluar
                    </button>
                </form>
            </div>
            </div>
        </div>
    </div>

    <div class="content">

        <div class="page-header">
            <h1>Dashboard Admin</h1>

            <div style="display:flex;gap:10px;flex-wrap:wrap">
                <a href="{{ route('admin.mahasiswa.create') }}" class="btn-add">
                    <i class="bi bi-plus-lg"></i>
                    Tambah Mahasiswa
                </a>
                <a href="{{ route('admin.dosen.index') }}" class="btn-add">
                    <i class="bi bi-person-plus"></i>
                    Tambah Dosen
                </a>
                <a href="{{ route('admin.mata-kuliah.index') }}" class="btn-add">
                    <i class="bi bi-journal-plus"></i>
                    Tambah Mata Kuliah
                </a>
                <a href="{{ route('admin.jadwal-kuliah.index') }}" class="btn-add">
                    <i class="bi bi-calendar-plus"></i>
                    Tambah Jadwal
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

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
                            <a href="{{ route('admin.mahasiswa.edit', $row) }}" class="action-btn edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="{{ route('admin.mahasiswa.destroy', $row) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus mahasiswa ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn del" style="background:none;border:0">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
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

<script src="{{ asset('js/admin-topbar.js') }}"></script>
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
