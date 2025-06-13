<?php

use App\Http\Controllers\Auth\ForcePasswordController;
use App\Http\Controllers\Auth\UserRegisterController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Middleware\LogUserActivityMiddleware;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Routes accessibles sans authentification
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [UserLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UserLoginController::class, 'login'])->name('login.submit');

    Route::get('/password/forgot', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    Route::get('/password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [ForgotPasswordController::class, 'reset'])->name('password.update');


    // Route::get('/password/forgot', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    // Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // Route::post('/password/reset', [ForgotPasswordController::class, 'normalReset'])->name('password.submit');
    // Route::get('/password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');

   
});

/*
|--------------------------------------------------------------------------
| Routes protégées pour utilisateurs authentifiés
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', LogUserActivityMiddleware::class])->group(function () {

    // Middleware personnalisé : l’utilisateur doit avoir complété son profil
    Route::middleware( 'force.password.reset')->group(function () {


            Route::middleware('profile.completed', 'force.password.reset')->group(function () {

                        // Seulement les admins peuvent accéder à ces routes
                        Route::middleware('role:admin')->group(function () {

                            // Gestion des utilisateurs (création par l’admin)
                            Route::get('/register', [UserRegisterController::class, 'showAdminRegistrationForm'])->name('register');
                            Route::post('/register', [UserRegisterController::class, 'register'])->name('register.submit');

                            // Ressources
                            Route::resource('permissions', PermissionController::class);
                            Route::resource('roles', RoleController::class);
                        });

                        Route::post('/mon-compte/mot-de-passe', [UserController::class, 'updatePassword'])->name('user.password.update')->middleware('auth');

            });


            Route::get('/force-reset-password', [ForcePasswordController::class, 'showForceResetForm'])->name('password.reset.forced');
            Route::post('/force-reset-password', [ForcePasswordController::class, 'handleForceReset'])->name('password.reset.handle');
    });

    // Déconnexion (accessible à tout utilisateur connecté)
    Route::post('/logout', [UserLoginController::class, 'logout'])->name('logout');

    // Complétion du profil (si `profile_completed = false`)
    Route::get('/profile/complete', [ProfileController::class, 'showCompleteProfileForm'])->name('profile.complete');
    Route::post('/profile/complete', [ProfileController::class, 'handleCompleteProfile'])->name('profile.complete.submit');

    Route::get('/profile', [ProfileController::class, 'voirProfil'])->name('profile');
    Route::get ('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::get ('/setting', [ProfileController::class, 'update'])->name('profile.setting');

    Route::post ('/profile/set', [ProfileController::class, 'up'])->name('profile.update');


});

