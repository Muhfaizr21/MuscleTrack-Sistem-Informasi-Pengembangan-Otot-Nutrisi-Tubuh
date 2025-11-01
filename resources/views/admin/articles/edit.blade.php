<x-layouts.admin>
    <x-slot name="title">
        Edit <span class="text-amber-400">Artikel</span>
    </x-slot>

    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 overflow-hidden shadow-sm sm:rounded-lg">

        <form id="update-article-form" action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

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
                        <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" required
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-300">Kategori</label>
                        <input type="text" name="category" id="category" value="{{ old('category', $article->category) }}"
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                    </div>
                </div>

                <div>
                    <label for="summary" class="block text-sm font-medium text-gray-300">Ringkasan (Summary)</label>
                    <textarea name="summary" id="summary" rows="3"
                              class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">{{ old('summary', $article->summary) }}</textarea>
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-amber-400">Konten Lengkap</label>
                    <textarea name="content" id="content" rows="10"
                              class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">{{ old('content', $article->content) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300">Ganti Gambar Utama</label>
                    <div class="flex items-center gap-4 mt-2">
                        <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="h-16 w-16 object-cover rounded-md border border-gray-700">
                        <input type="file" name="image" id="image" accept="image/*"
                               class="block w-full text-sm text-gray-400
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-full file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-amber-400/20 file:text-amber-300
                                      hover:file:bg-amber-400/30">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengganti gambar.</p>
                </div>
            </div>
        </form> <div class="bg-gray-900/50 px-8 py-4 flex justify-between items-center">

            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus artikel ini?');" class="m-0">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-400 text-sm font-medium">Hapus Artikel</button>
            </form>

            <button type="submit" form="update-article-form"
                    class="px-8 py-3 rounded-md text-base font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                Simpan Perubahan
            </button>
        </div>
    </div>
</x-layouts.admin>
