<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        foreach ($roles as $role) {
            if ($user->role === $role) {
                return $next($request);
            }
        }

        // Jika user tidak memiliki role yang sesuai
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return redirect()->route('dosen.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
    }
}
