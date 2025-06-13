<?php

use App\Http\Middleware\ForcePasswordResetMiddleware;
use App\Http\Middleware\LogUserActivityMiddleware;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\ProfileCompletionMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
                // Middleware nommé
       // $middleware->alias('profile.completed', \App\Http\Middleware\ProfileCompletionMiddleware::class);

          // Middleware nommé sous forme de tableau
          $middleware->alias([
            'profile.completed' => ProfileCompletionMiddleware::class,
            'force.password.reset' => ForcePasswordResetMiddleware::class,
            'role' => RoleMiddleware::class, 
            'online' => LogUserActivityMiddleware::class,
        ]);


    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
