<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    /**
 * Bootstrap any application services.
 */
public function boot(): void
{
    // ===== TAMBAHKAN BLOK "CIAMIK" INI =====

    // Kirim data notifikasi ke layout Trainer DAN User
    View::composer(['layouts.trainer', 'layouts.user'], function ($view) {

        $unreadCount = 0; // Default (jika belum login)

        if (Auth::check()) {
            // Ambil user yang sedang login
            $user = Auth::user();

            // Hitung notifikasi yang 'read_status' == false (atau 0)
            // Kita gunakan relasi 'notifications()' yang ada di Model User
            $unreadCount = $user->notifications()
                                ->where('read_status', false)
                                ->count();
        }

        // Kirim variabel $unreadCount ke view
        $view->with('unreadNotificationsCount', $unreadCount);
        
    });

    // ======================================
}
}
