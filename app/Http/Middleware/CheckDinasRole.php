<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckDinasRole
{
    public function handle(Request $request, Closure $next, $dinas)
    {
        $user = $request->user();
        
        if (!$user || $user->dinas_role !== $dinas || $user->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}
