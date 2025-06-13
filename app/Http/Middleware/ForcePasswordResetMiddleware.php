<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordResetMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       
            $user = Auth::user();

               // Liste des routes à exclure du middleware
             // Routes à exclure pour éviter la boucle
                $excludedRoutes = [
                    'password.reset.forced',
                    'password.reset.handle',
                    'logout',
                ];

                if (
                    $user &&
                    $user->force_password_reset &&
                    !in_array($request->route()?->getName(), $excludedRoutes)
                ) {
                    return redirect()->route('password.reset.forced');
                }
    
            // if ($user && $user->force_password_reset) {
            //     return redirect()->route('password.reset.forced');
            // }
    
        return $next($request);
    }
}
