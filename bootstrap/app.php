<?php

use App\Http\Middleware\RoleMiddleware;
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
        // Daftarkan middleware role di sini
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // 🔥 IMPORTANT: Tampilkan error detail di development
        if (app()->environment('local', 'development')) {
            // Biarkan Laravel menampilkan error detail
            // Tidak ada custom handler untuk environment local
        } else {
            // Production error handlers
            $exceptions->render(function (
                \Throwable $e,
                \Illuminate\Http\Request $request
            ) {
                // Log error
                \Log::error('Error: ' . $e->getMessage(), [
                    'exception' => $e,
                    'url' => $request->fullUrl(),
                    'ip' => $request->ip(),
                    'trace' => $e->getTraceAsString()
                ]);

                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Terjadi kesalahan pada server.'
                    ], 500);
                }

                return response()->view('errors.500', [
                    'title' => 'Kesalahan Server',
                    'message' => 'Terjadi kesalahan pada server.',
                    'error_code' => 500
                ], 500);
            });
        }

        // Custom 404 error handler (hanya production)
        if (!app()->environment('local')) {
            $exceptions->render(function (
                \Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e,
                \Illuminate\Http\Request $request
            ) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Halaman tidak ditemukan.'
                    ], 404);
                }

                return response()->view('errors.404', [
                    'title' => 'Halaman Tidak Ditemukan',
                    'message' => 'Maaf, halaman yang Anda cari tidak ditemukan.',
                    'error_code' => 404
                ], 404);
            });
        }

        // Custom 403 error handler (hanya production)
        if (!app()->environment('local')) {
            $exceptions->render(function (
                \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $e,
                \Illuminate\Http\Request $request
            ) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Anda tidak memiliki izin.'
                    ], 403);
                }

                return response()->view('errors.403', [
                    'title' => 'Akses Ditolak',
                    'message' => 'Anda tidak memiliki izin untuk mengakses halaman ini.',
                    'error_code' => 403
                ], 403);
            });
        }

        // ModelNotFoundException handler
        $exceptions->render(function (
            \Illuminate\Database\Eloquent\ModelNotFoundException $e,
            \Illuminate\Http\Request $request
        ) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Data tidak ditemukan.'
                ], 404);
            }

            if (app()->environment('local')) {
                // Di local, tampilkan error detail
                throw $e;
            }

            return response()->view('errors.404', [
                'title' => 'Data Tidak Ditemukan',
                'message' => 'Data yang Anda cari tidak ditemukan.',
                'error_code' => 404
            ], 404);
        });
    })
    ->create();
