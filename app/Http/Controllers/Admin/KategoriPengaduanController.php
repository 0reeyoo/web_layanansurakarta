<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPengaduan;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class KategoriPengaduanController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $dinasQuery = $user->dinas_role ? ['dinas' => $user->dinas_role] : [];

        $kategoris = KategoriPengaduan::where($dinasQuery)->orderBy('dinas')->orderBy('nama')->get();

        return view('admin.kategori.index', [
            'kategoris' => $kategoris,
            'dinasOptions' => Pengaduan::getDinas(),
            'isDinasAdmin' => (bool) $user->dinas_role,
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $isDinasAdmin = (bool) $user->dinas_role;

        $rules = [
            'nama' => 'required|string|max:255',
            'dinas' => 'required|string|in:PUPR,DLH,PERHUBUNGAN',
        ];

        if ($isDinasAdmin) {
            $rules['dinas'] = 'nullable';
        }

        $validated = $request->validate($rules);

        $dinas = $isDinasAdmin ? $user->dinas_role : ($validated['dinas'] ?? null);

        if (! $dinas) {
            return back()->with('error', 'Dinas untuk kategori tidak valid.');
        }

        KategoriPengaduan::firstOrCreate(
            ['nama' => trim($validated['nama']), 'dinas' => $dinas],
            ['is_active' => true, 'created_by' => auth()->id()]
        );

        return back()->with('success', 'Kategori layanan berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $kategori = KategoriPengaduan::findOrFail($id);

        if ($user->dinas_role && $kategori->dinas !== $user->dinas_role) {
            abort(403, 'Anda tidak memiliki akses ke kategori ini');
        }

        $kategori->delete();

        return back()->with('success', 'Kategori layanan berhasil dihapus.');
    }
}

