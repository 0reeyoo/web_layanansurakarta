<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin Dinas - Pengaduan Surakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#1f3f67]">
    <div class="min-h-screen w-full flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-[520px] rounded-xl overflow-hidden shadow-2xl border border-slate-300">
            <div class="bg-[#294d7b] text-white px-8 py-8 text-center">
                <div class="mx-auto w-14 h-14 rounded-xl bg-white/15 flex items-center justify-center mb-4">
                    <img src="{{ asset('logo-solo.png') }}" alt="Logo Surakarta" class="w-9 h-9 object-contain" onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/b/ba/Lambang_Kota_Surakarta.png'">
                </div>
                <h2 class="text-3xl font-extrabold leading-tight">Pengaduan Masyarakat</h2>
                <p class="text-sm text-slate-200 mt-1">Kota Surakarta</p>
            </div>

            <div class="bg-slate-100 px-8 py-8">
                <h3 class="text-2xl font-bold text-slate-800">Login Admin</h3>
                <p class="text-sm text-slate-500 mt-1 mb-6">Masukkan kredensial Anda untuk melanjutkan</p>

                <div class="mb-6">
                    <p class="text-xs font-bold uppercase tracking-wide text-slate-600 mb-2">Link Cepat Login Admin</p>
                    <div class="grid grid-cols-1 gap-2 text-sm">
                        <a href="{{ route('login.admin.dinas.pupr') }}" class="px-3 py-2 rounded-lg border border-blue-200 bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                            PUPR - /login-admin-dinas/pupr
                        </a>
                        <a href="{{ route('login.admin.dinas.dlh') }}" class="px-3 py-2 rounded-lg border border-green-200 bg-green-50 text-green-700 hover:bg-green-100 transition">
                            DLH - /login-admin-dinas/dlh
                        </a>
                        <a href="{{ route('login.admin.dinas.perhubungan') }}" class="px-3 py-2 rounded-lg border border-purple-200 bg-purple-50 text-purple-700 hover:bg-purple-100 transition">
                            PERHUBUNGAN - /login-admin-dinas/perhubungan
                        </a>
                    </div>
                </div>

                @if (session('success'))
                    <div class="mb-4 rounded-lg border border-emerald-300 bg-emerald-100 text-emerald-700 px-4 py-3 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 rounded-lg border border-red-300 bg-red-100 text-red-700 px-4 py-3 text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wide text-slate-700 mb-1">Email / Username</label>
                        <input type="text" name="email" value="{{ old('email', request('email')) }}" class="w-full rounded-md border border-slate-300 bg-white px-4 py-3 focus:ring-2 focus:ring-[#294d7b] outline-none" placeholder="admin@surakarta.go.id" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wide text-slate-700 mb-1">Password</label>
                        <div class="relative">
                            <input id="passwordInput" type="password" name="password" value="{{ old('password', request('password')) }}" class="w-full rounded-md border border-slate-300 bg-white px-4 py-3 pr-12 focus:ring-2 focus:ring-[#294d7b] outline-none" placeholder="Masukkan password" required>
                            <button type="button" id="togglePassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-700" aria-label="Lihat password">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remember" class="rounded border-slate-300">
                        Ingat saya di perangkat ini
                    </label>

                    <button type="submit" class="w-full rounded-md bg-[#294d7b] hover:bg-[#223f64] text-white font-bold py-3 transition">
                        Masuk
                    </button>
                </form>
            </div>

            <div class="bg-slate-200 text-center text-xs text-slate-600 py-3">
                &copy; {{ date('Y') }} Dinas Komunikasi dan Informatika Kota Surakarta
            </div>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('passwordInput');
        const togglePassword = document.getElementById('togglePassword');
        togglePassword?.addEventListener('click', function () {
            passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        });
    </script>
</body>
</html>
