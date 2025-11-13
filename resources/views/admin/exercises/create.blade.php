<x-layouts.admin>
    <x-slot name="title">
        Tambah <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Exercise</span>
    </x-slot>

    <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden max-w-4xl mx-auto">

        {{-- Header --}}
        <div class="p-6 border-b border-slate-700/50">
            <h3 class="text-2xl font-bold text-white mb-2">
                Buat <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Exercise Baru</span>
            </h3>
            <p class="text-slate-400 text-sm">Tambahkan latihan baru ke database dan hubungkan ke workout plan</p>
        </div>

        <form action="{{ route('admin.exercises.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            {{-- Nama Exercise --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Nama Exercise</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                       placeholder="Contoh: Push Up, Squat, Running"
                       required>
                @error('name')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Deskripsi</label>
                <textarea name="description" rows="3"
                          class="w-full bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                          placeholder="Jelaskan cara melakukan exercise ini...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Type --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Tipe Latihan</label>
                <select name="type"
                        class="w-full bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                        required>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="cardio" {{ old('type') == 'cardio' ? 'selected' : '' }}>💓 Cardio</option>
                    <option value="strength" {{ old('type') == 'strength' ? 'selected' : '' }}>💪 Strength</option>
                    <option value="flexibility" {{ old('type') == 'flexibility' ? 'selected' : '' }}>🧘 Flexibility</option>
                    <option value="balance" {{ old('type') == 'balance' ? 'selected' : '' }}>⚖️ Balance</option>
                </select>
                @error('type')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Muscle Group --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Otot Target</label>
                <input type="text" name="muscle_group" value="{{ old('muscle_group') }}"
                       class="w-full bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                       placeholder="Contoh: Chest, Legs, Core">
                @error('muscle_group')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Equipment --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Peralatan (optional)</label>
                <input type="text" name="equipment" value="{{ old('equipment') }}"
                       class="w-full bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                       placeholder="Contoh: Dumbbell, Barbell, None">
                @error('equipment')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Difficulty --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Tingkat Kesulitan</label>
                <select name="difficulty"
                        class="w-full bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                        required>
                    <option value="">-- Pilih Kesulitan --</option>
                    <option value="beginner" {{ old('difficulty') == 'beginner' ? 'selected' : '' }}>🟢 Beginner</option>
                    <option value="intermediate" {{ old('difficulty') == 'intermediate' ? 'selected' : '' }}>🟡 Intermediate</option>
                    <option value="advanced" {{ old('difficulty') == 'advanced' ? 'selected' : '' }}>🔴 Advanced</option>
                </select>
                @error('difficulty')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Video & Image --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Video URL (YouTube)</label>
                    <input type="url" name="video_url" value="{{ old('video_url') }}"
                           placeholder="https://youtu.be/... atau https://www.youtube.com/watch?v=..."
                           class="w-full bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                    <p class="text-slate-400 text-xs mt-1">Support YouTube URL pendek atau lengkap</p>
                    @error('video_url')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Gambar URL (optional)</label>
                    <input type="url" name="image_url" value="{{ old('image_url') }}"
                           placeholder="https://example.com/image.jpg"
                           class="w-full bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                    @error('image_url')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Video Preview --}}
            @if(old('video_url'))
            <div id="video-preview" class="mt-2">
                <label class="block text-sm font-medium text-slate-300 mb-2">Preview Video:</label>
                <div class="aspect-w-16 aspect-h-9 bg-slate-900 rounded-lg overflow-hidden">
                    <iframe src="{{ \Illuminate\Support\Str::contains(old('video_url'), 'youtu.be') ? 'https://www.youtube.com/embed/' . \Illuminate\Support\Str::after(old('video_url'), 'youtu.be/') : 'https://www.youtube.com/embed/' . \Illuminate\Support\Str::after(old('video_url'), 'v=') }}"
                            class="w-full h-48 rounded-lg"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                    </iframe>
                </div>
            </div>
            @endif

            {{-- Kalori & Durasi --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Kalori Terbakar (kcal)</label>
                    <input type="number" name="calories_burned" value="{{ old('calories_burned', 0) }}" min="0" step="1"
                           class="w-full bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                    @error('calories_burned')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Durasi (detik)</label>
                    <input type="number" name="duration" value="{{ old('duration', 0) }}" min="0" step="1"
                           class="w-full bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                    @error('duration')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Workout Plan --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Hubungkan ke Workout Plan (optional)</label>
                <select name="workout_plan_id"
                        class="w-full bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                    <option value="">-- Tidak ada --</option>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}" {{ old('workout_plan_id') == $plan->id ? 'selected' : '' }}>
                            {{ $plan->title }} ({{ $plan->level }})
                        </option>
                    @endforeach
                </select>
                @error('workout_plan_id')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Status</label>
                <select name="status"
                        class="w-full bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                        required>
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>✅ Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>❌ Inactive</option>
                </select>
                @error('status')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end gap-4 pt-4 border-t border-slate-700/50">
                <a href="{{ route('admin.exercises.index') }}"
                   class="px-5 py-2 rounded-lg bg-slate-700 text-slate-300 hover:bg-slate-600 transition-all duration-300">
                    ✕ Batal
                </a>
                <button type="submit"
                        class="px-6 py-2 rounded-lg bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold shadow-lg hover:shadow-green-500/30 hover:scale-105 transition-all duration-300 flex items-center gap-2">
                    💾 Simpan Exercise
                </button>
            </div>
        </form>
    </div>

    <script>
        // Real-time video preview
        document.querySelector('input[name="video_url"]').addEventListener('input', function(e) {
            const videoUrl = e.target.value;
            const previewContainer = document.getElementById('video-preview');

            if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
                let videoId = '';

                if (videoUrl.includes('youtu.be')) {
                    videoId = videoUrl.split('youtu.be/')[1];
                } else if (videoUrl.includes('v=')) {
                    videoId = videoUrl.split('v=')[1];
                    const ampersandPosition = videoId.indexOf('&');
                    if (ampersandPosition !== -1) {
                        videoId = videoId.substring(0, ampersandPosition);
                    }
                }

                if (videoId) {
                    if (!previewContainer) {
                        const newPreview = document.createElement('div');
                        newPreview.id = 'video-preview';
                        newPreview.innerHTML = `
                            <label class="block text-sm font-medium text-slate-300 mb-2">Preview Video:</label>
                            <div class="aspect-w-16 aspect-h-9 bg-slate-900 rounded-lg overflow-hidden">
                                <iframe src="https://www.youtube.com/embed/${videoId}"
                                        class="w-full h-48 rounded-lg"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen>
                                </iframe>
                            </div>
                        `;
                        e.target.parentNode.parentNode.after(newPreview);
                    } else {
                        previewContainer.querySelector('iframe').src = `https://www.youtube.com/embed/${videoId}`;
                    }
                }
            } else if (previewContainer) {
                previewContainer.remove();
            }
        });
    </script>
</x-layouts.admin>
