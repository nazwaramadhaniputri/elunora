<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if petugas is authenticated
        if (!Auth::guard('petugas')->check()) {
            // If not authenticated, redirect to admin login
            return redirect()->route('admin.login')->with('error', 'Anda harus login sebagai admin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
