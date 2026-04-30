<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Pengaduan Surakarta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f7fe; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* Sidebar Styling */
        .sidebar {
            background-color: #2c3e50;
            color: white;
            min-height: 100vh;
            width: 260px;
            position: fixed;
        }
        .sidebar .nav-link { color: #bdc3c7; padding: 12px 20px; font-weight: 500; }
        .sidebar .nav-link.active { background-color: #34495e; color: white; border-left: 4px solid #fff; }
        .sidebar .nav-link:hover { color: white; }
        
        /* Main Content */
        .main-content { margin-left: 260px; padding: 30px; }
        
        /* Card Styling */
        .stat-card {
            border: none;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }
        
        /* Table Styling */
        .table-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .badge-pending { background-color: #fff3cd; color: #856404; }
        .badge-proses { background-color: #cfe2ff; color: #084298; }
        .badge-selesai { background-color: #d1e7dd; color: #0f5132; }
    </style>
</head>
<body>

<div class="sidebar d-flex flex-column p-3">
    <h4 class="text-center mb-4"><i class="fa-solid fa-building-columns me-2"></i> Pengaduan</h4>
    <p class="small text-uppercase fw-bold text-secondary px-3">Sistem</p>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="#" class="nav-link active"><i class="fa-solid fa-gauge me-2"></i> Dashboard</a>
        </li>
        <li><a href="{{ route('admin.users.index') }}" class="nav-link"><i class="fa-solid fa-users me-2"></i> Manajemen User</a></li>
        <li><a href="{{ route('admin.pengaduan.index') }}" class="nav-link"><i class="fa-solid fa-file-lines me-2"></i> Laporan</a></li>
        <li><a href="#" class="nav-link"><i class="fa-solid fa-gear me-2"></i> Pengaturan</a></li>
    </ul>
    <hr>
    <div class="dropdown p-2">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
            <img src="https://ui-avatars.com/api/?name=Admin+Diskominfo" width="32" height="32" class="rounded-circle me-2">
            <strong>Admin Diskominfo</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
            <li>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item">Keluar</button>
                </form>
            </li>
        </ul>
    </div>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <div class="me-4">
                <h2 class="mb-0">Selamat Siang, Admin!</h2>
                <p class="text-muted mb-0">Rabu, 01 April 2026</p>
            </div>
            <!-- Tombol Bel Notifikasi -->
            <div class="dropdown">
                <button class="btn btn-light rounded-circle shadow-sm position-relative p-2" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-bell text-primary fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light" style="font-size: 0.6rem;">
                        12
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-0" style="width: 300px; border-radius: 12px; overflow: hidden;">
                    <li class="bg-primary text-white p-3"><h6 class="mb-0">Laporan Baru Masuk</h6></li>
                    <div style="max-height: 300px; overflow-y: auto;">
                        @foreach($pengaduans->where('status', 'Menunggu')->take(5) as $notif)
                        <li>
                            <a class="dropdown-item p-3 border-bottom d-flex align-items-start gap-2" href="{{ route('admin.pengaduan.show', $notif->id) }}">
                                <div class="bg-warning-subtle text-warning p-2 rounded-circle"><i class="fa-solid fa-file-invoice"></i></div>
                                <div class="text-wrap">
                                    <p class="mb-0 fw-bold text-dark" style="font-size: 0.85rem;">{{ $notif->nama_pelapor }}</p>
                                    <small class="text-muted">{{ Str::limit($notif->deskripsi, 50) }}</small>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </div>
                    <li><a class="dropdown-item text-center p-2 small text-primary fw-bold" href="{{ route('admin.pengaduan.index') }}">Lihat Semua Laporan</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card bg-white">
                <div class="icon-box bg-light text-primary"><i class="fa-solid fa-file-invoice fa-lg"></i></div>
                <h3 class="fw-bold">247</h3>
                <p class="text-muted mb-0">Total Pengaduan <span class="text-success small">+8%</span></p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-white">
                <div class="icon-box bg-warning-subtle text-warning"><i class="fa-solid fa-circle-exclamation fa-lg"></i></div>
                <h3 class="fw-bold">12</h3>
                <p class="text-muted mb-0">Pending / Baru</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-white">
                <div class="icon-box bg-info-subtle text-info"><i class="fa-solid fa-clock fa-lg"></i></div>
                <h3 class="fw-bold">38</h3>
                <p class="text-muted mb-0">Sedang Diproses</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-white">
                <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-circle-check fa-lg"></i></div>
                <h3 class="fw-bold">197</h3>
                <p class="text-muted mb-0">Selesai Ditangani</p>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold">Pengaduan Terbaru</h5>
            <div class="d-flex gap-2">
                <input type="text" class="form-control form-control-sm" placeholder="Cari pengaduan...">
                <select class="form-select form-select-sm">
                    <option>Semua Status</option>
                </select>
            </div>
        </div>
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>NO. TIKET</th>
                    <th>PELAPOR</th>
                    <th>JUDUL PENGADUAN</th>
                    <th>KATEGORI</th>
                    <th>STATUS</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengaduans as $p)
                <tr>
                    <td>TKT-{{ $p->created_at->format('Y') }}-{{ str_pad($p->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $p->nama_pelapor }}</td>
                    <td>{{ Str::limit($p->deskripsi, 30) }}</td>
                    <td><span class="small text-muted text-uppercase">{{ $p->kategori }}</span></td>
                    <td><span class="badge badge-{{ strtolower($p->status) }}">{{ strtoupper($p->status) }}</span></td>
                    <td>
                        <a href="{{ route('admin.pengaduan.show', $p->id) }}" class="btn btn-sm btn-outline-primary" title="Lihat Detail"><i class="fa-solid fa-eye"></i></a>
                        <form action="{{ route('admin.pengaduan.updateStatus', $p->id) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="status" value="Selesai">
                            <button type="submit" class="btn btn-sm btn-outline-success" title="Selesaikan" onclick="return confirm('Tandai pengaduan ini sebagai Selesai?')"><i class="fa-solid fa-check"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>