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

class ChatController extends Controller
{
    /**
     * 💬 Tampilkan daftar member dan area chat dengan filter tanggal
     */
    public function index(Request $request)
    {
        try {
            $trainer = Auth::user();

            // 🔹 Ambil semua member yang terhubung dengan trainer
            $members = User::where('trainer_id', $trainer->id)
                ->where('role', 'user')
                ->withCount([
                    'trainerChatsAsUser' => function ($query) use ($trainer) {
                        $query->where('trainer_id', $trainer->id)
                            ->where('sender_type', 'user')
                            ->where('read_status', false);
                    },
                ])
                ->get();

            // 🔹 Tentukan member aktif
            $user = null;
            if ($request->has('user')) {
                $user = User::find($request->user);
                if (!$user) {
                    Log::warning('User not found in chat index', [
                        'requested_user_id' => $request->user,
                        'trainer_id' => $trainer->id
                    ]);
                }
            } elseif ($members->count() === 1) {
                $user = $members->first();
            }

            // 🔹 Filter tanggal (opsional)
            $dateFilter = $request->input('date'); // format: YYYY-MM-DD
            $chats = collect();

            if ($user) {
                $query = TrainerChat::where('trainer_id', $trainer->id)
                    ->where('user_id', $user->id);

                if ($dateFilter) {
                    try {
                        $parsedDate = Carbon::parse($dateFilter)->toDateString();
                        $query->whereDate('timestamp', $parsedDate);
                    } catch (Exception $e) {
                        Log::error('Invalid date filter in chat index', [
                            'date_filter' => $dateFilter,
                            'error' => $e->getMessage()
                        ]);
                    }
                }

                $chats = $query->orderBy('timestamp', 'asc')->get();

                // 🔹 Tandai pesan dari user sebagai sudah dibaca
                try {
                    $updatedCount = TrainerChat::where('trainer_id', $trainer->id)
                        ->where('user_id', $user->id)
                        ->where('sender_type', 'user')
                        ->where('read_status', false)
                        ->update(['read_status' => true]);

                    Log::info('Messages marked as read in index', [
                        'trainer_id' => $trainer->id,
                        'user_id' => $user->id,
                        'updated_count' => $updatedCount
                    ]);
                } catch (Exception $e) {
                    Log::error('Failed to mark messages as read', [
                        'trainer_id' => $trainer->id,
                        'user_id' => $user->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            // 🔹 Daftar tanggal unik (untuk filter dropdown)
            try {
                $availableDates = TrainerChat::where('trainer_id', $trainer->id)
                    ->when($user, fn($q) => $q->where('user_id', $user->id))
                    ->selectRaw('DATE(timestamp) as date')
                    ->distinct()
                    ->orderBy('date', 'desc')
                    ->pluck('date');
            } catch (Exception $e) {
                Log::error('Failed to get available dates for chat', [
                    'trainer_id' => $trainer->id,
                    'user_id' => $user?->id,
                    'error' => $e->getMessage()
                ]);
                $availableDates = collect();
            }

            return view('trainer.communication.chat', compact(
                'trainer',
                'members',
                'user',
                'chats',
                'availableDates',
                'dateFilter'
            ));
        } catch (Exception $e) {
            Log::error('Error in ChatController@index', [
                'trainer_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }

    /**
     * 📨 Kirim pesan (real-time)
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'message' => 'required|string|max:1000',
            ]);

            $trainer = Auth::user();
            $user = User::findOrFail($request->user_id);

            // 🔒 Cegah kirim pesan ke user lain - FIX: Gunakan perbandingan string
            if ((string)$user->trainer_id !== (string)$trainer->id) {
                Log::warning('Unauthorized chat attempt', [
                    'trainer_id' => $trainer->id,
                    'trainer_id_type' => gettype($trainer->id),
                    'target_user_id' => $user->id,
                    'target_user_trainer_id' => $user->trainer_id,
                    'target_user_trainer_id_type' => gettype($user->trainer_id)
                ]);
                return response()->json(['error' => 'Tidak dapat mengirim pesan ke user lain.'], 403);
            }

            // 🔹 Simpan pesan baru
            $chat = TrainerChat::create([
                'trainer_id' => $trainer->id,
                'user_id' => $user->id,
                'message' => $request->message,
                'sender_type' => 'trainer',
                'timestamp' => now(),
                'read_status' => false,
            ]);

            Log::info('Trainer message sent successfully', [
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
        } catch (ModelNotFoundException $e) {
            Log::error('User not found in chat store', [
                'requested_user_id' => $request->user_id,
                'trainer_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'User tidak ditemukan.'], 404);
        } catch (Exception $e) {
            Log::error('Error sending message in ChatController@store', [
                'trainer_id' => Auth::id(),
                'user_id' => $request->user_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Gagal mengirim pesan. Silakan coba lagi.'], 500);
        }
    }

    /**
     * ✅ Tandai semua pesan dari user sebagai sudah dibaca
     */
    public function markAllRead(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id'
            ]);

            $trainer = Auth::user();
            $userId = $request->input('user_id');

            // FIX: Gunakan casting string untuk konsistensi
            $updatedCount = TrainerChat::where('trainer_id', (string)$trainer->id)
                ->where('user_id', $userId)
                ->where('sender_type', 'user')
                ->where('read_status', false)
                ->update(['read_status' => true]);

            Log::info('Messages marked as read via API', [
                'trainer_id' => $trainer->id,
                'user_id' => $userId,
                'updated_count' => $updatedCount,
                'trainer_id_used_in_query' => (string)$trainer->id
            ]);

            return response()->json([
                'success' => true,
                'updated_count' => $updatedCount
            ]);
        } catch (Exception $e) {
            Log::error('Error marking messages as read in ChatController@markAllRead', [
                'trainer_id' => Auth::id(),
                'user_id' => $request->user_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Gagal menandai pesan sebagai sudah dibaca.'], 500);
        }
    }

    /**
     * 🗑️ Hapus pesan milik trainer
     */
    public function destroy($id)
    {
        try {
            $trainer = Auth::user();
            $chat = TrainerChat::findOrFail($id);

            // FIX: Gunakan casting string untuk konsistensi
            if ((string)$chat->trainer_id !== (string)$trainer->id || $chat->sender_type !== 'trainer') {
                Log::warning('Unauthorized chat deletion attempt', [
                    'trainer_id' => $trainer->id,
                    'trainer_id_type' => gettype($trainer->id),
                    'chat_id' => $id,
                    'chat_trainer_id' => $chat->trainer_id,
                    'chat_trainer_id_type' => gettype($chat->trainer_id),
                    'chat_sender_type' => $chat->sender_type
                ]);
                abort(403, 'Anda tidak dapat menghapus pesan milik member.');
            }

            $chat->delete();

            Log::info('Chat message deleted successfully', [
                'trainer_id' => $trainer->id,
                'chat_id' => $id
            ]);

            return response()->json(['success' => true]);
        } catch (ModelNotFoundException $e) {
            Log::error('Chat message not found for deletion', [
                'chat_id' => $id,
                'trainer_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Pesan tidak ditemukan.'], 404);
        } catch (Exception $e) {
            Log::error('Error deleting chat message in ChatController@destroy', [
                'trainer_id' => Auth::id(),
                'chat_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Gagal menghapus pesan. Silakan coba lagi.'], 500);
        }
    }
}
