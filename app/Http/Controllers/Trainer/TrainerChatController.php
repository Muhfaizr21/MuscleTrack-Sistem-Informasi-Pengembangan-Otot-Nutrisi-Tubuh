<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\TrainerChat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Support\Facades\DB;

// UBAH NAMA CLASS DISINI:
class TrainerChatController extends Controller  // <- PERUBAHAN PENTING!
{
    /**
     * 💬 Tampilkan daftar member + chat + filter tanggal
     */
    public function index(Request $request)
    {
        try {
            $trainer = Auth::user();

            // Ambil member dengan hitung pesan belum dibaca
            $members = User::where('trainer_id', $trainer->id)
                ->where('role', 'user')
                ->withCount([
                    'trainerChatsAsUser as unread_count' => function ($query) use ($trainer) {
                        $query->where('trainer_id', $trainer->id)
                            ->where('sender_type', 'user')
                            ->where('read_status', false);
                    },
                ])
                ->withCount([
                    'trainerChatsAsUser as trainer_chats_as_user_count' => function ($query) use ($trainer) {
                        $query->where('trainer_id', $trainer->id)
                            ->where('sender_type', 'user')
                            ->where('read_status', false);
                    },
                ])
                ->orderBy('name')
                ->get();

            $user = null;

            // Tentukan member aktif
            if ($request->filled('user')) {
                $user = User::where('id', $request->user)
                    ->where('trainer_id', $trainer->id)
                    ->firstOrFail();
            } elseif ($members->count() > 0) {
                // Pilih member pertama yang memiliki pesan atau pertama dalam daftar
                $user = $members->first();
            }

            $dateFilter = $request->input('date');
            $chats = collect();

            if ($user) {
                $query = TrainerChat::where('trainer_id', $trainer->id)
                    ->where('user_id', $user->id)
                    ->orderBy('timestamp', 'asc');

                if ($dateFilter) {
                    try {
                        $query->whereDate('timestamp', Carbon::parse($dateFilter)->toDateString());
                    } catch (Exception $e) {
                        Log::error('Invalid date filter', [
                            'date_filter' => $dateFilter,
                            'error' => $e->getMessage()
                        ]);
                    }
                }

                $chats = $query->get();

                // Tandai pesan user sebagai sudah dibaca
                $this->markUserMessagesAsRead($trainer->id, $user->id);
            }

            // Ambil tanggal yang tersedia untuk filter
            $availableDates = TrainerChat::where('trainer_id', $trainer->id)
                ->when($user, fn($q) => $q->where('user_id', $user->id))
                ->selectRaw('DATE(timestamp) as date')
                ->distinct()
                ->orderBy('date', 'desc')
                ->pluck('date')
                ->map(function ($date) {
                    return Carbon::parse($date)->format('Y-m-d');
                });

            return view('trainer.communication.chat', compact(
                'trainer',
                'members',
                'user',
                'chats',
                'availableDates',
                'dateFilter'
            ));
        } catch (Exception $e) {
            Log::error('Error in TrainerChatController@index', [
                'trainer_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * 📨 Kirim pesan ke user
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'message' => 'required|string|max:1000',
            ]);

            $trainer = Auth::user();
            $user = User::findOrFail($request->user_id);

            // Validasi: hanya bisa kirim ke member sendiri
            if ($user->trainer_id != $trainer->id) {
                return response()->json([
                    'success' => false,
                    'error' => 'Tidak dapat mengirim pesan ke user lain.'
                ], 403);
            }

            $chat = TrainerChat::create([
                'trainer_id'  => $trainer->id,
                'user_id'     => $user->id,
                'message'     => trim($request->message),
                'sender_type' => 'trainer',
                'timestamp'   => now(),
                'read_status' => true,
            ]);

            DB::commit();

            Log::info('Chat message sent', [
                'trainer_id' => $trainer->id,
                'user_id' => $user->id,
                'chat_id' => $chat->id,
                'message_length' => strlen($request->message)
            ]);

            return response()->json([
                'success' => true,
                'chat_id' => $chat->id,
                'message' => $chat->message,
                'timestamp' => $chat->timestamp->format('H:i'),
                'date' => $chat->timestamp->format('Y-m-d'),
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error sending message', [
                'trainer_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Gagal mengirim pesan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 🗑 Hapus pesan milik trainer
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $trainer = Auth::user();

            Log::info('Delete Chat Attempt', [
                'trainer_id' => $trainer->id,
                'chat_id' => $id,
            ]);

            $chat = TrainerChat::findOrFail($id);

            // Validasi: pesan hanya boleh dihapus jika dikirim oleh trainer ini
            if ($chat->trainer_id !== $trainer->id || $chat->sender_type !== 'trainer') {
                Log::warning('Unauthorized delete attempt', [
                    'trainer_id' => $trainer->id,
                    'chat_id' => $id,
                    'chat_trainer_id' => $chat->trainer_id,
                    'sender_type' => $chat->sender_type
                ]);

                return response()->json([
                    'success' => false,
                    'error' => 'Anda hanya dapat menghapus pesan yang Anda kirim sendiri.'
                ], 403);
            }

            // Simpan info sebelum dihapus untuk log
            $chatInfo = [
                'id' => $chat->id,
                'message' => substr($chat->message, 0, 100),
                'timestamp' => $chat->timestamp,
                'sender_type' => $chat->sender_type,
            ];

            $chat->delete();
            DB::commit();

            Log::info('Chat deleted successfully', [
                'trainer_id' => $trainer->id,
                'chat_id' => $id,
                'deleted_chat_info' => $chatInfo
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pesan berhasil dihapus.'
            ]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();

            Log::error('Chat not found while deleting', [
                'chat_id' => $id,
                'trainer_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Pesan tidak ditemukan.'
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error deleting chat message', [
                'trainer_id' => Auth::id(),
                'chat_id' => $id,
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Gagal menghapus pesan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ Tandai semua pesan user sebagai sudah dibaca
     */
    public function markAllRead(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id'
            ]);

            $trainer = Auth::user();
            $userId  = $request->input('user_id');

            // Validasi: user harus member dari trainer ini
            $user = User::where('id', $userId)
                ->where('trainer_id', $trainer->id)
                ->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'error' => 'Unauthorized access'
                ], 403);
            }

            $updatedCount = $this->markUserMessagesAsRead($trainer->id, $userId);

            DB::commit();

            return response()->json([
                'success' => true,
                'updated_count' => $updatedCount,
                'message' => 'Semua pesan telah ditandai sebagai dibaca.'
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error marking messages as read', [
                'trainer_id' => Auth::id(),
                'user_id' => $request->input('user_id'),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Gagal menandai pesan sebagai dibaca.'
            ], 500);
        }
    }

    /**
     * Helper: Tandai pesan user sebagai sudah dibaca
     */
    private function markUserMessagesAsRead(int $trainerId, int $userId): int
    {
        return TrainerChat::where('trainer_id', $trainerId)
            ->where('user_id', $userId)
            ->where('sender_type', 'user')
            ->where('read_status', false)
            ->update(['read_status' => true]);
    }

    /**
     * 🔍 Debug: Cek status read pesan
     */
    public function debugReadStatus(Request $request)
    {
        try {
            $trainer = Auth::user();
            $userId = $request->input('user_id', null);

            $query = TrainerChat::where('trainer_id', $trainer->id);

            if ($userId) {
                $query->where('user_id', $userId);
            }

            $messages = $query->select('id', 'message', 'sender_type', 'read_status', 'timestamp')
                ->orderBy('timestamp', 'desc')
                ->limit(20)
                ->get()
                ->map(function ($msg) {
                    return [
                        'id' => $msg->id,
                        'message_preview' => substr($msg->message, 0, 50) . '...',
                        'sender_type' => $msg->sender_type,
                        'read_status' => $msg->read_status,
                        'timestamp' => $msg->timestamp->format('Y-m-d H:i:s'),
                        'can_delete' => $msg->trainer_id === Auth::id() && $msg->sender_type === 'trainer'
                    ];
                });

            return response()->json([
                'success' => true,
                'trainer_id' => $trainer->id,
                'total_messages' => $messages->count(),
                'messages' => $messages
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 🆕 Get unread messages count for sidebar
     */
    public function getUnreadCount(Request $request)
    {
        try {
            $trainer = Auth::user();

            $unreadCount = TrainerChat::where('trainer_id', $trainer->id)
                ->where('sender_type', 'user')
                ->where('read_status', false)
                ->count();

            return response()->json([
                'success' => true,
                'unread_count' => $unreadCount
            ]);
        } catch (Exception $e) {
            Log::error('Error getting unread count', [
                'trainer_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
