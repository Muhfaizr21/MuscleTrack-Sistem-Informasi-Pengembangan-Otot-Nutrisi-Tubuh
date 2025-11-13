<x-layouts.admin>
    <x-slot name="title">
        Edit <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Exercise</span>
    </x-slot>

    <div class="max-w-5xl mx-auto bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 p-8">
        <h2 class="text-2xl font-bold text-white mb-6">
            ✏️ Edit Exercise: <span class="text-green-400">{{ $exercise->name }}</span>
        </h2>

        <form method="POST" action="{{ route('admin.exercises.update', $exercise) }}" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Nama Exercise --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Nama Exercise *</label>
                <input type="text" name="name" value="{{ old('name', $exercise->name) }}" required
                       class="w-full bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all"
                       placeholder="Masukkan nama exercise">
                @error('name') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Deskripsi</label>
                <textarea name="description" rows="3"
                          class="w-full bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all"
                          placeholder="Jelaskan cara melakukan exercise ini...">{{ old('description', $exercise->description) }}</textarea>
                @error('description') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Type + Muscle Group --}}
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Tipe Latihan *</label>
                    <select name="type" required
                            class="w-full bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="cardio" {{ old('type', $exercise->type) == 'cardio' ? 'selected' : '' }}>💓 Cardio</option>
                        <option value="strength" {{ old('type', $exercise->type) == 'strength' ? 'selected' : '' }}>💪 Strength</option>
                        <option value="flexibility" {{ old('type', $exercise->type) == 'flexibility' ? 'selected' : '' }}>🧘 Flexibility</option>
                        <option value="balance" {{ old('type', $exercise->type) == 'balance' ? 'selected' : '' }}>⚖️ Balance</option>
                    </select>
                    @error('type') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Otot Target</label>
                    <input type="text" name="muscle_group" value="{{ old('muscle_group', $exercise->muscle_group) }}"
                           class="w-full bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all"
                           placeholder="Contoh: Chest, Legs, Core">
                    @error('muscle_group') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Equipment + Difficulty --}}
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Peralatan</label>
                    <input type="text" name="equipment" value="{{ old('equipment', $exercise->equipment) }}"
                           class="w-full bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all"
                           placeholder="Contoh: Dumbbell, Barbell, None">
                    @error('equipment') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Level Kesulitan *</label>
                    <select name="difficulty" required
                            class="w-full bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all">
                        <option value="">-- Pilih Level --</option>
                        <option value="beginner" {{ old('difficulty', $exercise->difficulty) == 'beginner' ? 'selected' : '' }}>🟢 Beginner</option>
                        <option value="intermediate" {{ old('difficulty', $exercise->difficulty) == 'intermediate' ? 'selected' : '' }}>🟡 Intermediate</option>
                        <option value="advanced" {{ old('difficulty', $exercise->difficulty) == 'advanced' ? 'selected' : '' }}>🔴 Advanced</option>
                    </select>
                    @error('difficulty') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Video & Gambar --}}
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Video URL (YouTube)</label>
                    <input type="url" name="video_url" value="{{ old('video_url', $exercise->video_url) }}"
                           class="w-full bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all"
                           placeholder="https://youtube.com/... atau https://youtu.be/..."
                           id="video-url-input">
                    <p class="text-slate-400 text-xs mt-1">Support YouTube URL pendek atau lengkap</p>
                    @error('video_url') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Gambar URL</label>
                    <input type="url" name="image_url" value="{{ old('image_url', $exercise->image_url) }}"
                           class="w-full bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all"
                           placeholder="https://cdn.example.com/...">
                    @error('image_url') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Video Preview --}}
            @if($exercise->video_url || old('video_url'))
            <div id="video-preview" class="mt-4">
                <label class="block text-sm font-medium text-slate-300 mb-2">Preview Video:</label>
                <div class="bg-slate-900 rounded-lg overflow-hidden max-w-2xl">
                    @php
                        $videoUrl = old('video_url', $exercise->video_url);
                        $videoId = '';

                        if (str_contains($videoUrl, 'youtu.be')) {
                            $videoId = substr($videoUrl, strpos($videoUrl, 'youtu.be/') + 9);
                        } elseif (str_contains($videoUrl, 'v=')) {
                            $videoId = substr($videoUrl, strpos($videoUrl, 'v=') + 2);
                            if (str_contains($videoId, '&')) {
                                $videoId = substr($videoId, 0, strpos($videoId, '&'));
                            }
                        }
                    @endphp
                    @if($videoId)
                    <iframe src="https://www.youtube.com/embed/{{ $videoId }}"
                            class="w-full h-64 rounded-lg"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                    </iframe>
                    @endif
                </div>
            </div>
            @endif

            {{-- Kalori & Durasi --}}
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Kalori Terbakar (kcal)</label>
                    <input type="number" name="calories_burned" value="{{ old('calories_burned', $exercise->calories_burned) }}" min="0" step="1"
                           class="w-full bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all"
                           placeholder="0">
                    @error('calories_burned') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Durasi (detik)</label>
                    <input type="number" name="duration" value="{{ old('duration', $exercise->duration) }}" min="0" step="1"
                           class="w-full bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all"
                           placeholder="0">
                    @error('duration') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Status *</label>
                <select name="status" required
                        class="w-full bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all">
                    <option value="active" {{ old('status', $exercise->status) == 'active' ? 'selected' : '' }}>✅ Active</option>
                    <option value="inactive" {{ old('status', $exercise->status) == 'inactive' ? 'selected' : '' }}>❌ Inactive</option>
                </select>
                @error('status') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Relasi ke Workout Plan --}}
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Terhubung ke Workout Plan</label>
                <select name="workout_plan_id"
                        class="w-full bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-white focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all">
                    <option value="">-- Pilih Workout Plan (Opsional) --</option>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}" {{ old('workout_plan_id', $exercise->workout_plan_id) == $plan->id ? 'selected' : '' }}>
                            {{ $plan->title }} ({{ $plan->level ?? 'No Level' }})
                        </option>
                    @endforeach
                </select>
                @error('workout_plan_id') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-700/50">
                <a href="{{ route('admin.exercises.index') }}"
                   class="px-6 py-2 rounded-xl bg-slate-700 text-slate-200 hover:bg-slate-600 transition-all duration-300 flex items-center gap-2">
                    <span>✕</span> Batal
                </a>
                <button type="submit"
                        class="px-6 py-2 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold shadow-lg hover:shadow-green-500/30 hover:scale-105 transition-all duration-300 flex items-center gap-2">
                    <span>💾</span> Perbarui Exercise
                </button>
            </div>
        </form>
    </div>

    <script>
        // Real-time video preview untuk edit form
        document.addEventListener('DOMContentLoaded', function() {
            const videoUrlInput = document.getElementById('video-url-input');
            let previewContainer = document.getElementById('video-preview');

            function updateVideoPreview(videoUrl) {
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
                        previewContainer = document.createElement('div');
                        previewContainer.id = 'video-preview';
                        previewContainer.className = 'mt-4';
                        previewContainer.innerHTML = `
                            <label class="block text-sm font-medium text-slate-300 mb-2">Preview Video:</label>
                            <div class="bg-slate-900 rounded-lg overflow-hidden max-w-2xl">
                                <iframe src="https://www.youtube.com/embed/${videoId}"
                                        class="w-full h-64 rounded-lg"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen>
                                </iframe>
                            </div>
                        `;
                        videoUrlInput.parentNode.parentNode.after(previewContainer);
                    } else {
                        const iframe = previewContainer.querySelector('iframe');
                        if (iframe) {
                            iframe.src = `https://www.youtube.com/embed/${videoId}`;
                        }
                    }
                } else if (previewContainer && !videoUrl) {
                    previewContainer.remove();
                    previewContainer = null;
                }
            }

            // Event listener untuk input video URL
            if (videoUrlInput) {
                videoUrlInput.addEventListener('input', function(e) {
                    updateVideoPreview(e.target.value);
                });

                // Initialize preview jika ada value
                if (videoUrlInput.value) {
                    updateVideoPreview(videoUrlInput.value);
                }
            }
        });
    </script>
</x-layouts.admin>
