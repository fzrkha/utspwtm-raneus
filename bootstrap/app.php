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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'cekUser' => \App\Http\Middleware\CekUser::class,
        ]);

        $middleware->redirectUsersTo(function (Request $request) {
            if ($request->user()->level == 'administrasi') {
                return '/admin';
            }

            if ($request->user()->level == 'gurubk') {
                return '/guru';
            }

            return '/';
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
