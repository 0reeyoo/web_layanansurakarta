@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Riwayat Pengaduan Saya</h2>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if($pengaduans->isEmpty())
        <div class="text-center py-12 bg-white rounded-2xl shadow-sm border border-gray-100">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada pengaduan</h3>
            <p class="mt-1 text-sm text-gray-500">Mulai buat pengaduan baru untuk melaporkan masalah.</p>
            <div class="mt-6">
                <a href="{{ route('pengaduan.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    Buat Pengaduan Baru
                </a>
            </div>
        </div>
    @else

    @foreach($pengaduans as $item)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="p-6 flex justify-between items-start border-b border-gray-50">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-orange-100 rounded-xl">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 text-lg">{{ $item->kategori }}</h4>
                    <p class="text-sm text-gray-400 font-mono">#ADU-{{ $item->id }}-{{ $item->created_at->format('dmY') }}</p>
                </div>
            </div>
            
            @php
                $statusClass = match($item->status) {
                    'Menunggu' => 'bg-yellow-100 text-yellow-600',
                    'Diproses' => 'bg-blue-100 text-blue-600',
                    'Selesai' => 'bg-green-100 text-green-600',
                    'Ditolak' => 'bg-red-100 text-red-600',
                    default => 'bg-gray-100 text-gray-600'
                };
            @endphp
            <span class="px-4 py-1.5 {{ $statusClass }} rounded-full text-xs font-bold">{{ $item->status }}</span>
        </div>

        <div class="p-6 space-y-6">
            <div class="relative pl-8 space-y-8 before:content-[''] before:absolute before:left-3 before:top-2 before:bottom-2 before:w-0.5 before:bg-green-200">
                <!-- Status Flow Logic -->
                <div class="relative">
                    <div class="absolute -left-[25px] w-4 h-4 rounded-full {{ in_array($item->status, ['Menunggu', 'Diproses', 'Selesai']) ? 'bg-green-500 border-green-100' : 'bg-gray-300 border-gray-100' }} border-4"></div>
                    <p class="font-bold {{ in_array($item->status, ['Menunggu', 'Diproses', 'Selesai']) ? 'text-gray-800' : 'text-gray-400' }} text-sm">Menunggu</p>
                    <p class="text-xs text-gray-400">{{ $item->created_at->format('d M Y H:i') }}</p>
                </div>
                <div class="relative">
                    <div class="absolute -left-[25px] w-4 h-4 rounded-full {{ in_array($item->status, ['Diproses', 'Selesai']) ? 'bg-green-500 border-green-100' : 'bg-gray-300 border-gray-100' }} border-4"></div>
                    <p class="font-bold {{ in_array($item->status, ['Diproses', 'Selesai']) ? 'text-gray-800' : 'text-gray-400' }} text-sm">Diproses</p>
                </div>
                <div class="relative">
                    <div class="absolute -left-[25px] w-4 h-4 rounded-full {{ $item->status == 'Selesai' ? 'bg-green-500 border-green-100' : 'bg-gray-300 border-gray-100' }} border-4"></div>
                    <p class="font-bold {{ $item->status == 'Selesai' ? 'text-green-600' : 'text-gray-400' }} text-sm">Selesai</p>
                </div>
            </div>
        </div>

        <div class="bg-gray-50/50 p-6 grid grid-cols-1 md:grid-cols-2 gap-8 border-t border-gray-100">
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Lokasi Kejadian</p>
                <p class="text-sm font-bold text-gray-800">{{ $item->alamat_pelapor }}</p>
                @if($item->latitude && $item->longitude)
                    <p class="text-xs text-gray-400">Lat: {{ number_format($item->latitude, 6) }}, Lng: {{ number_format($item->longitude, 6) }}</p>
                @endif
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Tanggal Kejadian</p>
                <p class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($item->tanggal_kejadian)->format('d M Y') }}</p>
                <p class="text-xs text-gray-400 italic">Dilaporkan: {{ $item->created_at->diffForHumans() }}</p>
            </div>
        </div>

        <div class="p-6 space-y-4">
            <div class="p-4 bg-white border border-gray-100 rounded-xl">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Deskripsi Pengaduan</p>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $item->deskripsi }}</p>
            </div>
            
            @if($item->foto_bukti_url)
            <div class="p-4 bg-white border border-gray-100 rounded-xl flex items-center gap-3">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Lampiran Foto:</p>
                <a href="{{ $item->foto_bukti_url }}" target="_blank" class="text-sm text-blue-600 hover:underline">Lihat Foto</a>
            </div>
            @endif

            @if($item->status === 'Selesai' && $item->bukti_selesai_url)
            <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-xl">
                <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider mb-2">Bukti Pengaduan Selesai</p>
                <a href="{{ $item->bukti_selesai_url }}" target="_blank" class="text-sm text-emerald-700 hover:underline font-semibold">Lihat Bukti Pengerjaan</a>
            </div>
            @endif
        </div>
    </div>
    @endforeach
    @endif
</div>
@endsection
