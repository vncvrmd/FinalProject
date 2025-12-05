<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Check if the user's role is in the list of allowed roles
        // We look for the user's role inside the array of allowed $roles passed from the route
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // 3. Unauthorized: Abort with 403 Forbidden
        abort(403, 'Unauthorized action.');
    }
}