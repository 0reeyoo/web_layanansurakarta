@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-md p-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Galeri Kegiatan</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($galeriItems as $item)
            <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
                <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://via.placeholder.com/400x300' }}" class="w-full h-48 object-cover" alt="{{ $item->judul }}">
                <div class="p-4">
                    <p class="text-sm font-semibold text-gray-700">{{ $item->judul }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ optional($item->published_at)->format('d M Y') }}</p>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Belum ada galeri yang dipublikasikan.</p>
        @endforelse
    </div>
</div>
@endsection
