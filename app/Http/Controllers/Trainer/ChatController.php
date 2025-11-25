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

class ChatController extends Controller
{
    /**
     * 💬 Tampilkan daftar member + chat + filter tanggal
     */
    public function index(Request $request)
    {
        try {
            $trainer = Auth::user();

            $members = User::where('trainer_id', $trainer->id)
                ->where('role', 'user')
                ->withCount([
                    'trainerChatsAsUser as unread_count' => function ($query) use ($trainer) {
                        $query->where('trainer_id', $trainer->id)
                            ->where('sender_type', 'user')
                            ->where('read_status', false);
                    },
                ])
                ->get();

            $user = null;

            // Tentukan member aktif
            if ($request->filled('user')) {
                $user = User::where('id', $request->user)
                    ->where('trainer_id', $trainer->id)
                    ->first();
            } elseif ($members->count() === 1) {
                $user = $members->first();
            } elseif ($members->count() > 0) {
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

                // Cek unread
                $unreadBefore = TrainerChat::where('trainer_id', $trainer->id)
                    ->where('user_id', $user->id)
                    ->where('sender_type', 'user')
                    ->where('read_status', false)
                    ->count();

                // Update read only jika ada unread
                if ($unreadBefore > 0) {
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
            }

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
        DB::beginTransaction();
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'message' => 'required|string|max:1000',
            ]);

            $trainer = Auth::user();
            $user = User::findOrFail($request->user_id);

            if ($user->trainer_id != $trainer->id) {
                return response()->json(['error' => 'Tidak dapat mengirim pesan ke user lain.'], 403);
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
            ]);

            return response()->json(['error' => 'Gagal mengirim pesan.'], 500);
        }
    }

    /**
     * ✅ Tandai semua pesan user sebagai sudah dibaca (API)
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

            $user = User::where('id', $userId)
                ->where('trainer_id', $trainer->id)
                ->first();

            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $updatedCount = TrainerChat::where('trainer_id', $trainer->id)
                ->where('user_id', $userId)
                ->where('sender_type', 'user')
                ->where('read_status', false)
                ->update(['read_status' => true]);

            DB::commit();

            return response()->json([
                'success' => true,
                'updated_count' => $updatedCount,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal menandai pesan.'], 500);
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

            // Validasi: pesan hanya boleh dihapus jika dikirim trainer
            if ($chat->trainer_id != $trainer->id || $chat->sender_type !== 'trainer') {

                Log::warning('Unauthorized delete attempt', [
                    'trainer_id' => $trainer->id,
                    'chat_id' => $id,
                    'chat_trainer_id' => $chat->trainer_id,
                    'sender_type' => $chat->sender_type
                ]);

                return response()->json(['error' => 'Anda tidak dapat menghapus pesan member.'], 403);
            }

            // Log sebelum dihapus
            Log::info('Deleting chat...', [
                'chat_id' => $chat->id,
                'message' => $chat->message,
                'timestamp' => $chat->timestamp,
                'sender_type' => $chat->sender_type,
            ]);

            $chat->delete();
            DB::commit();

            Log::info('Chat deleted successfully', [
                'chat_id' => $id,
                'trainer_id' => $trainer->id
            ]);

            return response()->json(['success' => true]);
        } catch (ModelNotFoundException $e) {

            DB::rollBack();

            Log::error('Chat not found while deleting', [
                'chat_id' => $id,
                'trainer_id' => Auth::id(),
            ]);

            return response()->json(['error' => 'Pesan tidak ditemukan.'], 404);
        } catch (Exception $e) {

            DB::rollBack();

            Log::error('Error deleting chat message', [
                'trainer_id' => Auth::id(),
                'chat_id' => $id,
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['error' => 'Gagal menghapus pesan.'], 500);
        }
    }

    /**
     * 🔍 Debug: Cek status read pesan
     */
    public function debugReadStatus(Request $request)
    {
        try {
            $trainer = Auth::user();
            $userId = $request->input('user_id');

            $readStatus = TrainerChat::where('trainer_id', $trainer->id)
                ->where('user_id', $userId)
                ->select('id', 'message', 'sender_type', 'read_status', 'timestamp')
                ->orderBy('timestamp', 'desc')
                ->limit(10)
                ->get();

            return response()->json([
                'success' => true,
                'read_status' => $readStatus
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
