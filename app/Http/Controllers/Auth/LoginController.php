<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Tidak perlu $redirectTo jika sudah menggunakan fungsi authenticated() di bawah
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Menampilkan halaman login sesuai desain Anda
     */
    public function showLoginForm()
    {
        return view('auth.login-user');
    }

    public function showAdminLoginForm()
    {
        return view('auth.login');
    }

    public function loginAdmin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()->withErrors([
                'email' => 'Email/username atau password salah.',
            ])->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        if (Auth::user()->role !== 'admin') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Akses ini khusus admin.',
            ]);
        }

        return $this->redirectAdminByDinasRole(Auth::user());
    }

    /**
     * Logika pengalihan setelah login berhasil
     */
    protected function authenticated(Request $request, $user)
    {
        // Pastikan kolom 'role' ada di database tabel users
        if ($user->role === 'admin') {
            return $this->redirectAdminByDinasRole($user);
        }

        // Jika bukan admin, arahkan ke riwayat pengaduan milik user
        return redirect()->route('pengaduan.riwayat');
    }

    private function redirectAdminByDinasRole($user)
    {
        return match ($user->dinas_role) {
            'PUPR' => redirect()->route('admin-pupr.dashboard'),
            'DLH' => redirect()->route('admin-dlh.dashboard'),
            'PERHUBUNGAN' => redirect()->route('admin-perhubungan.dashboard'),
            default => redirect()->route('admin.dashboard'),
        };
    }

    /**
     * Modifikasi attemptLogin untuk 'Remember Me' otomatis
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), true // memaksa remember me bernilai true
        );
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
