@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen w-full py-12 px-4">
    <div class="bg-white w-full max-w-[500px] rounded-[30px] shadow-2xl p-8 md:p-10">
        
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Pengaduan Surakarta</h2>
            <p class="text-gray-500 font-medium">Layanan Pengaduan Masyarakat</p>
        </div>

        <h3 class="text-xl font-bold text-gray-800 mb-6">Daftar Akun</h3>

        <form method="POST" action="{{ route('register') }}" class="space-y-5 max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap *</label>
                <input type="text" name="name" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Masukkan nama lengkap" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email *</label>
                <input type="email" name="email" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Masukkan email" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat *</label>
                <input type="text" name="alamat" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Alamat tempat tinggal" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor KTP *</label>
                <input type="text" name="ktp" maxlength="16" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="16 digit nomor KTP" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">No. Telepon *</label>
                <input type="text" name="no_hp" maxlength="20" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="08xxxxxxxxxx" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kata Sandi *</label>
                <input type="password" name="password" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Minimal 6 karakter" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Kata Sandi *</label>
                <input type="password" name="password_confirmation" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Ulangi kata sandi" required>
            </div>

            <div class="pt-4 space-y-4">
                <button type="submit" class="w-full bg-[#10b981] text-white font-bold py-4 rounded-xl hover:bg-emerald-600 transition-all flex items-center justify-center gap-2 text-lg shadow-lg shadow-emerald-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    Daftar
                </button>
                <a href="{{ route('login') }}" class="w-full border-2 border-gray-100 text-gray-600 font-bold py-4 rounded-xl hover:bg-gray-50 transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Login
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>
@endsection
