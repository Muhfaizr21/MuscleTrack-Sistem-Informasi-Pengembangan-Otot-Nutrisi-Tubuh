<?php

namespace App\Events;

use App\Models\TrainerChat;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewTrainerChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat;

    /**
     * Buat instance event baru.
     */
    public function __construct(TrainerChat $chat)
    {
        // Pastikan timestamp terkonversi ke instance Carbon
        if (! $chat->timestamp instanceof \Carbon\Carbon) {
            $chat->timestamp = \Carbon\Carbon::parse($chat->timestamp);
        }

        $this->chat = $chat;
    }

    /**
     * Channel yang digunakan untuk broadcast pesan.
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('chat.'.$this->chat->user_id);
    }

    /**
     * Nama event yang dikirim via Pusher (frontend listener).
     */
    public function broadcastAs(): string
    {
        return 'new-trainer-chat-message';
    }

    /**
     * Data yang dikirim ke frontend.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->chat->id,
            'message' => $this->chat->message,
            'timestamp' => $this->chat->timestamp ? $this->chat->timestamp->format('H:i') : now()->format('H:i'),
            'sender' => $this->chat->trainer_id ? 'trainer' : 'user',
            'trainer_id' => $this->chat->trainer_id,
            'user_id' => $this->chat->user_id,
        ];
    }
}
