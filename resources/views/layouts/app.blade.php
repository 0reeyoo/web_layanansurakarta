<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Surakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    <nav class="bg-[#2c4e7a] text-white p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center">
                    <img src="{{ asset('logo-solo.png') }}" 
                         class="h-16 w-auto object-contain" 
                         alt="Logo Surakarta"
                         onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/b/ba/Lambang_Kota_Surakarta.png'">
                </div>
                <div>
                    <h1 class="font-bold text-lg leading-tight uppercase tracking-tight">Layanan Pengaduan Masyarakat</h1>
                    <p class="text-xs opacity-90 uppercase tracking-widest">Pemerintah Kota Surakarta</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                @if(Auth::check())
                    <span class="text-sm mr-2 italic">Halo, {{ Auth::user()->name }}</span>
                    @php
                        $logoutRoute = Route::has('logout') ? 'logout' : (Route::has('admin.logout') ? 'admin.logout' : null);
                    @endphp
                    @if($logoutRoute)
                        <form action="{{ route($logoutRoute) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="border border-white/50 px-4 py-1.5 rounded flex items-center gap-2 hover:bg-red-500 hover:border-red-500 transition-all text-sm opacity-80 hover:opacity-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Keluar
                            </button>
                        </form>
                    @endif
                @endif
            </div>
        </div>

        <div class="container mx-auto mt-6 flex gap-2 text-sm relative">
            <a href="/" class="{{ Request::is('/') ? 'bg-white/20' : '' }} px-4 py-2 rounded flex items-center gap-2 transition hover:bg-white/10">
                Beranda
            </a>
            
            <div class="relative group">
                <button id="dropdownProfil" class="px-4 py-2 hover:bg-white/10 rounded transition flex items-center gap-2 border-b-2 {{ Request::is('profil/visi-misi') || Request::is('profil/struktur') ? 'border-white bg-white/20' : 'border-transparent' }}">
                    Profil
                    <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                
                <div class="absolute left-0 mt-1 w-56 bg-white rounded-xl shadow-xl py-2 z-50 hidden group-hover:block border border-gray-100">
                    <a href="{{ route('profil.visi-misi') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Visi, Misi, & Tugas
                    </a>
                </div>
            </div>

            <div class="relative group">
                <button id="dropdownDokumen" class="px-4 py-2 hover:bg-white/10 rounded transition flex items-center gap-2 border-b-2 {{ Request::is('profil/galeri') || Request::is('profil/berita') ? 'border-white bg-white/20' : 'border-transparent' }}">
                    Dokumen & Informasi
                    <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                
                <div class="absolute left-0 mt-1 w-56 bg-white rounded-xl shadow-xl py-2 z-50 hidden group-hover:block border border-gray-100">
                    <a href="{{ route('profil.galeri') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-purple-50 hover:text-purple-600 transition flex items-center gap-3">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-medium">Galeri</span>
                    </a>
                    <a href="{{ route('profil.berita') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition flex items-center gap-3">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        <span class="font-medium">Berita</span>
                    </a>
                    <div class="border-t border-gray-100 my-1"></div>
                    <a href="https://ppid.surakarta.go.id/" target="_blank" class="block px-4 py-2.5 text-gray-700 hover:bg-green-50 hover:text-green-600 transition flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-7h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <span class="font-medium">PPID Surakarta</span>
                    </a>
                </div>
            </div>

            @auth
                <a href="{{ route('pengaduan.riwayat') }}" class="px-4 py-2 hover:bg-white/10 rounded transition {{ Request::is('pengaduan/riwayat*') ? 'bg-white/20' : '' }}">Riwayat</a>
            @endauth
        </div>
    </nav>

    <main class="container mx-auto py-10 px-4 flex-grow">
        @yield('content')
    </main>

    <footer class="bg-[#1e293b] text-gray-300 py-12 mt-auto">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="bg-white p-2 rounded-lg flex items-center justify-center w-12 h-14">
                            <img src="{{ asset('logo-solo.png') }}" 
                                 class="h-10 w-auto object-contain" 
                                 alt="Logo Surakarta">
                        </div>
                        <h3 class="text-xl font-bold text-white uppercase tracking-wider leading-tight">Pemerintah Kota<br>Surakarta</h3>
                    </div>
                    <p class="text-sm leading-relaxed text-gray-400 max-w-xs">Melayani dengan sepenuh hati untuk Surakarta yang lebih baik.</p>
                </div>

                <div class="space-y-4">
                    <h4 class="text-lg font-bold text-white uppercase tracking-widest">Kontak</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-gray-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            <span class="text-sm">Jl. Jenderal Sudirman No. 2, Surakarta</span>
                        </li>
                    </ul>
                </div>

                <div class="space-y-4">
                    <h4 class="text-lg font-bold text-white uppercase tracking-widest">Jam Layanan</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li class="flex justify-between border-b border-gray-700 pb-2"><span>Senin - Jumat:</span><span class="text-white font-medium">08.00 - 16.00 WIB</span></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-12 pt-8 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Pemerintah Kota Surakarta. Hak Cipta Dilindungi.
            </div>
        </div>
    </footer>

    <script>
        function setupDropdown(btnId) {
            const btn = document.getElementById(btnId);
            if(!btn) return;
            const menu = btn.nextElementSibling;

            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                document.querySelectorAll('.group div').forEach(el => {
                    if (el !== menu) el.classList.add('hidden');
                });
                menu.classList.toggle('hidden');
            });
        }

        setupDropdown('dropdownProfil');
        setupDropdown('dropdownDokumen');

        window.addEventListener('click', () => {
            document.querySelectorAll('.group div').forEach(el => el.classList.add('hidden'));
        });
    </script>
</body>
</html>
