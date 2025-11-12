<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NotificationController extends Controller
{
    /**
     * Tampilkan daftar notifikasi untuk USER yang login dengan statistik lengkap.
     */
    public function index()
    {
        $user = Auth::user();

        $notifications = $user->notifications()
            ->orderBy('read_status')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Statistik untuk dashboard
        $unreadCount = $user->notifications()->where('read_status', 0)->count();
        $todayCount = $user->notifications()
            ->whereDate('created_at', today())
            ->count();
        $weeklyCount = $user->notifications()
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        return view('user.notifications', compact('notifications', 'unreadCount', 'todayCount', 'weeklyCount'));
    }

    /**
     * Tandai satu notifikasi sebagai dibaca (via POST)
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($notification->read_status == 0) {
            $notification->update(['read_status' => 1]);

            return redirect()->route('user.notifications.index')
                ->with('success', 'Notifikasi telah ditandai sebagai dibaca.');
        }

        return redirect()->route('user.notifications.index');
    }

    /**
     * Tandai SEMUA notifikasi sebagai dibaca (via POST)
     */
    public function markAllRead(Request $request)
    {
        $user = Auth::user();

        $updated = $user->notifications()
            ->where('read_status', 0)
            ->update(['read_status' => 1]);

        if ($updated > 0) {
            return redirect()->route('user.notifications.index')
                ->with('success', "Semua ($updated) notifikasi telah ditandai sebagai dibaca.");
        }

        return redirect()->route('user.notifications.index')
            ->with('info', 'Tidak ada notifikasi yang perlu ditandai sebagai dibaca.');
    }

    /**
     * Hapus satu notifikasi (via DELETE)
     */
    public function destroy($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notification->delete();

        return redirect()->route('user.notifications.index')
            ->with('success', 'Notifikasi berhasil dihapus.');
    }

    /**
     * Hapus SEMUA notifikasi (via DELETE)
     */
    public function clearAll(Request $request)
    {
        $user = Auth::user();

        $count = $user->notifications()->count();

        $user->notifications()->delete();

        return redirect()->route('user.notifications.index')
            ->with('success', "Semua ($count) notifikasi berhasil dihapus.");
    }

    /**
     * API untuk mendapatkan jumlah notifikasi yang belum dibaca (untuk badge)
     */
    public function getUnreadCount()
    {
        $count = Auth::user()->notifications()->where('read_status', 0)->count();

        return response()->json(['unread_count' => $count]);
    }

    /**
     * Tandai notifikasi sebagai dibaca via AJAX (untuk real-time updates)
     */
    public function markAsReadAjax(Request $request, $id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($notification->read_status == 0) {
            $notification->update(['read_status' => 1]);

            return response()->json([
                'success' => true,
                'message' => 'Notifikasi ditandai sebagai dibaca',
                'unread_count' => Auth::user()->notifications()->where('read_status', 0)->count()
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Notifikasi sudah dibaca sebelumnya'
        ]);
    }

    /**
     * Filter notifikasi berdasarkan type (untuk AJAX filtering)
     */
    public function filter(Request $request)
    {
        $user = Auth::user();
        $type = $request->get('type');
        $status = $request->get('status');

        $query = $user->notifications();

        if ($type && $type !== 'all') {
            $query->where('type', $type);
        }

        if ($status === 'unread') {
            $query->where('read_status', 0);
        } elseif ($status === 'read') {
            $query->where('read_status', 1);
        }

        $notifications = $query->orderBy('created_at', 'desc')
            ->paginate(20);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('user.partials.notifications-list', compact('notifications'))->render(),
                'pagination' => $notifications->links()->toHtml()
            ]);
        }

        return view('user.notifications', compact('notifications'));
    }
}
