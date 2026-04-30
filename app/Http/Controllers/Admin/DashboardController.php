<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dinasQuery = $user && $user->dinas_role ? ['dinas' => $user->dinas_role] : [];

        $stats = [
            'total_pengaduan' => Pengaduan::where($dinasQuery)->count(),
            'menunggu' => Pengaduan::where('status', 'Menunggu')->where($dinasQuery)->count(),
            'proses' => Pengaduan::where('status', 'Diproses')->where($dinasQuery)->count(),
            'selesai' => Pengaduan::where('status', 'Selesai')->where($dinasQuery)->count(),
            'total_user' => User::where(function ($query) {
                $query->where('role', '!=', 'admin')->orWhereNull('role');
            })->count(),
        ];

        $pengaduanTerbaru = Pengaduan::where($dinasQuery)->latest()->take(8)->get();

        return view('admin.dashboard', compact('stats', 'pengaduanTerbaru'));
    }
}
