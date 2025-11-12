<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Notification; // Pastikan Anda punya model ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Tampilkan daftar notifikasi untuk trainer yang login.
     */
    public function index()
    {
        $trainer = Auth::user();

        // Ambil notifikasi (terbaru dulu)
        $notifications = $trainer->notifications()
            ->latest()
            ->paginate(20);

        // Ambil 5 notifikasi terbaru yang belum dibaca (read_status = 0)
        // dan tandai "dibaca" (read_status = 1)
        $trainer->notifications()
            ->where('read_status', 0) // <-- Ini sudah perbaikan "ciamik"
            ->take(5)
            ->update(['read_status' => 1]); // <-- Ini sudah perbaikan "ciamik"

        return view('trainer.communication.notifications.index', compact('notifications'));
    }

    /**
     * Tandai satu notifikasi sebagai sudah dibaca (via POST)
     * dan redirect ke link notifikasi itu.
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id()) // Pastikan ini notif milik trainer
            ->firstOrFail();

        // Tandai dibaca (jika belum)
        if ($notification->read_status == 0) { // <-- Ini sudah perbaikan "ciamik"
            $notification->update(['read_status' => 1]); // <-- Ini sudah perbaikan "ciamik"
        }

        // (Model Anda tidak punya 'link', jadi kita redirect ke index)
        return redirect()->route('trainer.communication.notifications.index');
    }
}
