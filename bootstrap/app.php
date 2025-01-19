<?php

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
        //
        $middleware->web([
            \App\Http\Middleware\SetLocale::class,
        ]);

        $middleware->alias([
            'checkUserStatus' => \App\Http\Middleware\checkUserStatus::class,
            'checkPaymentStatus' => \App\Http\Middleware\checkPaymentStatus::class,
            'checkStatus' => \App\Http\Middleware\checkStatus::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
