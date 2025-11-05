<x-layouts.admin>
    <x-slot name="title">
        Detail <span class="text-amber-400">Pesan</span>
    </x-slot>

    <div class="flex justify-between items-center mb-6">
        <h1 class="font-serif text-3xl font-bold text-white">
            Detail <span class="text-amber-400">Pesan</span>
        </h1>
        <a href="{{ route('admin.contact.index') }}" class="text-sm text-gray-400 hover:text-white transition-all">
            ⬅️ Kembali ke Daftar Pesan
        </a>
    </div>

    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 md:p-8 space-y-6">

            {{-- Info Pengirim --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-gray-700/50">
                <div>
                    <span class="block text-sm font-medium text-gray-400">Nama Pengirim</span>
                    <p class="text-lg text-white font-semibold">{{ $message->name }}</p>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-400">Email Pengirim</span>
                    <p class="text-lg text-white font-semibold">{{ $message->email }}</p>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-400">Waktu Kirim</span>
                    <p class="text-lg text-white font-semibold">{{ $message->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-400">Subjek</span>
                    <p class="text-lg text-white font-semibold">{{ $message->subject ?? '(Tidak ada subjek)' }}</p>
                </div>
            </div>

            {{-- Isi Pesan --}}
            <div>
                <span class="block text-sm font-medium text-amber-400 uppercase tracking-wider mb-2">Isi Pesan</span>
                <div class="text-gray-300 leading-relaxed whitespace-pre-wrap">
                    {{ $message->message }}
                </div>
            </div>

        </div>

        {{-- Tombol Hapus --}}
        <div class="bg-gray-900/50 px-8 py-4 flex justify-end">
            <form action="{{ route('admin.contact.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus pesan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-6 py-2.5 rounded-md text-sm font-bold text-white bg-red-600 hover:bg-red-500 transition-all shadow-lg shadow-red-500/20">
                    🗑️ Hapus Pesan
                </button>
            </form>
        </div>
    </div>
</x-layouts.admin>
