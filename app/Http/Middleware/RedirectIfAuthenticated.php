<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                if ($user && $user->role === 'admin') {
                    return match ($user->dinas_role) {
                        'PUPR' => redirect()->route('admin-pupr.dashboard'),
                        'DLH' => redirect()->route('admin-dlh.dashboard'),
                        'PERHUBUNGAN' => redirect()->route('admin-perhubungan.dashboard'),
                        default => redirect()->route('admin.dashboard'),
                    };
                }

                if ($user) {
                    return redirect()->route('pengaduan.riwayat');
                }

                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
