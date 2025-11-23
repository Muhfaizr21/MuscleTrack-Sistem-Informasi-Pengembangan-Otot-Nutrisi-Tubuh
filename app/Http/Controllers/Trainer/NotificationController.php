<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * 📋 Menampilkan semua notifikasi trainer
     */
    public function index()
    {
        $trainer = Auth::user();

        // Ambil notifikasi trainer dengan pagination
        $notifications = $trainer->notifications()
            ->latest()
            ->paginate(20);

        // Hitung jumlah notifikasi yang belum dibaca
        $unreadCount = $trainer->notifications()
            ->where('read_status', 0)
            ->count();

        // Tandai 5 notifikasi terbaru yang belum dibaca sebagai sudah dibaca
        $trainer->notifications()
            ->where('read_status', 0)
            ->take(5)
            ->update(['read_status' => 1]);

        return view('trainer.communication.notifications.index', compact(
            'notifications',
            'unreadCount' // ✅ TAMBAHKAN INI
        ));
    }

    /**
     * ✅ Tandai satu notifikasi sebagai sudah dibaca
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Tandai dibaca jika belum
        if ($notification->read_status == 0) {
            $notification->update(['read_status' => 1]);
        }

        return redirect()->route('trainer.communication.notifications.index')
            ->with('success', 'Notifikasi telah ditandai sebagai dibaca');
    }

    /**
     * ✅ Tandai SEMUA notifikasi sebagai sudah dibaca
     */
    public function markAllRead(Request $request)
    {
        $trainer = Auth::user();

        $updated = $trainer->notifications()
            ->where('read_status', 0)
            ->update(['read_status' => 1]);

        return redirect()->route('trainer.communication.notifications.index')
            ->with('success', "{$updated} notifikasi telah ditandai sebagai dibaca");
    }

    /**
     * 🗑️ Hapus notifikasi tertentu
     */
    public function destroy($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notification->delete();

        return redirect()->route('trainer.communication.notifications.index')
            ->with('success', 'Notifikasi berhasil dihapus');
    }

    /**
     * 🗑️ Hapus SEMUA notifikasi
     */
    public function clearAll(Request $request)
    {
        $trainer = Auth::user();

        $deletedCount = $trainer->notifications()->delete();

        return redirect()->route('trainer.communication.notifications.index')
            ->with('success', "{$deletedCount} notifikasi berhasil dihapus");
    }

    /**
     * 🔍 Dapatkan jumlah notifikasi belum dibaca (untuk AJAX/API)
     */
    public function getUnreadCount()
    {
        $unreadCount = Auth::user()->notifications()
            ->where('read_status', 0)
            ->count();

        return response()->json([
            'unread_count' => $unreadCount
        ]);
    }

    /**
     * 📱 Tandai notifikasi sebagai dibaca via AJAX
     */
    public function markAsReadAjax(Request $request, $id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($notification->read_status == 0) {
            $notification->update(['read_status' => 1]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi ditandai sebagai dibaca'
        ]);
    }
}
