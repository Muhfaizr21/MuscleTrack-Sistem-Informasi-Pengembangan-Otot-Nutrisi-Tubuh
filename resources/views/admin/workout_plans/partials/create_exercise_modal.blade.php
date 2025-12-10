<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold text-white">Tambah Latihan Baru</h3>
        <button onclick="closeModal()" class="text-slate-400 hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <form id="addExerciseForm" method="POST" action="{{ route('admin.workout-plans.exercises.store', $workoutPlan) }}">
        @csrf
        
        <div class="space-y-4">
            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Nama Latihan *</label>
                <input type="text" name="name" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Type -->
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Jenis Latihan</label>
                <select name="type" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="strength">Strength</option>
                    <option value="cardio">Cardio</option>
                    <option value="core">Core</option>
                    <option value="flexibility">Flexibility</option>
                    <option value="warmup">Warm-up</option>
                    <option value="cooldown">Cool-down</option>
                </select>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Sets -->
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Sets</label>
                    <input type="number" name="sets" min="1" max="20" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Reps -->
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Reps</label>
                    <input type="text" name="reps" placeholder="10-12" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Duration -->
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Durasi (menit)</label>
                    <input type="number" name="duration_minutes" min="1" max="60" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Rest -->
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Istirahat (detik)</label>
                    <input type="number" name="rest_seconds" min="0" max="600" value="60" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
            </div>

            <!-- Muscle Group -->
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Kelompok Otot</label>
                <input type="text" name="muscle_group" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Equipment -->
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Peralatan</label>
                <input type="text" name="equipment" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Video URL -->
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">URL Video Demo</label>
                <input type="url" name="video_url" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Instructions -->
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Instruksi</label>
                <textarea name="instructions" rows="3" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
            </div>

            <!-- Notes -->
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Catatan</label>
                <textarea name="notes" rows="2" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <button type="button" onclick="closeModal()" class="px-4 py-2 rounded-lg bg-slate-700 text-slate-300 hover:bg-slate-600 transition-colors">
                Batal
            </button>
            <button type="submit" class="px-4 py-2 rounded-lg bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold hover:shadow-green-500/30 transition-all duration-300">
                Simpan Latihan
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('addExerciseForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Add new exercise to list
                const exerciseList = document.getElementById('exerciseList');
                if (exerciseList) {
                    exerciseList.insertAdjacentHTML('beforeend', data.html);
                } else {
                    // Reload page if exercise list doesn't exist
                    location.reload();
                }
                
                closeModal();
                showToast('success', data.message);
            }
        })
        .catch(error => {
            showToast('error', 'Terjadi kesalahan');
        });
    });
</script>