<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;            // Import the Admin middleware we created
use App\Http\Middleware\EmployeeAccessMiddleware;   // Import the Employee middleware we created

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register aliases so you can use 'admin' or 'employee' as shorthand strings in routes
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'employee' => EmployeeAccessMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();