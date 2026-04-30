<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    // Menampilkan halaman riwayat dengan data dari database
    public function riwayat()
    {
        // Ambil pengaduan milik user yang sedang login, urutkan dari yang terbaru
        $pengaduans = Pengaduan::where('user_id', Auth::id())->latest()->get();
        
        return view('pengaduan.riwayat', compact('pengaduans'));
    }

    public function store(Request $request)
    {
        $categories = Pengaduan::getCategories();

        // 1. Validasi Input
        $validated = $request->validate(
            [
                'nama' => 'required|string|max:255',
                'ktp' => 'required|digits:16',
                'telp' => 'required|string|max:20',
                'alamat' => 'required|string|max:255',
                'kategori' => 'required|in:' . implode(',', array_keys($categories)),
                'deskripsi' => 'required|string',
                'foto' => 'required|image|max:10240', // Maks 10MB
                'lat' => 'required|numeric|between:-90,90',
                'lng' => 'required|numeric|between:-180,180',
            ],
            [
                'required' => ':attribute wajib diisi.',
                'ktp.digits' => 'KTP harus 16 digit.',
                'foto.image' => 'File foto harus berupa gambar.',
                'foto.max' => 'Ukuran foto maksimal 10MB.',
                'lat.numeric' => 'Lokasi latitude tidak valid.',
                'lng.numeric' => 'Lokasi longitude tidak valid.',
            ],
            [
                'nama' => 'Nama Lengkap',
                'ktp' => 'KTP',
                'telp' => 'No. Telepon',
                'alamat' => 'Alamat',
                'kategori' => 'Kategori',
                'deskripsi' => 'Deskripsi Pengaduan',
                'foto' => 'Foto Kejadian',
                'lat' => 'Lokasi',
                'lng' => 'Lokasi',
            ]
        );

        $withinSurakarta = $validated['lat'] >= -7.65
            && $validated['lat'] <= -7.49
            && $validated['lng'] >= 110.70
            && $validated['lng'] <= 110.92;

        if (! $withinSurakarta) {
            return back()
                ->withErrors(['lat' => 'Lokasi pengaduan harus berada di wilayah Surakarta.'])
                ->withInput();
        }

        // 2. Upload Foto jika ada
        $pathFoto = null;
        $pathFoto = $request->file('foto')->store('bukti_pengaduan', 'public');

        // 3. Dapatkan dinas dari kategori
        $dinas = $categories[$validated['kategori']] ?? null;

        // 4. Simpan ke Database
        Pengaduan::create([
            'user_id' => Auth::id(),
            'nama_pelapor' => $validated['nama'],
            'ktp' => $validated['ktp'],
            'no_telp' => $validated['telp'],
            'alamat_pelapor' => $validated['alamat'],
            'kategori' => $validated['kategori'],
            'dinas' => $dinas,
            'tanggal_kejadian' => now()->toDateString(),
            'deskripsi' => $validated['deskripsi'],
            'latitude' => $validated['lat'],
            'longitude' => $validated['lng'],
            'foto_bukti' => $pathFoto,
            'status' => 'Menunggu',
        ]);

        // 5. Redirect ke halaman riwayat
        return redirect()->route('pengaduan.riwayat')->with('success', 'Terimakasih atas aduan yang diberikan');
    }
}
