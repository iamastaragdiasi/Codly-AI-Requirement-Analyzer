<?php

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trimStrings(except: ['original']);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->report(function (QueryException $exception): ?bool {
            if (request()->is('projects*')) {
                Log::error('Workspace database operation failed', ['sqlstate' => $exception->errorInfo[0] ?? null]);

                return false;
            }

            return null;
        });
        $exceptions->render(function (QueryException $exception, Request $request): ?Response {
            if ($request->is('projects*')) {
                return response('Workspace data operation failed. Retry or contact the local operator.', 503);
            }

            return null;
        });
        $exceptions->render(function (HttpException $exception, Request $request): ?Response {
            $status = $exception->getStatusCode();

            if (! $request->is('projects/*') || $request->expectsJson() || ! in_array($status, [409, 422], true)) {
                return null;
            }

            $message = $exception->getMessage() ?: ($status === 409
                ? 'The project revision changed. Reload before retrying.'
                : 'This action requires a current analysis and the appropriate scope review.');

            return response($message, $status)->header('Content-Type', 'text/plain; charset=UTF-8');
        });
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
