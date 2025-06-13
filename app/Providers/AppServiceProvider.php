<?php

namespace App\Providers;

use App\Models\Outil;
use App\Services\Contracts\OutilService;
use App\Services\Impl\OutilServiceImpl;
use App\Services\UserService;
use App\Services\Impl\UserServiceImpl;
use App\Services\Impl\VenteServiceImpl;
use App\Services\VenteService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserService::class, UserServiceImpl::class);
        $this->app->bind(OutilService::class, OutilServiceImpl::class);
        $this->app->bind(VenteService::class, VenteServiceImpl::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
          // Calcul du nombre de notifications de stock
          View::composer('*', function ($view) {
            $stockAlert = Outil::whereColumn('stock_actuel', '<=', 'seuil_alerte')
                               ->orderBy('stock_actuel', 'asc')
                               ->get();
    
            $notificationsCount = $stockAlert->where('stock_actuel', 0)->count();
    
            $view->with([
                'stockAlert' => $stockAlert,
                'notificationsCount' => $notificationsCount,
            ]);
        });
    
    }
}
