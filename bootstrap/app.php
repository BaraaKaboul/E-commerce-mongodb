<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Router;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
       function (Router $router){
            $router->middleware('web')
                ->group(base_path('routes/web.php'));

           $router->middleware('web')
               ->prefix('admin')
               ->group(base_path('routes/admin.php'));

           $router->middleware('web')
               ->prefix('user')
               ->group(base_path('routes/user.php'));
       },
        commands: __DIR__.'/../routes/console.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'AuthAdmin'=>App\Http\Middleware\AuthAdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
