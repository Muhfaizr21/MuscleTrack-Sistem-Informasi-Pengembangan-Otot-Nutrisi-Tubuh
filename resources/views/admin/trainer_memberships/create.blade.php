<x-layouts.admin>
    <x-slot name="title">
        Tugaskan <span class="text-amber-400">Trainer</span>
    </x-slot>

    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 overflow-hidden shadow-sm sm:rounded-lg max-w-2xl mx-auto">
        <form action="{{ route('admin.trainer-memberships.store') }}" method="POST">
            @csrf
            <div class="p-8 space-y-6">

                @if ($errors->any())
                     <div class="mb-6 bg-red-900/50 text-red-300 border border-red-700 p-4 rounded-md">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label for="user_id" class="block text-sm font-medium text-amber-400">Pilih User (Member)</label>
                    <select name="user_id" id="user_id" required
                            class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                        <option value="">-- Pilih User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="trainer_id" class="block text-sm font-medium text-amber-400">Tugaskan ke Trainer</label>
                    <select name="trainer_id" id="trainer_id" required
                            class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                        <option value="">-- Pilih Trainer --</option>
                        @foreach($trainers as $trainer)
                            <option value="{{ $trainer->id }}" {{ old('trainer_id') == $trainer->id ? 'selected' : '' }}>
                                {{ $trainer->name }} ({{ $trainer->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="bg-gray-900/50 px-8 py-4 flex justify-between items-center">
                <a href="{{ route('admin.trainer-memberships.index') }}" class="text-gray-400 hover:text-white text-sm">
                    Batal
                </a>
                <button type="submit"
                        class="px-8 py-3 rounded-md text-base font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                    Simpan Penugasan
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
