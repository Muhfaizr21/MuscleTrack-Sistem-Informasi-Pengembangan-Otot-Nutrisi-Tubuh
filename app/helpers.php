<?php

use Illuminate\Support\Facades\File;

if (!function_exists('safe_vite')) {
    function safe_vite(array $assets)
    {
        $manifestPath = public_path('build/manifest.json');

        // Jika manifest.json ada, pakai Vite normal
        if (File::exists($manifestPath)) {
            return app('Illuminate\Foundation\Vite')($assets);
        }

        // Kalau tidak ada, fallback ke file public/css dan public/js
        $html = '';
        foreach ($assets as $asset) {
            if (str_ends_with($asset, '.css')) {
                $html .= '<link rel="stylesheet" href="' . asset('css/app.css') . '">' . PHP_EOL;
            }
            if (str_ends_with($asset, '.js')) {
                $html .= '<script src="' . asset('js/app.js') . '" defer></script>' . PHP_EOL;
            }
        }
        return $html;
    }
}
