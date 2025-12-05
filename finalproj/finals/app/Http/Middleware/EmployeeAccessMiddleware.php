<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EmployeeAccessMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow if user is Admin OR Employee
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'employee'])) {
            return $next($request);
        }

        abort(403, 'Unauthorized access - Admins or Employees only.');
    }
}