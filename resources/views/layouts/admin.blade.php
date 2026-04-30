<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Pengaduan Surakarta</title>
    <script src="https://cdn.tailwindcss.com/3.4.17"></script>
    <script src="https://cdn.jsdelivr.net/npm/lucide@0.263.0/dist/umd/lucide.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        navy: { 50:'#eef3f9', 100:'#d4e0f0', 200:'#a9c1e0', 300:'#7da2d1', 400:'#5283c1', 500:'#2c4e7a', 600:'#243f63', 700:'#1c314c', 800:'#142236', 900:'#0c141f' },
                        accent: { 500: '#8b5cf6' }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 font-sans h-full">
    @php
        $adminUser = auth()->user();
        $isDinasAdmin = (bool) optional($adminUser)->dinas_role;
        $dinasQuery = $isDinasAdmin ? ['dinas' => $adminUser->dinas_role] : [];

        $dashboardRoute = match (optional($adminUser)->dinas_role) {
            'PUPR' => 'admin-pupr.dashboard',
            'DLH' => 'admin-dlh.dashboard',
            'PERHUBUNGAN' => 'admin-perhubungan.dashboard',
            default => 'admin.dashboard',
        };
        $pengaduanMasukRoute = match (optional($adminUser)->dinas_role) {
            'PUPR' => 'admin-pupr.pengaduan.index',
            'DLH' => 'admin-dlh.pengaduan.index',
            'PERHUBUNGAN' => 'admin-perhubungan.pengaduan.index',
            default => 'admin.pengaduan.index',
        };
        $pengaduanProsesRoute = match (optional($adminUser)->dinas_role) {
            'PUPR' => 'admin-pupr.pengaduan.proses',
            'DLH' => 'admin-dlh.pengaduan.proses',
            'PERHUBUNGAN' => 'admin-perhubungan.pengaduan.proses',
            default => 'admin.pengaduan.proses',
        };
        $pengaduanSelesaiRoute = match (optional($adminUser)->dinas_role) {
            'PUPR' => 'admin-pupr.pengaduan.selesai',
            'DLH' => 'admin-dlh.pengaduan.selesai',
            'PERHUBUNGAN' => 'admin-perhubungan.pengaduan.selesai',
            default => 'admin.pengaduan.selesai',
        };
        $logoutRoute = match (optional($adminUser)->dinas_role) {
            'PUPR' => 'admin-pupr.logout',
            'DLH' => 'admin-dlh.logout',
            'PERHUBUNGAN' => 'admin-perhubungan.logout',
            default => 'admin.logout',
        };
        $adminDisplayName = match (optional($adminUser)->dinas_role) {
            'PUPR' => 'Admin PUPR',
            'DLH' => 'Admin DLH',
            'PERHUBUNGAN' => 'Admin PERHUBUNGAN',
            default => 'Admin Diskominfo',
        };
        $kategoriRoute = match (optional($adminUser)->dinas_role) {
            'PUPR' => 'admin-pupr.kategori.index',
            'DLH' => 'admin-dlh.kategori.index',
            'PERHUBUNGAN' => 'admin-perhubungan.kategori.index',
            default => 'admin.kategori.index',
        };

        $jumlahPengaduanMasuk = \App\Models\Pengaduan::where('status', 'Menunggu')->where($dinasQuery)->count();
        $seenDiprosesAt = session('admin_pengaduan_seen_diproses_at');
        $seenSelesaiAt = session('admin_pengaduan_seen_selesai_at');

        $jumlahNotifDiproses = \App\Models\Pengaduan::where('status', 'Diproses')
            ->where($dinasQuery)
            ->when($seenDiprosesAt, fn ($query) => $query->where('updated_at', '>', $seenDiprosesAt))
            ->count();

        $jumlahNotifSelesai = \App\Models\Pengaduan::where('status', 'Selesai')
            ->where($dinasQuery)
            ->when($seenSelesaiAt, fn ($query) => $query->where('updated_at', '>', $seenSelesaiAt))
            ->count();

        $jumlahNotifTotal = $jumlahPengaduanMasuk + $jumlahNotifDiproses + $jumlahNotifSelesai;
        $now = \Carbon\Carbon::now();
        $jam = (int) $now->format('H');
        if ($jam < 11) {
            $sapaan = 'Selamat Pagi';
        } elseif ($jam < 15) {
            $sapaan = 'Selamat Siang';
        } elseif ($jam < 18) {
            $sapaan = 'Selamat Sore';
        } else {
            $sapaan = 'Selamat Malam';
        }
    @endphp
    <div class="flex h-full">
        <aside class="w-64 bg-navy-900 text-white flex flex-col fixed h-full shadow-2xl">
            <div class="p-6 border-b border-navy-800">
                <h1 class="text-xl font-extrabold tracking-tight italic">PENGADUAN</h1>
                <p class="text-[10px] text-navy-400 font-bold uppercase tracking-[0.2em]">Kota Surakarta</p>
            </div>
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <p class="text-[10px] font-bold text-navy-500 uppercase tracking-widest px-2 mb-2">Utama</p>
                <a href="{{ route($dashboardRoute) }}" class="flex items-center space-x-3 p-3 rounded-xl bg-navy-800 border-l-4 border-white shadow-lg shadow-navy-950/50">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span class="font-bold">Dashboard</span>
                </a>
                
                <p class="text-[10px] font-bold text-navy-500 uppercase tracking-widest px-2 pt-6 mb-2">Layanan</p>
                <a href="{{ route($pengaduanMasukRoute) }}" class="flex items-center justify-between p-3 rounded-xl text-navy-300 hover:bg-navy-800 hover:text-white transition">
                    <div class="flex items-center space-x-3"><i data-lucide="mail" class="w-5 h-5"></i><span>Masuk</span></div>
                    @if ($jumlahPengaduanMasuk > 0)
                        <span class="bg-yellow-500 text-navy-900 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $jumlahPengaduanMasuk }}</span>
                    @endif
                </a>
                <a href="{{ route($pengaduanProsesRoute) }}" class="flex items-center justify-between p-3 rounded-xl text-navy-300 hover:bg-navy-800 hover:text-white transition">
                    <div class="flex items-center space-x-3"><i data-lucide="loader-2" class="w-5 h-5"></i><span>Proses</span></div>
                    @if ($jumlahNotifDiproses > 0)
                        <span class="bg-sky-400 text-navy-900 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $jumlahNotifDiproses }}</span>
                    @endif
                </a>
                <a href="{{ route($pengaduanSelesaiRoute) }}" class="flex items-center justify-between p-3 rounded-xl text-navy-300 hover:bg-navy-800 hover:text-white transition">
                    <div class="flex items-center space-x-3"><i data-lucide="check-circle" class="w-5 h-5"></i><span>Selesai</span></div>
                    @if ($jumlahNotifSelesai > 0)
                        <span class="bg-green-400 text-navy-900 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $jumlahNotifSelesai }}</span>
                    @endif
                </a>
                <a href="{{ route($kategoriRoute) }}" class="flex items-center space-x-3 p-3 rounded-xl text-navy-300 hover:bg-navy-800 hover:text-white transition">
                    <i data-lucide="list-tree" class="w-5 h-5"></i><span>Kategori Layanan</span>
                </a>

                @if (!$isDinasAdmin)
                <p class="text-[10px] font-bold text-navy-500 uppercase tracking-widest px-2 pt-6 mb-2">Sistem</p>
                <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 p-3 rounded-xl text-navy-300 hover:bg-navy-800 hover:text-white transition">
                    <i data-lucide="users" class="w-5 h-5"></i><span>Manajemen User</span>
                </a>
                <a href="{{ route('admin.galeri-berita.index') }}" class="flex items-center space-x-3 p-3 rounded-xl text-navy-300 hover:bg-navy-800 hover:text-white transition">
                    <i data-lucide="images" class="w-5 h-5"></i><span>Galeri & Berita</span>
                </a>
                @endif
                <form action="{{ route($logoutRoute) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-3 p-3 rounded-xl text-red-300 hover:bg-red-900/30 hover:text-red-200 transition">
                        <i data-lucide="log-out" class="w-5 h-5"></i><span>Keluar</span>
                    </button>
                </form>
            </nav>
            <div class="p-4 bg-navy-950/50 mt-auto border-t border-navy-800">
                <div class="flex items-center space-x-3">
                    <img src="https://ui-avatars.com/api/?name=Admin" class="w-10 h-10 rounded-xl border border-navy-700">
                    <div>
                        <p class="text-xs font-bold">{{ $adminDisplayName }}</p>
                        <p class="text-[10px] text-navy-400">Online</p>
                    </div>
                </div>
            </div>
        </aside>

        <main class="flex-1 ml-64 p-8">
            <header class="flex justify-between items-center mb-10 border-t-4 border-accent-500 bg-white p-6 rounded-2xl shadow-sm">
                <div>
                    <h2 class="text-2xl font-extrabold text-navy-900 tracking-tight">Panel Administrasi</h2>
                    <p class="text-slate-400 text-xs font-medium">Sistem Informasi Pengaduan Masyarakat v1.0</p>
                </div>
                <div class="flex items-center space-x-6">
                    <div class="text-right border-r pr-6 border-slate-100">
                        <p class="text-sm font-bold text-navy-900">{{ $sapaan }}, Admin!</p>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ $now->locale('id')->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <div class="relative">
                        <button id="notif-toggle" type="button" class="relative p-2 bg-slate-50 rounded-xl text-slate-400 hover:text-navy-600 transition">
                            <i data-lucide="bell" class="w-5 h-5"></i>
                            @if ($jumlahNotifTotal > 0)
                                <span class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 bg-red-500 text-white text-[10px] font-bold rounded-full border-2 border-white flex items-center justify-center">{{ $jumlahNotifTotal }}</span>
                            @endif
                        </button>

                        <div id="notif-panel" class="hidden absolute right-0 top-12 w-80 bg-white border border-slate-200 rounded-2xl shadow-xl z-50 overflow-hidden">
                            <div class="px-4 py-3 border-b bg-slate-50">
                                <p class="text-sm font-bold text-navy-900">Notifikasi Pengaduan</p>
                                <p class="text-xs text-slate-500">Pantau laporan terbaru per status</p>
                            </div>
                            <div class="p-3 space-y-2">
                                <a href="{{ route($pengaduanMasukRoute) }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 border border-slate-200">
                                    <span class="text-sm font-medium text-slate-700">Menunggu</span>
                                    <span class="text-xs font-bold bg-amber-100 text-amber-700 px-2 py-1 rounded-full">{{ $jumlahPengaduanMasuk }}</span>
                                </a>
                                <a href="{{ route($pengaduanProsesRoute) }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 border border-slate-200">
                                    <span class="text-sm font-medium text-slate-700">Diproses (baru)</span>
                                    <span class="text-xs font-bold bg-sky-100 text-sky-700 px-2 py-1 rounded-full">{{ $jumlahNotifDiproses }}</span>
                                </a>
                                <a href="{{ route($pengaduanSelesaiRoute) }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 border border-slate-200">
                                    <span class="text-sm font-medium text-slate-700">Selesai (baru)</span>
                                    <span class="text-xs font-bold bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full">{{ $jumlahNotifSelesai }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            @yield('content')
        </main>
    </div>
    <script>
        lucide.createIcons();

        const notifToggle = document.getElementById('notif-toggle');
        const notifPanel = document.getElementById('notif-panel');

        if (notifToggle && notifPanel) {
            notifToggle.addEventListener('click', function (event) {
                event.stopPropagation();
                notifPanel.classList.toggle('hidden');
            });

            document.addEventListener('click', function (event) {
                if (!notifPanel.contains(event.target) && !notifToggle.contains(event.target)) {
                    notifPanel.classList.add('hidden');
                }
            });
        }
    </script>
</body>
</html>
