<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Import the Auth facade
use Illuminate\Support\Facades\Session; // Import the Session facade
class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // If the user is not authenticated, they will be redirected by Filament's own middleware.
        // We only need to check the role if they are authenticated.
        if (auth()->check() && auth()->user()->role !== $role) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            // If the role does not match, forbid access.
            return redirect('/')->with('error', 'You do not have the necessary role to access this page. You have been logged out.');
        }

        return $next($request);
    }
}
