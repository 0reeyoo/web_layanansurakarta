<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GaleriBeritaController;
use App\Http\Controllers\Admin\KategoriPengaduanController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\ProfilController;
use App\Models\KontenWeb;
use App\Models\Pengaduan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Halaman Utama (Dashboard)
Route::get('/', function () {
    try {
        $galeriSlides = KontenWeb::where('tipe', 'galeri')
            ->whereNotNull('gambar')
            ->latest()
            ->take(8)
            ->get();

        $stats = [
            'total' => Pengaduan::count(),
            'menunggu' => Pengaduan::where('status', 'Menunggu')->count(),
            'diproses' => Pengaduan::where('status', 'Diproses')->count(),
            'selesai' => Pengaduan::where('status', 'Selesai')->count(),
        ];
    } catch (QueryException $e) {
        report($e);
        $galeriSlides = collect();
        $stats = [
            'total' => 0,
            'menunggu' => 0,
            'diproses' => 0,
            'selesai' => 0,
        ];
    }

    return view('dashboard', compact('galeriSlides', 'stats'));
})->name('home');

// 2. Rute Autentikasi (Hanya bisa diakses jika BELUM Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/admin/login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login');
    Route::post('/admin/login', [LoginController::class, 'loginAdmin'])->name('admin.login.submit');
    
    // Login Admin Dinas
    Route::get('/login-admin-dinas', function () {
        return view('auth.login-admin-dinas');
    })->name('login.admin.dinas');

    Route::get('/login-admin-dinas/pupr', function () {
        return redirect()->route('login.admin.dinas', [
            'email' => 'admin-pupr@mail.com',
            'password' => 'password123',
            'dinas' => 'PUPR',
        ]);
    })->name('login.admin.dinas.pupr');

    Route::get('/login-admin-dinas/dlh', function () {
        return redirect()->route('login.admin.dinas', [
            'email' => 'admin-dlh@mail.com',
            'password' => 'password123',
            'dinas' => 'DLH',
        ]);
    })->name('login.admin.dinas.dlh');

    Route::get('/login-admin-dinas/perhubungan', function () {
        return redirect()->route('login.admin.dinas', [
            'email' => 'admin-perhubungan@mail.com',
            'password' => 'password123',
            'dinas' => 'PERHUBUNGAN',
        ]);
    })->name('login.admin.dinas.perhubungan');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/register', [RegisterController::class, 'register']);
});

// Logout umum untuk user yang sudah login
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->middleware('auth')->name('logout');

// 3. Rute Profil, Galeri, dan Berita (Bisa diakses publik/tanpa login)
Route::prefix('profil')->group(function () {
    Route::get('/visi-misi', function () {
        return view('profil.visi-misi');
    })->name('profil.visi-misi');

    Route::get('/struktur', function () {
        return view('profil.struktur');
    })->name('profil.struktur');

    Route::get('/galeri', [ProfilController::class, 'galeri'])->name('profil.galeri');
    Route::get('/berita', [ProfilController::class, 'berita'])->name('profil.berita');

    Route::get('/user', function () {
        return "Halaman Profil Pengguna";
    })->middleware('auth')->name('profil.user');
});

// 4. Rute Pengaduan (DITAMBAHKAN MIDDLEWARE AUTH)
// Artinya: Hanya orang yang sudah login yang bisa mengakses rute di dalam grup ini
Route::middleware(['auth'])->prefix('pengaduan')->group(function () {
    
    // Halaman Form Buat Pengaduan
    Route::get('/buat', function () {
        try {
            $galeriBackgrounds = KontenWeb::where('tipe', 'galeri')
                ->whereNotNull('gambar')
                ->latest()
                ->take(10)
                ->get();
        } catch (QueryException $e) {
            report($e);
            $galeriBackgrounds = collect();
        }

        return view('pengaduan.create', compact('galeriBackgrounds'));
    })->name('pengaduan.create');

    // Halaman Riwayat Pengaduan
    Route::get('/riwayat', [PengaduanController::class, 'riwayat'])->name('pengaduan.riwayat');

    // Rute POST untuk simpan data (Nanti dihubungkan ke Controller)
    Route::post('/simpan', [PengaduanController::class, 'store'])->name('pengaduan.store');
});

