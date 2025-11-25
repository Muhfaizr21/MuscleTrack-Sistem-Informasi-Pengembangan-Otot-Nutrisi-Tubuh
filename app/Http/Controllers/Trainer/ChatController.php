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
     * 💬 Tampilkan daftar member + chat + filter tanggal
     */
    public function index(Request $request)
    {
        try {
            $trainer = Auth::user();

            // Ambil semua member yang dimiliki trainer + unread count (pesan dari user)
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

            // tentukan user aktif
            $user = null;
            if ($request->filled('user')) {
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

            $dateFilter = $request->input('date');
            $chats = collect();

            if ($user) {
                $query = TrainerChat::where('trainer_id', $trainer->id)
                    ->where('user_id', $user->id);

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

                $chats = $query->orderBy('timestamp', 'asc')->get();

                // Tandai pesan dari USER sebagai sudah dibaca (hanya pesan user->trainer)
                $updatedCount = TrainerChat::where('trainer_id', $trainer->id)
                    ->where('user_id', $user->id)
                    ->where('sender_type', 'user')
                    ->where('read_status', false)
                    ->update(['read_status' => true]);

                Log::info('Messages marked as read (index)', [
                    'trainer_id' => $trainer->id,
                    'user_id' => $user->id,
                    'updated_count' => $updatedCount
                ]);
            }

            // daftar tanggal unik
            $availableDates = TrainerChat::where('trainer_id', $trainer->id)
                ->when($user, fn($q) => $q->where('user_id', $user->id))
                ->selectRaw('DATE(timestamp) as date')
                ->distinct()
                ->orderBy('date', 'desc')
                ->pluck('date');

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
            ]);

            return back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    /**
     * 📨 Kirim pesan ke user
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'message' => 'required|string|max:1000',
            ]);

            $trainer = Auth::user();
            $user    = User::findOrFail($request->user_id);

            // Cegah kirim pesan ke user milik trainer lain
            if ($user->trainer_id != $trainer->id) {
                Log::warning('Unauthorized chat attempt', [
                    'trainer_id' => $trainer->id,
                    'target_user_id' => $user->id
                ]);
                return response()->json(['error' => 'Tidak dapat mengirim pesan ke user lain.'], 403);
            }

            // Simpan pesan
            $chat = TrainerChat::create([
                'trainer_id'  => $trainer->id,
                'user_id'     => $user->id,
                'message'     => $request->message,
                'sender_type' => 'trainer',
                'timestamp'   => now(),
                'read_status' => false,
            ]);

            Log::info('Trainer message sent', [
                'trainer_id' => $trainer->id,
                'user_id' => $user->id,
                'chat_id' => $chat->id
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
            Log::error('Error sending message', [
                'trainer_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json(['error' => 'Gagal mengirim pesan.'], 500);
        }
    }

    /**
     * ✅ Tandai semua pesan user sebagai sudah dibaca (API)
     */
    public function markAllRead(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id'
            ]);

            $trainer = Auth::user();
            $userId  = (int) $request->input('user_id'); // ensure INT

            $updatedCount = TrainerChat::where('trainer_id', $trainer->id)
                ->where('user_id', $userId)
                ->where('sender_type', 'user')
                ->where('read_status', false)
                ->update(['read_status' => true]);

            Log::info('Messages marked as read via API', [
                'trainer_id' => $trainer->id,
                'user_id' => $userId,
                'updated_count' => $updatedCount
            ]);

            return response()->json([
                'success' => true,
                'updated_count' => $updatedCount
            ]);
        } catch (Exception $e) {
            Log::error('Error marking messages read', [
                'trainer_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json(['error' => 'Gagal menandai pesan.'], 500);
        }
    }

    /**
     * 🗑 Hapus pesan milik trainer
     */
    public function destroy($id)
    {
        try {
            $trainer = Auth::user();
            $chat = TrainerChat::findOrFail($id);

            if ($chat->trainer_id != $trainer->id || $chat->sender_type !== 'trainer') {
                Log::warning('Unauthorized deletion attempt', [
                    'trainer_id' => $trainer->id,
                    'chat_id' => $id
                ]);
                abort(403, 'Anda tidak dapat menghapus pesan member.');
            }

            $chat->delete();

            Log::info('Chat deleted', [
                'trainer_id' => $trainer->id,
                'chat_id' => $id
            ]);

            return response()->json(['success' => true]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Pesan tidak ditemukan.'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Gagal menghapus pesan.'], 500);
        }
    }
}
