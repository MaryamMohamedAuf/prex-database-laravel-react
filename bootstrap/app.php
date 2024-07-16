<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
            \App\Http\Middleware\CorsMiddleware::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            

        ]);

        $middleware->validateCsrfTokens(except: [
          //  'api/cohorts/create',
            'cohorts/create'
        ]);

        return $middleware;
    
    })


    
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

    $app->middleware([
      //  \App\Http\Middleware\CorsMiddleware::class,
      // \App\Http\Middleware\VerifyCsrfToken::class,

    ]);
   
