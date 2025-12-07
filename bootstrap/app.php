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

        // Atau tambahkan middleware global jika perlu
        // $middleware->web(append: [
        //     \App\Http\Middleware\YourMiddleware::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Custom 404 error handler
        $exceptions->render(function (
            \Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e,
            \Illuminate\Http\Request $request
        ) {
            // Return custom 404 view
            return response()->view('errors.404', [
                'title' => 'Halaman Tidak Ditemukan',
                'message' => 'Maaf, halaman yang Anda cari tidak ditemukan.',
                'error' => $e->getMessage(),
            ], 404);
        });

        // Custom 403 error handler (Forbidden/Access Denied)
        $exceptions->render(function (
            \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $e,
            \Illuminate\Http\Request $request
        ) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Anda tidak memiliki izin untuk mengakses halaman ini.'
                ], 403);
            }

            return response()->view('errors.403', [
                'title' => 'Akses Ditolak',
                'message' => 'Anda tidak memiliki izin untuk mengakses halaman ini.',
            ], 403);
        });

        // Custom 500 error handler (Server Error)
        $exceptions->render(function (
            \Throwable $e,
            \Illuminate\Http\Request $request
        ) {
            // Log error untuk debugging
            if (app()->environment('production')) {
                \Log::error('Server Error: ' . $e->getMessage(), [
                    'exception' => $e,
                    'url' => $request->fullUrl(),
                    'ip' => $request->ip(),
                ]);
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Terjadi kesalahan pada server. Silakan coba lagi nanti.'
                ], 500);
            }

            return response()->view('errors.500', [
                'title' => 'Kesalahan Server',
                'message' => 'Maaf, terjadi kesalahan pada server kami.',
            ], 500);
        });

        // ModelNotFoundException handler (untuk Eloquent)
        $exceptions->render(function (
            \Illuminate\Database\Eloquent\ModelNotFoundException $e,
            \Illuminate\Http\Request $request
        ) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Data tidak ditemukan.'
                ], 404);
            }

            return response()->view('errors.404', [
                'title' => 'Data Tidak Ditemukan',
                'message' => 'Data yang Anda cari tidak ditemukan.',
            ], 404);
        });

        // MethodNotAllowedHttpException handler
        $exceptions->render(function (
            \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException $e,
            \Illuminate\Http\Request $request
        ) {
            return response()->view('errors.405', [
                'title' => 'Method Tidak Diizinkan',
                'message' => 'Metode HTTP yang digunakan tidak diizinkan untuk URL ini.',
            ], 405);
        });
    })
    ->create();
