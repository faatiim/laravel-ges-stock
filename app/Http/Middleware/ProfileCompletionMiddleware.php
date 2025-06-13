<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfileCompletionMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Vérifier si c'est la première connexion
            if ($user->first_login_at === null) {
                return Redirect::route('password.reset')
                    ->with('message', 'Veuillez créer votre mot de passe.');
            }
            
            // Vérifier si le profil est complet
            if (!$user->profile_completed) {
                return Redirect::route('profile.edit')
                    ->with('message', 'Veuillez compléter votre profil.');
            }
        }
        
        return $next($request);
    }
}
