<?php

namespace App\Http\Controllers;

use App\Models\KontenWeb;

class ProfilController extends Controller
{
    public function galeri()
    {
        $galeriItems = KontenWeb::where('tipe', 'galeri')->latest()->get();
        return view('profil.galeri', compact('galeriItems'));
    }

    public function berita()
    {
        $beritaItems = KontenWeb::where('tipe', 'berita')->latest()->get();
        return view('profil.berita', compact('beritaItems'));
    }
}
