@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen w-full px-4">
    <div class="bg-white w-full max-w-[450px] rounded-[30px] shadow-2xl p-8 md:p-10">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Lupa Kata Sandi</h2>
            <p class="text-gray-500 font-medium">Masukkan email akun Anda untuk reset kata sandi.</p>
        </div>
        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 text-sm">
                {{ session('status') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif
        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                <input type="email" name="email" class="w-full px-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all placeholder:text-gray-400" placeholder="Masukkan email akun" required>
            </div>
            <button type="submit" class="w-full bg-[#2563eb] text-white font-bold py-4 rounded-xl hover:bg-blue-700 transition-all text-lg">
                Kirim Link Reset
            </button>
            <a href="{{ route('login') }}" class="w-full border-2 border-gray-100 text-gray-600 font-bold py-4 rounded-xl hover:bg-gray-50 transition-all flex items-center justify-center text-lg">
                Kembali ke Login
            </a>
        </form>
    </div>
</div>
@endsection
