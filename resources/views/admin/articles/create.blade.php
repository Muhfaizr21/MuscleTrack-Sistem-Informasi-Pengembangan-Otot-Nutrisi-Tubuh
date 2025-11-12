<x-layouts.admin>
    <x-slot name="title">
        Tulis <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Artikel Baru</span>
    </x-slot>

    <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden">

        <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Form Header -->
            <div class="p-6 border-b border-slate-700/50">
                <h3 class="text-2xl font-bold text-white">
                    Tulis <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Artikel Baru</span>
                </h3>
                <p class="text-sm text-slate-400 mt-1">Buat artikel informatif untuk dibagikan dengan komunitas</p>
            </div>

            <!-- Form Content -->
            <div class="p-8 space-y-8">

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="bg-red-500/15 backdrop-blur-sm text-red-400 border border-red-500/20 p-4 rounded-xl">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <strong>Perhatian!</strong>
                        </div>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Title & Category Section -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        Informasi Artikel
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Title -->
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-slate-300 mb-2">Judul Artikel</label>
                            <div class="relative">
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                       class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 text-slate-200 placeholder-slate-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300"
                                       placeholder="Masukkan judul artikel yang menarik">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-slate-300 mb-2">Kategori</label>
                            <div class="relative">
                                <input type="text" name="category" id="category" value="{{ old('category') }}"
                                       class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 text-slate-200 placeholder-slate-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300"
                                       placeholder="Misal: Nutrisi">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Summary Section -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                        Ringkasan Artikel
                    </h4>
                    <div>
                        <label for="summary" class="block text-sm font-medium text-slate-300 mb-2">Ringkasan</label>
                        <div class="relative">
                            <textarea name="summary" id="summary" rows="3"
                                      class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 text-slate-200 placeholder-slate-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300 resize-none"
                                      placeholder="Tulis ringkasan singkat untuk preview artikel...">{{ old('summary') }}</textarea>
                            <div class="absolute top-3 left-3">
                                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 mt-2">Ringkasan akan ditampilkan di halaman daftar artikel</p>
                    </div>
                </div>

                <!-- Content Section -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        Konten Lengkap
                    </h4>
                    <div>
                        <label for="content" class="block text-sm font-medium text-slate-300 mb-2">Konten Artikel</label>
                        <div class="relative">
                            <textarea name="content" id="content" rows="12" required
                                      class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 text-slate-200 placeholder-slate-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300 resize-none"
                                      placeholder="Tulis isi artikel lengkap di sini...">{{ old('content') }}</textarea>
                        </div>
                        <div class="flex items-center gap-2 mt-2 text-xs text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Gunakan format yang jelas dan mudah dipahami
                        </div>
                    </div>
                </div>

                <!-- Image Upload Section -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-emerald-400 rounded-full"></div>
                        Gambar Utama
                    </h4>
                    <div>
                        <label for="image" class="block text-sm font-medium text-slate-300 mb-3">Upload Gambar</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-slate-600/50 rounded-xl cursor-pointer bg-slate-700/30 hover:bg-slate-700/50 transition-all duration-300 group">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-3 text-slate-500 group-hover:text-green-400 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-slate-400 group-hover:text-slate-300 transition-colors duration-300">
                                        <span class="font-semibold">Klik untuk upload</span> atau drag and drop
                                    </p>
                                    <p class="text-xs text-slate-500">PNG, JPG, JPEG (Max. 5MB)</p>
                                </div>
                                <input id="image" name="image" type="file" class="hidden" accept="image/*" />
                            </label>
                        </div>
                        <div id="image-preview" class="mt-3 hidden">
                            <div class="flex items-center gap-3 p-3 bg-slate-700/30 rounded-xl border border-slate-600/50">
                                <img id="preview-image" class="w-16 h-16 object-cover rounded-lg" src="" alt="Preview">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-slate-300" id="preview-filename"></p>
                                    <p class="text-xs text-slate-500" id="preview-size"></p>
                                </div>
                                <button type="button" onclick="removeImagePreview()" class="text-red-400 hover:text-red-300 transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Form Footer -->
            <div class="bg-slate-800/50 px-8 py-6 border-t border-slate-700/50">
                <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                    <a href="{{ route('admin.articles.index') }}"
                       class="px-6 py-3 rounded-xl border border-slate-600/50 text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all duration-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Daftar
                    </a>
                    <div class="flex gap-3">
                        <button type="submit"
                                class="px-8 py-3 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold shadow-lg hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                            </svg>
                            Publikasikan Artikel
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Image Preview Functionality
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('preview-filename').textContent = file.name;
                    document.getElementById('preview-size').textContent = formatFileSize(file.size);
                    document.getElementById('image-preview').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        function removeImagePreview() {
            document.getElementById('image').value = '';
            document.getElementById('image-preview').classList.add('hidden');
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Auto-resize textareas
        document.querySelectorAll('textarea').forEach(textarea => {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        });
    </script>

</x-layouts.admin>
