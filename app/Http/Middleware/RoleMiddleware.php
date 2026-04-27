<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next,...$roles): Response
    {
        if(!auth()->check()){
            return redirect('/login');
        }

        $user = auth()->user();

        foreach ($roles as $role) {
            if ($role === 'admin' && $user->Admin()) {
                return $next($request);
            }
            if ($role === 'jefe' && $user->Jefe()) {
                return $next($request);
            }
        }
        abort(403, 'No tienes permiso para acceder a esta zona.');
    }
}
