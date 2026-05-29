@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen w-full px-4">
    <div class="bg-white w-full max-w-[450px] rounded-[30px] shadow-2xl p-8 md:p-10">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Pengaduan Surakarta</h2>
            <p class="text-gray-500 font-medium">Layanan Pengaduan Masyarakat</p>
        </div>

        <h3 class="text-xl font-bold text-gray-800 mb-6">Masuk Pengguna</h3>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email atau Nama Pengguna *</label>
                <input type="text" name="email" value="{{ old('email') }}" class="w-full px-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all placeholder:text-gray-400" placeholder="Masukkan email atau nama pengguna" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi *</label>
                <div class="relative">
                    <input id="passwordInput" type="password" name="password" class="w-full px-4 py-3.5 rounded-xl border border-gray-200 bg-blue-50 focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all placeholder:text-gray-400 pr-12" placeholder="Masukkan kata sandi" required>
                    <button type="button" id="togglePassword" tabindex="-1" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500 hover:text-gray-700 leading-none focus:outline-none" aria-label="Lihat password">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-[#2563eb] text-white font-bold py-4 rounded-xl hover:bg-blue-700 transition-all text-lg">
                Masuk
            </button>

            <div id="forgotPasswordContainer" class="hidden">
                <a href="{{ route('password.request') }}" class="w-full border-2 border-red-100 text-red-600 font-bold py-4 rounded-xl hover:bg-red-50 transition-all flex items-center justify-center text-lg mt-2 shadow-sm">Lupa Kata Sandi?</a>
            </div>

            <a href="{{ route('register') }}" class="w-full border-2 border-gray-100 text-gray-600 font-bold py-4 rounded-xl hover:bg-gray-50 transition-all flex items-center justify-center text-lg">
                Buat Akun Baru
            </a>
        </form>

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('passwordInput');
            const eyeIcon = document.getElementById('eyeIcon');
            let isShown = false;
            if (togglePassword && passwordInput && eyeIcon) {
                togglePassword.addEventListener('click', function () {
                    isShown = !isShown;
                    passwordInput.type = isShown ? 'text' : 'password';
                    // Ganti ikon jika ingin efek eye/eye-off
                    eyeIcon.innerHTML = isShown
                        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.042-3.292m3.1-2.727A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.293 5.411M15 12a3 3 0 11-6 0 3 3 0 016 0zm-6.364 6.364L6 18m12 0l-1.636-1.636M3 3l18 18" />'
                        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
                });
            }
        });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const forgotPasswordContainer = document.getElementById('forgotPasswordContainer');
                const hasError = @json($errors->any());

                // Jika halaman dimuat dengan error (login gagal)
                if (hasError) {
                    let count = parseInt(localStorage.getItem('login_failed_count') || '0', 10);
                    localStorage.setItem('login_failed_count', count + 1);
                }

                // Tampilkan tombol jika sudah gagal 3 kali atau lebih
                if (parseInt(localStorage.getItem('login_failed_count') || '0', 10) >= 3) {
                    forgotPasswordContainer.classList.remove('hidden');
                }
            });
        </script>
    </div>
</div>
@endsection
