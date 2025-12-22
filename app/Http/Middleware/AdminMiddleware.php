<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login');
        }

        $user = auth()->user();
        
        if (!$user->isAdmin() && !$user->isStaff()) {
            auth()->logout();
            return redirect()->route('admin.login')
                ->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}
