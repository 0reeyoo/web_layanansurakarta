@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-md p-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Berita Terkini</h2>
    <div class="space-y-6">
        @forelse($beritaItems as $item)
            <div class="flex flex-col md:flex-row gap-6 p-4 rounded-lg border border-gray-100">
                <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://via.placeholder.com/200x150' }}" class="w-full md:w-48 h-32 object-cover rounded-lg" alt="{{ $item->judul }}">
                <div class="flex-grow">
                    <h3 class="text-xl font-bold text-gray-800">{{ $item->judul }}</h3>
                    <p class="text-sm text-gray-500 my-2">Admin • {{ optional($item->published_at)->format('d M Y') }}</p>
                    <p class="text-gray-600">{{ \Illuminate\Support\Str::limit($item->deskripsi, 180) }}</p>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Belum ada berita yang dipublikasikan.</p>
        @endforelse
    </div>
</div>
@endsection
