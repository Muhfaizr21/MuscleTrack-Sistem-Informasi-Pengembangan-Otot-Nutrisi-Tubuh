@extends('layouts.trainer')

@section('title', '💬 Chat dengan ' . $user->name)

@section('content')
<div class="flex h-[85vh] max-w-6xl mx-auto bg-gray-100 border border-gray-300 rounded-2xl shadow-lg overflow-hidden">

    {{-- 🔹 SIDEBAR MEMBER INFO --}}
    <div class="w-1/3 border-r border-gray-300 bg-white flex flex-col justify-between">
        <div class="p-5 border-b border-gray-200">
            <h2 class="text-gray-800 text-lg font-bold">👤 {{ $user->name }}</h2>
            <p class="text-gray-500 text-sm mt-1">Member Aktif</p>
        </div>

        <div class="p-5 text-gray-600 text-sm space-y-2">
            <p><span class="text-gray-800 font-medium">Gender:</span> {{ ucfirst($user->gender) ?? '-' }}</p>
            <p><span class="text-gray-800 font-medium">Umur:</span> {{ $user->age ?? '-' }} tahun</p>
            <p><span class="text-gray-800 font-medium">Goal:</span> {{ $user->goal->name ?? 'Belum ada' }}</p>
        </div>
    </div>

    {{-- 🔹 MAIN CHAT AREA --}}
    <div class="flex-1 flex flex-col bg-gray-50">

        {{-- HEADER --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 bg-white shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h3 class="text-gray-800 font-semibold text-sm">{{ $user->name }}</h3>
                    <p class="text-xs text-green-500">🟢 Online</p>
                </div>
            </div>
        </div>

        {{-- CHAT BOX --}}
        <div id="chat-box" class="flex-1 overflow-y-auto px-6 py-4 space-y-4 bg-gray-50">
            @forelse ($chats as $msg)
                @if ($msg->sender_type === 'trainer')
                    {{-- 💬 PESAN TRAINER (KANAN) --}}
                    <div class="flex justify-end">
                        <div class="text-right max-w-[70%]">
                            <div class="bg-blue-600 text-white px-4 py-2 rounded-2xl rounded-br-none inline-block shadow-sm">
                                {{ $msg->message }}
                            </div>
                            <p class="text-[10px] text-gray-400 mt-1">{{ $msg->timestamp->format('H:i') }}</p>
                        </div>
                    </div>
                @else
                    {{-- 💬 PESAN MEMBER (KIRI) --}}
                    <div class="flex items-start gap-2">
                        <img src="{{ asset('images/default-user.png') }}" alt="user" class="w-8 h-8 rounded-full">
                        <div>
                            <div class="bg-white border border-gray-200 text-gray-800 px-4 py-2 rounded-2xl rounded-bl-none inline-block max-w-[70%] shadow-sm">
                                {{ $msg->message }}
                            </div>
                            <p class="text-[10px] text-gray-400 mt-1">{{ $msg->timestamp->format('H:i') }}</p>
                        </div>
                    </div>
                @endif
            @empty
                <p class="text-gray-400 italic text-center mt-10">Belum ada percakapan dengan {{ $user->name }}.</p>
            @endforelse
        </div>

        {{-- INPUT BAR --}}
        <form id="chat-form" class="flex items-center gap-3 p-4 border-t border-gray-200 bg-white">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <input type="text" name="message" id="chat-message"
                   class="flex-grow bg-gray-100 border border-gray-300 rounded-full px-4 py-2 text-gray-800 
                          placeholder-gray-500 focus:border-blue-500 focus:ring focus:ring-blue-200 outline-none"
                   placeholder="Ketik pesan..." required autocomplete="off">
            <button type="submit"
                    class="flex items-center justify-center w-10 h-10 bg-blue-600 hover:bg-blue-500 rounded-full shadow-md transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="currentColor"
                     viewBox="0 0 20 20">
                    <path d="M2.94 2.94a.75.75 0 011.06 0L17.5 16.44a.75.75 0 11-1.06 1.06L2.94 4a.75.75 0 010-1.06z" />
                </svg>
            </button>
        </form>
    </div>
</div>

{{-- 🔔 JS Kirim Pesan --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.getElementById('chat-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const input = document.getElementById('chat-message');
    const message = input.value.trim();
    if (!message) return;

    try {
        const res = await axios.post("{{ route('trainer.communication.chat.store') }}", {
            message: message,
            user_id: {{ $user->id }}
        });

        const box = document.getElementById('chat-box');
        box.insertAdjacentHTML('beforeend', `
            <div class="flex justify-end">
                <div class="text-right max-w-[70%]">
                    <div class="bg-blue-600 text-white px-4 py-2 rounded-2xl rounded-br-none inline-block shadow-sm">
                        ${message}
                    </div>
                    <p class="text-[10px] text-gray-400 mt-1">Baru saja</p>
                </div>
            </div>
        `);
        box.scrollTop = box.scrollHeight;
        input.value = '';
    } catch {
        alert('❌ Gagal mengirim pesan.');
    }
});
</script>
@endsection
