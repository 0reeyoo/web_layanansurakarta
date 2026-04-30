<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KontenWeb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriBeritaController extends Controller
{
    public function index()
    {
        $galeriItems = KontenWeb::where('tipe', 'galeri')->latest()->paginate(8, ['*'], 'galeri_page');
        $beritaItems = KontenWeb::where('tipe', 'berita')->latest()->paginate(8, ['*'], 'berita_page');

        return view('admin.galeri-berita.index', compact('galeriItems', 'beritaItems'));
    }

    public function storeGaleri(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'required|image|max:10240',
        ]);

        $path = $request->file('gambar')->store('konten/galeri', 'public');

        KontenWeb::create([
            'tipe' => 'galeri',
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'gambar' => $path,
            'published_at' => now(),
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Item galeri berhasil ditambahkan.');
    }

    public function storeBerita(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|max:10240',
        ]);

        $path = $request->hasFile('gambar')
            ? $request->file('gambar')->store('konten/berita', 'public')
            : null;

        KontenWeb::create([
            'tipe' => 'berita',
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'gambar' => $path,
            'published_at' => now(),
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Berita berhasil ditambahkan.');
    }

    public function destroyGaleri($id)
    {
        $item = KontenWeb::where('tipe', 'galeri')->findOrFail($id);

        if ($item->gambar && Storage::disk('public')->exists($item->gambar)) {
            Storage::disk('public')->delete($item->gambar);
        }

        $item->delete();

        return back()->with('success', 'Item galeri berhasil dihapus.');
    }

    public function destroyBerita($id)
    {
        $item = KontenWeb::where('tipe', 'berita')->findOrFail($id);

        if ($item->gambar && Storage::disk('public')->exists($item->gambar)) {
            Storage::disk('public')->delete($item->gambar);
        }

        $item->delete();

        return back()->with('success', 'Berita berhasil dihapus.');
    }
}
