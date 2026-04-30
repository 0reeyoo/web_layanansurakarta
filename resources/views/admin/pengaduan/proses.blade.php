@extends('layouts.admin')

@section('content')
@php
    $showAksi = (bool) optional(auth()->user())->dinas_role;
@endphp
@if(session('success'))
    <div class="mb-4 bg-emerald-100 text-emerald-700 px-4 py-3 rounded">{{ session('success') }}</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white border rounded-xl p-4"><p class="text-sm text-slate-500">Total</p><p class="text-2xl font-bold">{{ $stats['total'] }}</p></div>
    <div class="bg-white border rounded-xl p-4"><p class="text-sm text-slate-500">Menunggu</p><p class="text-2xl font-bold text-amber-500">{{ $stats['menunggu'] }}</p></div>
    <div class="bg-white border rounded-xl p-4"><p class="text-sm text-slate-500">Diproses</p><p class="text-2xl font-bold text-blue-600">{{ $stats['proses'] }}</p></div>
    <div class="bg-white border rounded-xl p-4"><p class="text-sm text-slate-500">Selesai</p><p class="text-2xl font-bold text-emerald-600">{{ $stats['selesai'] }}</p></div>
</div>

<div class="bg-white rounded-xl border overflow-x-auto">
    <div class="p-4 border-b"><h3 class="font-bold">{{ $judul }}</h3></div>
    <table class="w-full text-sm">
        <thead class="bg-slate-50">
            <tr><th class="p-3 text-left">Pelapor</th><th class="p-3 text-left">Kategori</th><th class="p-3 text-left">Tanggal</th><th class="p-3 text-left">Status</th>@if($showAksi)<th class="p-3 text-left">Aksi</th>@endif</tr>
        </thead>
        <tbody>
            @forelse($pengaduans as $item)
            <tr class="border-t">
                <td class="p-3">{{ $item->nama_pelapor }}</td>
                <td class="p-3">{{ $item->kategori }}</td>
                <td class="p-3">{{ optional($item->tanggal_kejadian)->format('d M Y') }}</td>
                <td class="p-3">{{ $item->status }}</td>
                @if($showAksi)
                <td class="p-3">
                    <div class="flex gap-2 items-center">
                        <a href="{{ route('admin.pengaduan.show', $item->id) }}" class="bg-slate-100 text-slate-700 px-3 py-1 rounded hover:bg-slate-200">Detail</a>
                        <form method="POST" action="{{ route('admin.pengaduan.updateStatus', $item->id) }}" class="flex gap-2">
                        @csrf
                        <select name="status" class="border rounded px-2 py-1">
                            <option value="Menunggu" @selected($item->status === 'Menunggu')>Menunggu</option>
                            <option value="Diproses" @selected($item->status === 'Diproses')>Diproses</option>
                            <option value="Selesai" @selected($item->status === 'Selesai')>Selesai</option>
                        </select>
                        <button class="bg-navy-700 text-white px-3 rounded">Simpan</button>
                        </form>
                    </div>
                </td>
                @endif
            </tr>
            @empty
            <tr><td class="p-3 text-slate-500" colspan="{{ $showAksi ? 5 : 4 }}">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $pengaduans->links() }}</div>
</div>
@endsection
