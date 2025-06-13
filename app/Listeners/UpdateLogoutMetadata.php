<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateLogoutMetadata
{
    // php artisan make:listener UpdateLogoutMetadata --event=Illuminate\Auth\Events\Logout

    // C’est normal : dans Laravel 11 et 12, le système d’événements utilise une découverte automatique des listeners (Auto-Discovery), donc tu n’as plus besoin de EventServiceProvider.php par défaut.

    //Conseil bonus pour la fiabilité :Laravel utilise la mise en cache automatique des événements, donc après avoir ajouté ou modifié un listener, pense à rafraîchir le cache des events si tu rencontres des soucis :
    // php artisan event:clear
    // php artisan event:cache
    //composer dump-autoload

    // Pour vérifer : php artisan event:list


    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Logout $event): void
    {
         
        /** @var User $user */
        $user = $event->user;

        if ($user) {
            $user->is_active = false;
            $user->last_login_at = now();
            $user->save();
        }
    
    }
}
