<?php

use App\Exceptions\AccessDeniedHttpExceptionRenderer;
use App\Exceptions\NotFoundHttpExceptionRenderer;
use App\Exceptions\UnauthorizedExceptionRenderer;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));

            Route::middleware('api')
                ->prefix('api/v1')
                ->name('api.v1.')
                ->group(base_path('routes/api_v1.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        if (request()->is('api/*') || request()->is('admin/*')) {

            $exceptions->renderable(function (UnauthorizedException $e) {
                return (new UnauthorizedExceptionRenderer)->handle($e);
            });

            $exceptions->renderable(function (NotFoundHttpException $e) {
                return (new NotFoundHttpExceptionRenderer)->handle($e);
            });

            $exceptions->renderable(function (AccessDeniedHttpException $e) {
                return (new AccessDeniedHttpExceptionRenderer)->handle($e->getMessage());
            });

        }
    })->create();
