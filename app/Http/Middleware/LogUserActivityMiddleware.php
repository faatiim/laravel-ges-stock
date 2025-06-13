<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class LogUserActivityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // DB::table('users')->where('id', Auth::id())->update([
            //     'last_seen_at' => now(),
            // ]);
            /** @var User $user */
            $user = Auth::user();
            // ✅ On vérifie que l’objet est bien un modèle Eloquent et modifiable
            if ($user && method_exists($user, 'save')) {
                try {
                    $user->last_seen_at = now();
                    $user->save();
                } catch (\Throwable $e) {
                    // Tu peux logger l'erreur ou faire un dd($e->getMessage()) temporairement
                    logger()->error('Erreur LogUserActivity: '.$e->getMessage());
                }
            }

        }
        return $next($request);
    }
}
