<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Outil\OutilController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\Vente\VenteController;
use App\Http\Middleware\LogUserActivityMiddleware;
use App\Http\Middleware\UpdateOnlineStatusMiddleware;
use App\Models\Category;

Route::get('/', [UserLoginController::class, 'showLoginForm'])->name('login');

/*
|--------------------------------------------------------------------------
| Routes protégées pour utilisateurs authentifiés
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', LogUserActivityMiddleware::class])->group(function () {
    // ici, UpdateOnlineStatusMiddleware tourne automatiquement
   
    // Middleware personnalisé : l’utilisateur doit avoir complété son profil
    Route::middleware( 'force.password.reset')->group(function () {


        Route::middleware('profile.completed', 'force.password.reset')->group(function () {

            Route::get('home',  [HomeController::class, 'home'])->name('dashboard');

            Route::resource('users', UserController::class);

            Route::resource('categories', CategoryController::class);

            Route::resource('outil', OutilController::class);

            Route::get('/ventes', [VenteController::class, 'index'])->name('ventes.index');
            Route::get('/vente', [VenteController::class, 'create'])->name('ventes.create');
            Route::post('/ventes', [VenteController::class, 'store'])->name('ventes.store');
            Route::get('/ventes/{id}', [VenteController::class, 'show'])->name('ventes.show');
            Route::put('/ventes/{vente}', [VenteController::class, 'update'])->name('ventes.update');
            Route::get('ventes/{vente}/facture', [VenteController::class, 'downloadFacture'])
                    ->name('ventes.facture');  
            

            Route::get('/stock-alerts', [StockController::class, 'alerts'])->name('stock.alerts');

        });
    });

});


require __DIR__.'/auth.php';
