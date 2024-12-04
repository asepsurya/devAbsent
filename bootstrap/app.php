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
        $middleware->alias([

            'Clockwork' => Clockwork\Support\Laravel\Facade::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'SN' => Irfa\SerialNumber\Facades\SerialNumber::class,
            'Excel' => Maatwebsite\Excel\Facades\Excel::class,
            'NoCaptcha' => Anhskohbo\NoCaptcha\Facades\NoCaptcha::class,
            'statusRegister' => \App\Http\Middleware\RegisterCheck::class,
            'PDF' => Barryvdh\DomPDF\Facade::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
