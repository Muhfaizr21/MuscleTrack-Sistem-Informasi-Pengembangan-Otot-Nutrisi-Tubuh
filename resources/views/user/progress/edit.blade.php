@extends('layouts.user')

@section('content')
    <div class="min-h-screen py-4 sm:py-6 lg:py-8">
        <div class="max-w-4xl mx-auto px-3 sm:px-4 lg:px-6 xl:px-8">

            {{-- Header Section --}}
            <div
                class="glass-dark rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 border border-amber-500/20 shadow-xl sm:shadow-2xl shadow-amber-500/10 mb-6 sm:mb-8">
                <div class="flex items-center gap-3 sm:gap-4">
                    <div
                        class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 bg-gradient-to-br from-amber-500 to-amber-700 rounded-xl sm:rounded-2xl flex items-center justify-center animate-glow">
                        <span class="text-lg sm:text-xl lg:text-2xl">✏️</span>
                    </div>
                    <div>
                        <h1 class="text-xl sm:text-2xl lg:text-3xl font-black text-white">
                            Edit <span class="text-gradient">Progress</span>
                        </h1>
                        <p class="text-amber-400/80 text-sm sm:text-base lg:text-lg mt-1 sm:mt-2">Update your fitness
                            progress data</p>
                    </div>
                </div>
            </div>

            {{-- Fitness Profile Info --}}
            @if($fitnessProfile)
                <div class="glass rounded-xl sm:rounded-2xl p-4 sm:p-6 border border-amber-500/20 mb-4 sm:mb-6">
                    <h3 class="text-base sm:text-lg font-semibold text-amber-400 mb-2 sm:mb-3">Your Fitness Profile</h3>
                    <div class="grid grid-cols-1 xs:grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 text-xs sm:text-sm">
                        <div class="bg-amber-500/5 rounded-lg p-2 sm:p-3">
                            <p class="text-amber-400/80 mb-1">Goal</p>
                            <p class="text-white font-semibold truncate">{{ $fitnessProfile->goal->name ?? 'Not Set' }}</p>
                        </div>
                        <div class="bg-amber-500/5 rounded-lg p-2 sm:p-3">
                            <p class="text-amber-400/80 mb-1">Activity Level</p>
                            <p class="text-white font-semibold capitalize truncate">
                                {{ $fitnessProfile->activity_level ?? 'Not Set' }}</p>
                        </div>
                        <div class="bg-amber-500/5 rounded-lg p-2 sm:p-3">
                            <p class="text-amber-400/80 mb-1">Daily Calories</p>
                            <p class="text-white font-semibold truncate">
                                {{ $fitnessProfile->daily_calorie_target ?? 'Not Set' }}</p>
                        </div>
                        <div class="bg-amber-500/5 rounded-lg p-2 sm:p-3">
                            <p class="text-amber-400/80 mb-1">Focus Areas</p>
                            <p class="text-white font-semibold text-xs truncate">
                                @if($fitnessProfile->preferred_muscle_groups)
                                    {{ implode(', ', json_decode($fitnessProfile->preferred_muscle_groups)) }}
                                @else
                                    Not Set
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Progress Form --}}
            <div
                class="glass-dark rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 border border-amber-500/20 shadow-xl sm:shadow-2xl shadow-amber-500/10">
                <form action="{{ route('user.progress.update', $progress->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-4 sm:mb-6">
                        {{-- Weight --}}
                        <div class="col-span-1">
                            <label for="weight"
                                class="block text-xs sm:text-sm font-semibold text-amber-400 mb-1 sm:mb-2">Weight (kg)
                                *</label>
                            <input type="number" step="0.1" name="weight" id="weight"
                                value="{{ old('weight', $progress->weight) }}"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg sm:rounded-xl bg-gray-900 border border-amber-500/30 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/50 text-white placeholder-amber-400/60 transition-all duration-300 text-sm sm:text-base"
                                required>
                            @error('weight')
                                <p class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Height --}}
                        <div class="col-span-1">
                            <label for="height"
                                class="block text-xs sm:text-sm font-semibold text-amber-400 mb-1 sm:mb-2">Height
                                (cm)</label>
                            <input type="number" step="0.1" name="height" id="height"
                                value="{{ old('height', $progress->height) }}"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg sm:rounded-xl bg-gray-900 border border-amber-500/30 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/50 text-white placeholder-amber-400/60 transition-all duration-300 text-sm sm:text-base">
                            @error('height')
                                <p class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Body Fat --}}
                        <div class="col-span-1">
                            <label for="body_fat"
                                class="block text-xs sm:text-sm font-semibold text-amber-400 mb-1 sm:mb-2">Body Fat
                                (%)</label>
                            <input type="number" step="0.1" name="body_fat" id="body_fat"
                                value="{{ old('body_fat', $progress->body_fat) }}"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg sm:rounded-xl bg-gray-900 border border-amber-500/30 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/50 text-white placeholder-amber-400/60 transition-all duration-300 text-sm sm:text-base">
                            @error('body_fat')
                                <p class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Muscle Mass --}}
                        <div class="col-span-1">
                            <label for="muscle_mass"
                                class="block text-xs sm:text-sm font-semibold text-amber-400 mb-1 sm:mb-2">Muscle Mass
                                (kg)</label>
                            <input type="number" step="0.1" name="muscle_mass" id="muscle_mass"
                                value="{{ old('muscle_mass', $progress->muscle_mass) }}"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg sm:rounded-xl bg-gray-900 border border-amber-500/30 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/50 text-white placeholder-amber-400/60 transition-all duration-300 text-sm sm:text-base">
                            @error('muscle_mass')
                                <p class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Waist --}}
                        <div class="col-span-1">
                            <label for="waist"
                                class="block text-xs sm:text-sm font-semibold text-amber-400 mb-1 sm:mb-2">Waist
                                (cm)</label>
                            <input type="number" step="0.1" name="waist" id="waist"
                                value="{{ old('waist', $progress->waist) }}"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg sm:rounded-xl bg-gray-900 border border-amber-500/30 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/50 text-white placeholder-amber-400/60 transition-all duration-300 text-sm sm:text-base">
                            @error('waist')
                                <p class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Chest --}}
                        <div class="col-span-1">
                            <label for="chest"
                                class="block text-xs sm:text-sm font-semibold text-amber-400 mb-1 sm:mb-2">Chest
                                (cm)</label>
                            <input type="number" step="0.1" name="chest" id="chest"
                                value="{{ old('chest', $progress->chest) }}"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg sm:rounded-xl bg-gray-900 border border-amber-500/30 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/50 text-white placeholder-amber-400/60 transition-all duration-300 text-sm sm:text-base">
                            @error('chest')
                                <p class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Arm --}}
                        <div class="col-span-1">
                            <label for="arm" class="block text-xs sm:text-sm font-semibold text-amber-400 mb-1 sm:mb-2">Arm
                                (cm)</label>
                            <input type="number" step="0.1" name="arm" id="arm" value="{{ old('arm', $progress->arm) }}"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg sm:rounded-xl bg-gray-900 border border-amber-500/30 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/50 text-white placeholder-amber-400/60 transition-all duration-300 text-sm sm:text-base">
                            @error('arm')
                                <p class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Recorded Date --}}
                        <div class="col-span-1">
                            <label for="recorded_at"
                                class="block text-xs sm:text-sm font-semibold text-amber-400 mb-1 sm:mb-2">Recorded Date
                                *</label>
                            <input type="date" name="recorded_at" id="recorded_at"
                                value="{{ old('recorded_at', $progress->recorded_at->format('Y-m-d')) }}"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg sm:rounded-xl bg-gray-900 border border-amber-500/30 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/50 text-white placeholder-amber-400/60 transition-all duration-300 text-sm sm:text-base"
                                required>
                            @error('recorded_at')
                                <p class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Photo Progress --}}
                        <div class="col-span-1 sm:col-span-2">
                            <label for="photo_progress"
                                class="block text-xs sm:text-sm font-semibold text-amber-400 mb-1 sm:mb-2">Progress
                                Photo</label>
                            <input type="file" name="photo_progress" id="photo_progress"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg sm:rounded-xl bg-gray-900 border border-amber-500/30 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/50 text-white file:mr-2 sm:file:mr-4 file:py-1 sm:file:py-2 file:px-2 sm:file:px-4 file:rounded-full file:border-0 file:text-xs sm:file:text-sm file:font-semibold file:bg-amber-500 file:text-black hover:file:bg-amber-400 transition-all duration-300 text-xs sm:text-sm">
                            @error('photo_progress')
                                <p class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror

                            @if($progress->photo_progress)
                                <div class="mt-2 sm:mt-3">
                                    <p class="text-amber-400 text-xs sm:text-sm mb-1 sm:mb-2">Current Photo:</p>
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('storage/' . $progress->photo_progress) }}" alt="Progress Photo"
                                            class="h-16 sm:h-20 lg:h-32 rounded-lg sm:rounded-xl border border-amber-500/20 object-cover">
                                        <div class="flex-1">
                                            <p class="text-amber-400/80 text-xs sm:text-sm">Photo will be replaced if you upload
                                                a new one</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Form Actions --}}
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 pt-4 sm:pt-6 border-t border-amber-500/20">
                        <button type="submit"
                            class="flex-1 px-4 sm:px-6 lg:px-8 py-3 sm:py-4 rounded-xl sm:rounded-2xl text-sm sm:text-base font-black text-black bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-amber-500/25 flex items-center justify-center gap-2 sm:gap-3">
                            <span class="text-base sm:text-lg lg:text-xl">💾</span>
                            <span>Update Progress</span>
                        </button>
                        <a href="{{ route('user.progress.index') }}"
                            class="px-4 sm:px-6 lg:px-8 py-3 sm:py-4 rounded-xl sm:rounded-2xl text-sm sm:text-base font-semibold text-amber-400 hover:text-white border border-amber-500/30 hover:bg-amber-500/10 transition-all duration-300 flex items-center justify-center gap-2 sm:gap-3">
                            <span>Cancel</span>
                        </a>
                    </div>
                </form>
            </div>

            {{-- Delete Section --}}
            <div
                class="glass-dark rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 border border-red-500/20 shadow-xl sm:shadow-2xl shadow-red-500/10 mt-6 sm:mt-8">
                <div class="text-center">
                    <div
                        class="w-12 h-12 sm:w-14 sm:h-14 lg:w-16 lg:h-16 bg-red-500/10 rounded-xl sm:rounded-2xl flex items-center justify-center mx-auto mb-3 sm:mb-4 border border-red-500/20">
                        <span class="text-xl sm:text-2xl text-red-400">🗑️</span>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-white mb-1 sm:mb-2">Delete Progress</h3>
                    <p class="text-red-400/80 text-xs sm:text-sm mb-4 sm:mb-6 max-w-md mx-auto">Once deleted, this progress
                        data cannot be recovered.</p>

                    <form action="{{ route('user.progress.destroy', $progress->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this progress? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 sm:px-6 lg:px-8 py-2 sm:py-3 rounded-lg sm:rounded-xl text-xs sm:text-sm font-semibold text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 transition-all duration-300 border border-red-500/30 hover:border-red-400/50 shadow-lg hover:shadow-red-500/25 w-full sm:w-auto">
                            Delete Progress Permanently
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .text-gradient {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glass {
            background: rgba(15, 15, 15, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        .glass-dark {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .animate-glow {
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from {
                box-shadow: 0 0 20px rgba(245, 158, 11, 0.3);
            }

            to {
                box-shadow: 0 0 30px rgba(245, 158, 11, 0.6);
            }
        }

        /* Custom breakpoint for very small screens */
        @media (min-width: 475px) {
            .xs\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        /* Improve form input appearance on mobile */
        @media (max-width: 640px) {

            input[type="number"],
            input[type="date"],
            input[type="file"] {
                font-size: 16px;
                /* Prevents zoom on iOS */
            }
        }

        /* File input styling improvements */
        input[type="file"]::-webkit-file-upload-button {
            margin-right: 8px;
        }

        /* Focus states for accessibility */
        input:focus,
        button:focus {
            outline: 2px solid rgba(245, 158, 11, 0.5);
            outline-offset: 2px;
        }
    </style>

    <script>
        // Improve file input display
        document.addEventListener('DOMContentLoaded', function () {
            const fileInput = document.getElementById('photo_progress');
            if (fileInput) {
                fileInput.addEventListener('change', function (e) {
                    const fileName = e.target.files[0]?.name;
                    if (fileName) {
                        // You could add a file name display here if needed
                        console.log('Selected file:', fileName);
                    }
                });
            }

            // Add loading state to form submission
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function () {
                    const submitButton = form.querySelector('button[type="submit"]');
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.innerHTML = '<span class="animate-spin">⏳</span> Updating...';
                    }
                });
            }
        });
    </script>
@endsection