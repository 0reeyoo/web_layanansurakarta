@extends('layouts.admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
    <div class="bg-white rounded-xl p-5 border"><p class="text-sm text-slate-500">Total Pengaduan</p><p class="text-3xl font-bold">{{ $stats['total_pengaduan'] }}</p></div>
    <div class="bg-white rounded-xl p-5 border"><p class="text-sm text-slate-500">Menunggu</p><p class="text-3xl font-bold text-amber-500">{{ $stats['menunggu'] }}</p></div>
    <div class="bg-white rounded-xl p-5 border"><p class="text-sm text-slate-500">Diproses</p><p class="text-3xl font-bold text-blue-600">{{ $stats['proses'] }}</p></div>
    <div class="bg-white rounded-xl p-5 border"><p class="text-sm text-slate-500">Selesai</p><p class="text-3xl font-bold text-emerald-600">{{ $stats['selesai'] }}</p></div>
    <div class="bg-white rounded-xl p-5 border"><p class="text-sm text-slate-500">Total User</p><p class="text-3xl font-bold">{{ $stats['total_user'] }}</p></div>
</div>

<div class="bg-white rounded-xl border overflow-x-auto">
    <div class="p-4 border-b">
        <h3 class="font-bold">Pengaduan Terbaru</h3>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-slate-50">
            <tr>
                <th class="text-left p-3">Pelapor</th>
                <th class="text-left p-3">Kategori</th>
                <th class="text-left p-3">Tanggal</th>
                <th class="text-left p-3">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pengaduanTerbaru as $item)
                <tr class="border-t">
                    <td class="p-3">{{ $item->nama_pelapor }}</td>
                    <td class="p-3">{{ $item->kategori }}</td>
                    <td class="p-3">{{ optional($item->tanggal_kejadian)->format('d M Y') }}</td>
                    <td class="p-3">{{ $item->status }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="p-3 text-slate-500">Belum ada data pengaduan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
