<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php', // Đăng ký routes api
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->statefulApi();
        
        // Khối này = $middleware->statefulApi();
        // Import middleware của Sanctum: use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
        // Đây chính là file Kernel.php "mới"
        // $middleware->api([
        //     EnsureFrontendRequestsAreStateful::class,
        //     'throttle:api', // Middleware này để chống DDOS (giới hạn request)
        //     \Illuminate\Routing\Middleware\SubstituteBindings::class, // Cái này để Route Model Binding (ví dụ: /api/posts/{post}) hoạt động
        // ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
