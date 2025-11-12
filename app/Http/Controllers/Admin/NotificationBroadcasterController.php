<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationBroadcasterController extends Controller
{
    /**
     * Tampilkan form broadcast.
     */
    public function index()
    {
        // Ambil semua user & trainer untuk dropdown "Target Spesifik"
        $users = User::whereIn('role', ['user', 'trainer'])
            ->orderBy('name')
            ->get();

        return view('admin.notifications.broadcast', compact('users'));
    }

    /**
     * Kirim (Store) broadcast notifikasi.
     * (Versi "Ciamik" - Disesuaikan dengan Model Anda)
     */
    public function store(Request $request)
    {
        $request->validate([
            'target_group' => 'required|string',
            'target_user_id' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            // Kita tidak butuh 'link', Model Anda tidak memilikinya.
            // Kita akan set 'type' secara otomatis.
        ]);

        $targets = collect();

        // Tentukan target "ciamik"
        if ($request->target_group === 'all_users') {
            $targets = User::where('role', 'user')->get();
        } elseif ($request->target_group === 'all_trainers') {
            $targets = User::where('role', 'trainer')->get();
        } elseif ($request->target_group === 'specific_user' && $request->target_user_id) {
            $targets = User::where('id', $request->target_user_id)->get();
        } else {
            return back()->with('error', 'Target tidak valid.');
        }

        if ($targets->isEmpty()) {
            return back()->with('error', 'Tidak ada user yang cocok dengan target ini.');
        }

        // ==========================================================
        // ===== INI ADALAH BLOK YANG SUDAH DIPERBAIKI (FIX) =====
        // ==========================================================

        // Buat "Paket Notifikasi" (Sesuai Model Anda)
        $notificationData = [
            // Kita tidak pakai 'sender_id', Model Anda tidak memilikinya
            'title' => $request->title,
            'message' => $request->message,
            'type' => 'system', // 👈 Kita set 'type' (sesuai Model Anda)
            'read_status' => false, // 👈 Kita set 'read_status' (sesuai Model Anda)
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Kirim ke semua target (looping)
        foreach ($targets as $user) {
            $notificationData['user_id'] = $user->id; // Set penerimanya
            Notification::create($notificationData);
        }

        return redirect()->route('admin.broadcast.index')
            ->with('success', 'Notifikasi berhasil dikirim ke '.$targets->count().' user.');
    }
}
