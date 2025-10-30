<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles  // mendukung multiple roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        // Jika role user tidak termasuk dalam roles yang diberikan
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized: Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
