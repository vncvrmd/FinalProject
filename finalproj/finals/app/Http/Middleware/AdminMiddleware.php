<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in AND is an admin (case-insensitive)
        if (Auth::check() && strtolower(Auth::user()->role) === 'admin') {
            return $next($request);
        }

        // If not, show 403 Unauthorized
        abort(403, 'Unauthorized access - Admins only.');
    }
}