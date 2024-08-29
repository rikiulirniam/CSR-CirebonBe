<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('mitra')->check() || Auth::guard('admin')->check()) {
            return $next($request);
        } else {
            return response()->json([
                'message' => 'Kamu harus login sebagai mitra'
            ], 401);
        }
    }
}
