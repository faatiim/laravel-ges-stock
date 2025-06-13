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
     /**
     * Gère la vérification des rôles utilisateurs.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Accès refusé : utilisateur non authentifié.');
        }

        /** @var User $user */
        if (!$user->hasRole($role)) {
            // Tu peux rediriger ou abort selon le besoin
            abort(403, "Accès refusé : vous devez avoir le rôle « $role ».");
        }

        return $next($request);
    }
}
