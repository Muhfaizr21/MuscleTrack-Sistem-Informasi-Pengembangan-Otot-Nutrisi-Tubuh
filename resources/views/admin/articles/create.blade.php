<x-layouts.admin>
    <x-slot name="title">
        Tulis <span class="text-amber-400">Artikel Baru</span>
    </x-slot>

    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 overflow-hidden shadow-sm sm:rounded-lg">
        <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
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

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-amber-400">Judul Artikel</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-300">Kategori</label>
                        <input type="text" name="category" id="category" value="{{ old('category') }}"
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400" placeholder="Misal: Nutrisi">
                    </div>
                </div>

                <div>
                    <label for="summary" class="block text-sm font-medium text-gray-300">Ringkasan (Summary)</label>
                    <textarea name="summary" id="summary" rows="3"
                              class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400"
                              placeholder="Ringkasan singkat untuk preview artikel...">{{ old('summary') }}</textarea>
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-amber-400">Konten Lengkap</label>
                    <textarea name="content" id="content" rows="10"
                              class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400"
                              placeholder="Tulis isi artikel di sini...">{{ old('content') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300">Gambar Utama (Opsional)</label>
                    <input type="file" name="image" id="image" accept="image/*"
                           class="mt-2 block w-full text-sm text-gray-400
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-amber-400/20 file:text-amber-300
                                  hover:file:bg-amber-400/30">
                </div>
            </div>

            <div class="bg-gray-900/50 px-8 py-4 flex justify-end">
                <button type="submit"
                        class="px-8 py-3 rounded-md text-base font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                    Publikasikan Artikel
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
