<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kutia\Larafirebase\Messages\FirebaseMessage;

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
                'unread_count' => Auth::user()->notifications()->where('read_status', 0)->count(),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Notifikasi sudah dibaca sebelumnya',
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
                'pagination' => $notifications->links()->toHtml(),
            ]);
        }

        return view('user.notifications', compact('notifications'));
    }

    /**
     * ============================
     * PUSH NOTIFICATION METHODS
     * ============================
     */

    /**
     * Kirim push notifikasi ke semua perangkat user
     */
    public function sendPushNotification($userId, $title, $message, $data = [])
    {
        try {
            // Dapatkan semua device aktif user
            $devices = UserDevice::where('user_id', $userId)
                ->whereNotNull('fcm_token')
                ->get();

            if ($devices->isEmpty()) {
                \Log::warning('User tidak memiliki perangkat aktif', ['user_id' => $userId]);
                return false;
            }

            $successCount = 0;

            foreach ($devices as $device) {
                $sendResult = $this->sendToSingleDevice(
                    $device->fcm_token,
                    $title,
                    $message,
                    $data
                );

                if ($sendResult) {
                    $successCount++;
                }
            }

            \Log::info('Push notification dikirim', [
                'user_id' => $userId,
                'devices' => $devices->count(),
                'success' => $successCount
            ]);

            return $successCount > 0;
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim push notification: ' . $e->getMessage(), [
                'user_id' => $userId,
                'title' => $title
            ]);
            return false;
        }
    }

    /**
     * Kirim ke single device
     */
    private function sendToSingleDevice($fcmToken, $title, $message, $data = [])
    {
        try {
            // Konfigurasi FCM
            $firebaseMessage = new FirebaseMessage();
            $firebaseMessage->withTitle($title)
                ->withBody($message)
                ->withPriority('high')
                ->withAdditionalData(array_merge([
                    'title' => $title,
                    'body' => $message,
                    'sound' => 'default',
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                ], $data))
                ->sendTo($fcmToken);

            return true;
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim ke device: ' . $e->getMessage(), [
                'token' => substr($fcmToken, 0, 20) . '...'
            ]);
            return false;
        }
    }

    /**
     * Kirim notifikasi ke multiple users
     */
    public function sendBulkPushNotification($userIds, $title, $message, $data = [])
    {
        $successCount = 0;
        $failedCount = 0;

        foreach ($userIds as $userId) {
            if ($this->sendPushNotification($userId, $title, $message, $data)) {
                $successCount++;
            } else {
                $failedCount++;
            }
        }

        return [
            'success' => $successCount,
            'failed' => $failedCount,
            'total' => count($userIds)
        ];
    }

    /**
     * API untuk mengirim push notifikasi (bisa dipanggil dari service lain)
     */
    public function sendNotificationAPI(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'data' => 'sometimes|array'
        ]);

        $success = $this->sendPushNotification(
            $request->user_id,
            $request->title,
            $request->message,
            $request->data ?? []
        );

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Notifikasi berhasil dikirim' : 'Gagal mengirim notifikasi'
        ]);
    }

    /**
     * Simpan FCM token untuk device user
     */
    public function storeFCMToken(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string',
            'device_name' => 'sometimes|string'
        ]);

        $user = Auth::user();

        // Cek apakah device sudah terdaftar
        $device = UserDevice::where('user_id', $user->id)
            ->where('fcm_token', $request->fcm_token)
            ->first();

        if ($device) {
            // Update device yang ada
            $device->update([
                'device_name' => $request->device_name ?? $device->device_name,
            ]);
        } else {
            // Buat device baru
            UserDevice::create([
                'user_id' => $user->id,
                'fcm_token' => $request->fcm_token,
                'device_name' => $request->device_name ?? 'Unknown Device',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'FCM token berhasil disimpan'
        ]);
    }

    /**
     * Hapus FCM token (saat logout)
     */
    public function removeFCMToken(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string'
        ]);

        $user = Auth::user();

        UserDevice::where('user_id', $user->id)
            ->where('fcm_token', $request->fcm_token)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'FCM token berhasil dihapus'
        ]);
    }

    /**
     * Dapatkan semua devices user
     */
    public function getUserDevices()
    {
        $devices = Auth::user()->devices()->get();

        return response()->json([
            'success' => true,
            'devices' => $devices
        ]);
    }

    /**
     * Test push notification
     */
    public function testPushNotification(Request $request)
    {
        $user = Auth::user();

        $success = $this->sendPushNotification(
            $user->id,
            'Test Notification',
            'Ini adalah notifikasi test dari sistem',
            ['test_data' => 'value123']
        );

        if ($success) {
            return response()->json([
                'success' => true,
                'message' => 'Test notifikasi berhasil dikirim'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal mengirim test notifikasi'
        ], 500);
    }

    /**
     * Simpan preferensi push notification user
     */
    public function savePushPreferences(Request $request)
    {
        $request->validate([
            'push_enabled' => 'sometimes|boolean',
            'workout_reminders' => 'sometimes|boolean',
            'nutrition_tips' => 'sometimes|boolean',
            'trainer_messages' => 'sometimes|boolean',
            'system_updates' => 'sometimes|boolean'
        ]);

        $user = Auth::user();
        $settings = $user->settings ?? [];

        $settings = array_merge($settings, [
            'push_enabled' => $request->boolean('push_enabled', true),
            'workout_reminders' => $request->boolean('workout_reminders', true),
            'nutrition_tips' => $request->boolean('nutrition_tips', true),
            'trainer_messages' => $request->boolean('trainer_messages', true),
            'system_updates' => $request->boolean('system_updates', true)
        ]);

        $user->update(['settings' => $settings]);

        return response()->json([
            'success' => true,
            'message' => 'Preferensi notifikasi berhasil disimpan',
            'settings' => $settings
        ]);
    }

    /**
     * Buat notifikasi dan kirim push (untuk penggunaan internal)
     */
    public function createAndSendNotification($userId, $title, $message, $type = 'info', $data = [])
    {
        try {
            // Buat notifikasi di database
            $notification = Notification::create([
                'user_id' => $userId,
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'read_status' => 0,
            ]);

            // Kirim push notification
            $pushSent = $this->sendPushNotification(
                $userId,
                $title,
                $message,
                array_merge($data, ['notification_id' => $notification->id])
            );

            return [
                'notification' => $notification,
                'push_sent' => $pushSent
            ];
        } catch (\Exception $e) {
            \Log::error('Gagal membuat notifikasi: ' . $e->getMessage(), [
                'user_id' => $userId,
                'title' => $title
            ]);
            return null;
        }
    }

    /**
     * Kirim notifikasi workout reminder spesifik (contoh penggunaan)
     * DIUBAH NAMA: sendSpecificWorkoutReminder
     */
    public function sendSpecificWorkoutReminder($userId, $workoutName, $scheduledTime)
    {
        $user = User::find($userId);
        if (!$user) return false;

        $settings = $user->settings ?? [];
        if (!($settings['push_enabled'] ?? true) || !($settings['workout_reminders'] ?? true)) {
            return false;
        }

        $title = "⏰ Waktunya Workout!";
        $message = "Jangan lupa workout {$workoutName} pukul {$scheduledTime}";

        return $this->createAndSendNotification(
            $userId,
            $title,
            $message,
            'reminder',
            ['workout_name' => $workoutName, 'scheduled_time' => $scheduledTime]
        );
    }

    /**
     * Kirim notifikasi nutrition tip (contoh penggunaan)
     */
    public function sendNutritionTip($userId, $tip)
    {
        $user = User::find($userId);
        if (!$user) return false;

        $settings = $user->settings ?? [];
        if (!($settings['push_enabled'] ?? true) || !($settings['nutrition_tips'] ?? true)) {
            return false;
        }

        $title = "🥗 Tips Nutrisi";
        $message = $tip;

        return $this->createAndSendNotification(
            $userId,
            $title,
            $message,
            'nutrition_tip',
            ['tip' => $tip]
        );
    }

    /**
     * Kirim notifikasi dari trainer
     */
    public function sendTrainerMessage($userId, $trainerName, $message)
    {
        $user = User::find($userId);
        if (!$user) return false;

        $settings = $user->settings ?? [];
        if (!($settings['push_enabled'] ?? true) || !($settings['trainer_messages'] ?? true)) {
            return false;
        }

        $title = "🧑‍🏫 Pesan dari {$trainerName}";

        return $this->createAndSendNotification(
            $userId,
            $title,
            $message,
            'trainer',
            ['trainer_name' => $trainerName]
        );
    }

    /**
     * Simpan preferensi reminder user
     */
    public function saveReminderPreferences(Request $request)
    {
        $request->validate([
            'daily_reminder_enabled' => 'sometimes|boolean',
            'daily_reminder_time' => 'required_if:daily_reminder_enabled,true|date_format:H:i',
            'workout_reminder_enabled' => 'sometimes|boolean',
            'workout_reminder_time' => 'required_if:workout_reminder_enabled,true|date_format:H:i',
            'water_reminder_enabled' => 'sometimes|boolean',
            'water_reminder_interval' => 'required_if:water_reminder_enabled,true|integer|min:1|max:12',
            'nutrition_reminder_enabled' => 'sometimes|boolean',
            'nutrition_reminder_times' => 'required_if:nutrition_reminder_enabled,true|array',
            'progress_reminder_enabled' => 'sometimes|boolean',
            'progress_reminder_day' => 'required_if:progress_reminder_enabled,true|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday'
        ]);

        $user = Auth::user();
        $settings = $user->settings ?? [];

        $reminderSettings = [
            'daily_reminder' => [
                'enabled' => $request->boolean('daily_reminder_enabled', false),
                'time' => $request->daily_reminder_time ?? '09:00'
            ],
            'workout_reminder' => [
                'enabled' => $request->boolean('workout_reminder_enabled', false),
                'time' => $request->workout_reminder_time ?? '07:00'
            ],
            'water_reminder' => [
                'enabled' => $request->boolean('water_reminder_enabled', false),
                'interval' => $request->water_reminder_interval ?? 2
            ],
            'nutrition_reminder' => [
                'enabled' => $request->boolean('nutrition_reminder_enabled', false),
                'times' => $request->nutrition_reminder_times ?? ['08:00', '12:00', '18:00']
            ],
            'progress_reminder' => [
                'enabled' => $request->boolean('progress_reminder_enabled', false),
                'day' => $request->progress_reminder_day ?? 'monday'
            ]
        ];

        $settings['reminders'] = $reminderSettings;
        $user->update(['settings' => $settings]);

        // Schedule reminders jika diaktifkan
        if ($reminderSettings['daily_reminder']['enabled']) {
            $this->scheduleDailyReminder($user->id);
        }

        return response()->json([
            'success' => true,
            'message' => 'Preferensi pengingat berhasil disimpan',
            'reminders' => $reminderSettings
        ]);
    }

    /**
     * Kirim daily reminder
     */
    public function sendDailyReminder($userId)
    {
        $user = User::find($userId);
        if (!$user) return false;

        $settings = $user->settings['reminders']['daily_reminder'] ?? [];
        if (!($settings['enabled'] ?? false)) {
            return false;
        }

        $motivationalQuotes = [
            "💪 Hari yang baru, kesempatan baru untuk menjadi lebih kuat!",
            "🔥 Jangan berhenti ketika lelah, berhenti ketika selesai!",
            "🏋️‍♂️ Konsistensi adalah kunci kesuksesan fitness!",
            "🌟 Progress kecil tetap progress. Teruslah bergerak!",
            "🥗 Ingat untuk tetap menjaga nutrisi hari ini!",
            "🚰 Jangan lupa minum air yang cukup!",
            "📈 Setiap latihan membawa Anda lebih dekat ke tujuan!",
            "💫 Anda lebih kuat dari yang Anda kira!",
            "🔥 Transformasi dimulai dari satu langkah kecil!",
            "🏆 Fokus pada progres, bukan kesempurnaan!"
        ];

        $randomQuote = $motivationalQuotes[array_rand($motivationalQuotes)];

        $title = "🌅 Selamat Pagi!";
        $message = $randomQuote;

        return $this->createAndSendNotification(
            $userId,
            $title,
            $message,
            'reminder',
            ['reminder_type' => 'daily_motivation']
        );
    }

    /**
     * Kirim workout reminder harian
     * DIUBAH NAMA: sendDailyWorkoutReminder
     */
    public function sendDailyWorkoutReminder($userId)
    {
        $user = User::find($userId);
        if (!$user) return false;

        $settings = $user->settings['reminders']['workout_reminder'] ?? [];
        if (!($settings['enabled'] ?? false)) {
            return false;
        }

        $title = "🏋️‍♂️ Waktunya Workout!";
        $message = "Jangan lupa jadwal workout hari ini. Semangat! 💪";

        return $this->createAndSendNotification(
            $userId,
            $title,
            $message,
            'reminder',
            ['reminder_type' => 'workout']
        );
    }

    /**
     * Kirim water reminder
     */
    public function sendWaterReminder($userId)
    {
        $user = User::find($userId);
        if (!$user) return false;

        $settings = $user->settings['reminders']['water_reminder'] ?? [];
        if (!($settings['enabled'] ?? false)) {
            return false;
        }

        $title = "🚰 Waktunya Minum Air!";
        $message = "Jaga hidrasi tubuh Anda untuk performa yang optimal!";

        return $this->createAndSendNotification(
            $userId,
            $title,
            $message,
            'reminder',
            ['reminder_type' => 'water']
        );
    }

    /**
     * Kirim nutrition reminder
     */
    public function sendNutritionReminder($userId, $mealType)
    {
        $user = User::find($userId);
        if (!$user) return false;

        $settings = $user->settings['reminders']['nutrition_reminder'] ?? [];
        if (!($settings['enabled'] ?? false)) {
            return false;
        }

        $mealNames = [
            'breakfast' => 'Sarapan',
            'lunch' => 'Makan Siang',
            'dinner' => 'Makan Malam',
            'snack' => 'Camilan Sehat'
        ];

        $title = "🥗 Waktunya {$mealNames[$mealType]}!";
        $message = "Jangan lupa makan {$mealNames[$mealType]} yang sehat dan bergizi!";

        return $this->createAndSendNotification(
            $userId,
            $title,
            $message,
            'reminder',
            ['reminder_type' => 'nutrition', 'meal_type' => $mealType]
        );
    }

    /**
     * Kirim progress reminder
     */
    public function sendProgressReminder($userId)
    {
        $user = User::find($userId);
        if (!$user) return false;

        $settings = $user->settings['reminders']['progress_reminder'] ?? [];
        if (!($settings['enabled'] ?? false)) {
            return false;
        }

        $title = "📊 Waktunya Update Progress!";
        $message = "Jangan lupa catat progress mingguan Anda untuk melihat perkembangan!";

        return $this->createAndSendNotification(
            $userId,
            $title,
            $message,
            'reminder',
            ['reminder_type' => 'progress_update']
        );
    }

    /**
     * Schedule daily reminder (untuk penggunaan scheduler)
     */
    private function scheduleDailyReminder($userId)
    {
        // Method ini akan dipanggil oleh Laravel Scheduler
        // Untuk implementasi nyata, Anda perlu menambahkan command di Kernel.php
    }

    /**
     * API untuk mengaktifkan/menonaktifkan reminder cepat
     */
    public function toggleQuickReminder(Request $request)
    {
        $request->validate([
            'type' => 'required|in:daily,workout,water,nutrition,progress',
            'enabled' => 'required|boolean'
        ]);

        $user = Auth::user();
        $settings = $user->settings ?? [];

        if (!isset($settings['reminders'])) {
            $settings['reminders'] = [];
        }

        $type = $request->type;
        $enabled = $request->boolean('enabled');

        // Set default values based on type
        switch ($type) {
            case 'daily':
                $settings['reminders']['daily_reminder'] = [
                    'enabled' => $enabled,
                    'time' => '09:00'
                ];
                break;
            case 'workout':
                $settings['reminders']['workout_reminder'] = [
                    'enabled' => $enabled,
                    'time' => '07:00'
                ];
                break;
            case 'water':
                $settings['reminders']['water_reminder'] = [
                    'enabled' => $enabled,
                    'interval' => 2
                ];
                break;
            case 'nutrition':
                $settings['reminders']['nutrition_reminder'] = [
                    'enabled' => $enabled,
                    'times' => ['08:00', '12:00', '18:00']
                ];
                break;
            case 'progress':
                $settings['reminders']['progress_reminder'] = [
                    'enabled' => $enabled,
                    'day' => 'monday'
                ];
                break;
        }

        $user->update(['settings' => $settings]);

        return response()->json([
            'success' => true,
            'message' => $enabled ? "Pengingat {$type} diaktifkan" : "Pengingat {$type} dinonaktifkan",
            'reminders' => $settings['reminders']
        ]);
    }

    /**
     * Test specific reminder
     */
    public function testReminder(Request $request)
    {
        $request->validate([
            'type' => 'required|in:daily,workout,water,nutrition,progress'
        ]);

        $user = Auth::user();
        $type = $request->type;

        $methods = [
            'daily' => 'sendDailyReminder',
            'workout' => 'sendDailyWorkoutReminder', // DIUBAH: sendDailyWorkoutReminder
            'water' => 'sendWaterReminder',
            'nutrition' => function ($userId) {
                return $this->sendNutritionReminder($userId, 'lunch');
            },
            'progress' => 'sendProgressReminder'
        ];

        if (isset($methods[$type])) {
            if (is_callable($methods[$type])) {
                $result = $methods[$type]($user->id);
            } else {
                $result = $this->{$methods[$type]}($user->id);
            }

            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => "Test pengingat {$type} berhasil dikirim"
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal mengirim test pengingat'
        ], 500);
    }
}
