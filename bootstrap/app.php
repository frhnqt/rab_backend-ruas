<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {

    $exceptions->render(function (
        ValidationException $e,
        $request
    ) {

        if ($request->expectsJson()) {

            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);

        }

    });

    $exceptions->render(function (
    NotFoundHttpException $e,
    $request
    ) {

    if ($request->expectsJson()) {

        return response()->json([
            'success' => false,
            'message' => 'Data tidak ditemukan',
            'errors' => null,
        ], 404);

    }

    });

    $exceptions->render(function (
    AuthenticationException $e,
    $request
    ) {

    if ($request->expectsJson()) {

        return response()->json([
            'success' => false,
            'message' => 'Anda belum login',
            'errors' => null,
        ], 401);

    }

    });

    $exceptions->render(function (
    Throwable $e,
    $request
    ) {

    if ($request->expectsJson()) {

        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan pada server',
            'errors' => null,
        ], 500);

    }

    });

    })->create();

    
