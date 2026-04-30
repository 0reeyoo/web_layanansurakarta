@extends('layouts.admin')

@section('content')
@if(session('success'))
    <div class="mb-4 bg-emerald-100 text-emerald-700 px-4 py-3 rounded">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
@endif
@if($errors->any())
    <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded">{{ $errors->first() }}</div>
@endif

@php
    $kategoriStoreRoute = match (optional(auth()->user())->dinas_role) {
        'PUPR' => 'admin-pupr.kategori.store',
        'DLH' => 'admin-dlh.kategori.store',
        'PERHUBUNGAN' => 'admin-perhubungan.kategori.store',
        default => 'admin.kategori.store',
    };
    $kategoriDestroyRoute = match (optional(auth()->user())->dinas_role) {
        'PUPR' => 'admin-pupr.kategori.destroy',
        'DLH' => 'admin-dlh.kategori.destroy',
        'PERHUBUNGAN' => 'admin-perhubungan.kategori.destroy',
        default => 'admin.kategori.destroy',
    };
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white border rounded-xl p-5 lg:col-span-1">
        <h3 class="font-bold mb-4">Tambah Kategori Layanan</h3>
        <form method="POST" action="{{ route($kategoriStoreRoute) }}" class="space-y-3">
            @csrf
            <input type="text" name="nama" placeholder="Contoh: Marka Jalan Pudar" class="w-full border rounded p-2" required>
            @if(!$isDinasAdmin)
                <select name="dinas" class="w-full border rounded p-2" required>
                    <option value="" disabled selected>Pilih Dinas</option>
                    @foreach($dinasOptions as $kode => $nama)
                        <option value="{{ $kode }}">{{ $kode }} - {{ $nama }}</option>
                    @endforeach
                </select>
            @endif
            <button class="bg-navy-700 text-white px-4 py-2 rounded">Simpan Kategori</button>
        </form>
    </div>

    <div class="bg-white border rounded-xl overflow-x-auto lg:col-span-2">
        <div class="p-4 border-b">
            <h4 class="font-bold">Daftar Kategori Layanan</h4>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="p-3 text-left">Kategori</th>
                    <th class="p-3 text-left">Dinas</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $item)
                    <tr class="border-t">
                        <td class="p-3">{{ $item->nama }}</td>
                        <td class="p-3">{{ $item->dinas }}</td>
                        <td class="p-3">
                            <form method="POST" action="{{ route($kategoriDestroyRoute, $item->id) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-3 text-slate-500">Belum ada kategori layanan. Tambahkan kategori baru di form sebelah kiri.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

