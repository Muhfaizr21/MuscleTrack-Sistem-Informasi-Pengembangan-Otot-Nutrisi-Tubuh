<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Tampilkan daftar notifikasi untuk USER yang login.
     */
    public function index()
    {
        $user = Auth::user();

        $notifications = $user->notifications()
                              ->latest()
                              ->paginate(20);

        // Tandai 5 notif terbaru sebagai 'read_status' = 1 (true)
        $user->notifications()
             ->where('read_status', 0)
             ->take(5)
             ->update(['read_status' => 1]);

        // ❗️ Kita akan buat view ini di Langkah 4
        return view('user.notifications.index', compact('notifications'));
    }

    /**
     * Tandai satu notifikasi sebagai dibaca (via POST)
     * (Model Anda tidak punya 'link', jadi kita redirect ke index)
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::where('id', $id)
                                    ->where('user_id', Auth::id()) // Pastikan ini notif milik user
                                    ->firstOrFail();

        if ($notification->read_status == 0) {
            $notification->update(['read_status' => 1]);
        }

        return redirect()->route('user.notifications.index');
    }
}