// 5. Rute Admin (Umum untuk semua admin)
Route::prefix('admin')->middleware(['auth', 'checkRole:admin'])->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Manajemen Pengaduan
    Route::get('/pengaduan', [AdminPengaduanController::class, 'index'])->name('admin.pengaduan.index');
    Route::get('/pengaduan/proses', [AdminPengaduanController::class, 'proses'])->name('admin.pengaduan.proses');
    Route::get('/pengaduan/selesai', [AdminPengaduanController::class, 'selesai'])->name('admin.pengaduan.selesai');
    Route::get('/pengaduan/{id}', [AdminPengaduanController::class, 'show'])->whereNumber('id')->name('admin.pengaduan.show');
    Route::post('/pengaduan/{id}/status', [AdminPengaduanController::class, 'updateStatus'])->name('admin.pengaduan.updateStatus');

    // Manajemen User
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // Manajemen Galeri & Berita
    Route::get('/galeri-berita', [GaleriBeritaController::class, 'index'])->name('admin.galeri-berita.index');
    Route::post('/galeri-berita/galeri', [GaleriBeritaController::class, 'storeGaleri'])->name('admin.galeri-berita.storeGaleri');
    Route::post('/galeri-berita/berita', [GaleriBeritaController::class, 'storeBerita'])->name('admin.galeri-berita.storeBerita');
    Route::delete('/galeri-berita/galeri/{id}', [GaleriBeritaController::class, 'destroyGaleri'])->name('admin.galeri-berita.destroyGaleri');
    Route::delete('/galeri-berita/berita/{id}', [GaleriBeritaController::class, 'destroyBerita'])->name('admin.galeri-berita.destroyBerita');

    // Manajemen Kategori Layanan
    Route::get('/kategori-layanan', [KategoriPengaduanController::class, 'index'])->name('admin.kategori.index');
    Route::post('/kategori-layanan', [KategoriPengaduanController::class, 'store'])->name('admin.kategori.store');
    Route::delete('/kategori-layanan/{id}', [KategoriPengaduanController::class, 'destroy'])->name('admin.kategori.destroy');

    // Logout khusus admin
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    })->name('admin.logout');
});

// 5.1 Rute Admin Dinas PUPR
Route::prefix('admin-pupr')->middleware(['auth', 'checkDinasRole:PUPR'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin-pupr.dashboard');
    Route::get('/pengaduan', [AdminPengaduanController::class, 'index'])->name('admin-pupr.pengaduan.index');
    Route::get('/pengaduan/proses', [AdminPengaduanController::class, 'proses'])->name('admin-pupr.pengaduan.proses');
    Route::get('/pengaduan/selesai', [AdminPengaduanController::class, 'selesai'])->name('admin-pupr.pengaduan.selesai');
    Route::get('/pengaduan/{id}', [AdminPengaduanController::class, 'show'])->whereNumber('id')->name('admin-pupr.pengaduan.show');
    Route::post('/pengaduan/{id}/status', [AdminPengaduanController::class, 'updateStatus'])->name('admin-pupr.pengaduan.updateStatus');
    Route::get('/kategori-layanan', [KategoriPengaduanController::class, 'index'])->name('admin-pupr.kategori.index');
    Route::post('/kategori-layanan', [KategoriPengaduanController::class, 'store'])->name('admin-pupr.kategori.store');
    Route::delete('/kategori-layanan/{id}', [KategoriPengaduanController::class, 'destroy'])->name('admin-pupr.kategori.destroy');
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('admin-pupr.logout');
});

// 5.2 Rute Admin Dinas DLH
Route::prefix('admin-dlh')->middleware(['auth', 'checkDinasRole:DLH'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin-dlh.dashboard');
    Route::get('/pengaduan', [AdminPengaduanController::class, 'index'])->name('admin-dlh.pengaduan.index');
    Route::get('/pengaduan/proses', [AdminPengaduanController::class, 'proses'])->name('admin-dlh.pengaduan.proses');
    Route::get('/pengaduan/selesai', [AdminPengaduanController::class, 'selesai'])->name('admin-dlh.pengaduan.selesai');
    Route::get('/pengaduan/{id}', [AdminPengaduanController::class, 'show'])->whereNumber('id')->name('admin-dlh.pengaduan.show');
    Route::post('/pengaduan/{id}/status', [AdminPengaduanController::class, 'updateStatus'])->name('admin-dlh.pengaduan.updateStatus');
    Route::get('/kategori-layanan', [KategoriPengaduanController::class, 'index'])->name('admin-dlh.kategori.index');
    Route::post('/kategori-layanan', [KategoriPengaduanController::class, 'store'])->name('admin-dlh.kategori.store');
    Route::delete('/kategori-layanan/{id}', [KategoriPengaduanController::class, 'destroy'])->name('admin-dlh.kategori.destroy');
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('admin-dlh.logout');
});

// 5.3 Rute Admin Dinas PERHUBUNGAN
Route::prefix('admin-perhubungan')->middleware(['auth', 'checkDinasRole:PERHUBUNGAN'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin-perhubungan.dashboard');
    Route::get('/pengaduan', [AdminPengaduanController::class, 'index'])->name('admin-perhubungan.pengaduan.index');
    Route::get('/pengaduan/proses', [AdminPengaduanController::class, 'proses'])->name('admin-perhubungan.pengaduan.proses');
    Route::get('/pengaduan/selesai', [AdminPengaduanController::class, 'selesai'])->name('admin-perhubungan.pengaduan.selesai');
    Route::get('/pengaduan/{id}', [AdminPengaduanController::class, 'show'])->whereNumber('id')->name('admin-perhubungan.pengaduan.show');
    Route::post('/pengaduan/{id}/status', [AdminPengaduanController::class, 'updateStatus'])->name('admin-perhubungan.pengaduan.updateStatus');
    Route::get('/kategori-layanan', [KategoriPengaduanController::class, 'index'])->name('admin-perhubungan.kategori.index');
    Route::post('/kategori-layanan', [KategoriPengaduanController::class, 'store'])->name('admin-perhubungan.kategori.store');
    Route::delete('/kategori-layanan/{id}', [KategoriPengaduanController::class, 'destroy'])->name('admin-perhubungan.kategori.destroy');
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('admin-perhubungan.logout');
});
