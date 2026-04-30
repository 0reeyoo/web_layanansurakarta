@extends('layouts.admin')

@section('content')
@if(session('success'))
    <div class="mb-4 bg-emerald-100 text-emerald-700 px-4 py-3 rounded">{{ session('success') }}</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white border rounded-xl p-5">
        <h3 class="font-bold mb-4">Tambah Galeri</h3>
        <form method="POST" action="{{ route('admin.galeri-berita.storeGaleri') }}" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <input type="text" name="judul" placeholder="Judul galeri" class="w-full border rounded p-2" required>
            <textarea name="deskripsi" placeholder="Deskripsi singkat" class="w-full border rounded p-2"></textarea>
            <input type="file" name="gambar" class="w-full border rounded p-2" required>
            <button class="bg-navy-700 text-white px-4 py-2 rounded">Simpan Galeri</button>
        </form>
    </div>
    <div class="bg-white border rounded-xl p-5">
        <h3 class="font-bold mb-4">Tambah Berita</h3>
        <form method="POST" action="{{ route('admin.galeri-berita.storeBerita') }}" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <input type="text" name="judul" placeholder="Judul berita" class="w-full border rounded p-2" required>
            <textarea name="deskripsi" placeholder="Isi berita" class="w-full border rounded p-2" rows="4" required></textarea>
            <input type="file" name="gambar" class="w-full border rounded p-2">
            <button class="bg-navy-700 text-white px-4 py-2 rounded">Simpan Berita</button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white border rounded-xl overflow-x-auto">
        <div class="p-4 border-b"><h4 class="font-bold">Daftar Galeri</h4></div>
        <table class="w-full text-sm">
            <thead class="bg-slate-50"><tr><th class="p-3 text-left">Judul</th><th class="p-3 text-left">Tanggal</th><th class="p-3 text-left">Aksi</th></tr></thead>
            <tbody>
                @forelse($galeriItems as $item)
                    <tr class="border-t">
                        <td class="p-3">{{ $item->judul }}</td>
                        <td class="p-3">{{ optional($item->published_at)->format('d M Y') }}</td>
                        <td class="p-3">
                            <form method="POST" action="{{ route('admin.galeri-berita.destroyGaleri', $item->id) }}" onsubmit="return confirm('Hapus galeri ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="p-3 text-slate-500">Belum ada galeri.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="bg-white border rounded-xl overflow-x-auto">
        <div class="p-4 border-b"><h4 class="font-bold">Daftar Berita</h4></div>
        <table class="w-full text-sm">
            <thead class="bg-slate-50"><tr><th class="p-3 text-left">Judul</th><th class="p-3 text-left">Tanggal</th><th class="p-3 text-left">Aksi</th></tr></thead>
            <tbody>
                @forelse($beritaItems as $item)
                    <tr class="border-t">
                        <td class="p-3">{{ $item->judul }}</td>
                        <td class="p-3">{{ optional($item->published_at)->format('d M Y') }}</td>
                        <td class="p-3">
                            <form method="POST" action="{{ route('admin.galeri-berita.destroyBerita', $item->id) }}" onsubmit="return confirm('Hapus berita ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="p-3 text-slate-500">Belum ada berita.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
