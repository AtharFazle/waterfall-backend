<?php

use App\Http\Middleware\VerifyIotToken;
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
    ->withMiddleware(function (Middleware $middleware): void {
        // $middleware->append(VerifyIotToken::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
            $exceptions->render(function (\Illuminate\Http\Exceptions\PostTooLargeException $e, $request) {
                    return response()->json([
                        'error' => 'File terlalu besar',
                        'message' => 'Ukuran file melebihi batas maksimal'
                    ], 413);
            return back()->with('error', 'File terlalu besar. Silakan pilih file yang lebih kecil.');
        });
    })->create();
