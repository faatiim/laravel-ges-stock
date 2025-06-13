<?php

namespace App\Listeners;

// use App\Events\UserLoggedIn;

use App\Models\User;
use Illuminate\Auth\Events\Login;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Queue\InteractsWithQueue;

class UpdateLoginMetadata
{
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
    public function handle(Login $event): void
    {
      /** @var User  */
        $user = $event->user;

        // Si c’est la première connexion, on la marque
        if (!$user->first_login_at) {
            $user->first_login_at = now();
        }
        // $user->first_login_at = $user->first_login_at ?? now();

        $user->last_login_at = now();
        $user->is_active = true;
        $user->save();
    }

}
