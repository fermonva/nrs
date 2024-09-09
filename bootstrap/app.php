<?php

use App\Exceptions\ClientCreationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->map(ClientCreationException::class, function (ClientCreationException $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        });
    })->create();
