<?php

namespace App\Http\Middleware;

use App\Helper\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->role !== UserRole::ADMIN) {
            return redirect()->route('home');
        }
        return $next($request);
    }
}
