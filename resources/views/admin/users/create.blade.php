<x-layouts.admin>
    <x-slot name="title">
        Tambah <span class="text-amber-400">User Baru</span>
    </x-slot>

    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 overflow-hidden shadow-sm sm:rounded-lg">

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="p-8 space-y-6">

                @if ($errors->any())
                     <div class="mb-6 bg-red-900/50 text-red-300 border border-red-700 p-4 rounded-md">
                        <p>Ups! Ada beberapa kesalahan:</p>
                        <ul class="list-disc list-inside mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-amber-400">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-amber-400">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-amber-400">Password</label>
                        <input type="password" name="password" id="password" required
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="role" class="block text-sm font-medium text-amber-400">Role</label>
                        <select name="role" id="role" class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                            <option value="trainer" {{ old('role') == 'trainer' ? 'selected' : '' }}>Trainer</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-300">Gender</label>
                        <select name="gender" id="gender" class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                            <option value="">Pilih Gender...</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-300">Age</label>
                        <input type="number" name="age" id="age" value="{{ old('age') }}"
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                    </div>
                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-300">Weight (kg)</label>
                        <input type="number" step="0.1" name="weight" id="weight" value="{{ old('weight') }}"
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                    </div>
                    <div>
                        <label for="height" class="block text-sm font-medium text-gray-300">Height (cm)</label>
                        <input type="number" step="0.1" name="height" id="height" value="{{ old('height') }}"
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                    </div>
                    <div>
                        <label for="goal_id" class="block text-sm font-medium text-gray-300">Goal ID</label>
                        <input type="number" name="goal_id" id="goal_id" value="{{ old('goal_id') }}"
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                    </div>
                </div>

            </div>

            <div class="bg-gray-900/50 px-8 py-4 flex justify-end">
                <button type="submit"
                        class="px-8 py-3 rounded-md text-base font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                    Simpan User
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
