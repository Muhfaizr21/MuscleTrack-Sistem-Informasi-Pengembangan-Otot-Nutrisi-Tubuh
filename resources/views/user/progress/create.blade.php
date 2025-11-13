@extends('layouts.user')

@section('content')
    <div class="min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header Section --}}
            <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-8">
                <div class="flex items-center gap-4">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center animate-glow">
                        <span class="text-2xl">📝</span>
                    </div>
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-black text-white">
                            {{ isset($progress) ? 'Edit' : 'Add' }} <span class="text-gradient">Progress</span>
                        </h1>
                        <p class="text-emerald-400/80 text-lg mt-2">
                            {{ isset($progress) ? 'Update your progress data' : 'Track your fitness journey with detailed metrics' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Fitness Profile Info --}}
            @if($fitnessProfile)
                <div class="glass rounded-2xl p-6 border border-emerald-500/20 mb-6">
                    <h3 class="text-lg font-semibold text-emerald-400 mb-3">Your Fitness Profile</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <p class="text-emerald-400/80">Goal</p>
                            <p class="text-white font-semibold">{{ $fitnessProfile->goal->name ?? 'Not Set' }}</p>
                        </div>
                        <div>
                            <p class="text-emerald-400/80">Activity Level</p>
                            <p class="text-white font-semibold">{{ $fitnessProfile->activity_level ?? 'Not Set' }}</p>
                        </div>
                        <div>
                            <p class="text-emerald-400/80">Daily Calories</p>
                            <p class="text-white font-semibold">{{ $fitnessProfile->daily_calorie_target ?? 'Not Set' }}</p>
                        </div>
                        <div>
                            <p class="text-emerald-400/80">Focus Areas</p>
                            <p class="text-white font-semibold text-xs">
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
            <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10">
                <form
                    action="{{ isset($progress) ? route('user.progress.update', $progress->id) : route('user.progress.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($progress))
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        {{-- Weight --}}
                        <div class="col-span-1">
                            <label for="weight" class="block text-sm font-semibold text-emerald-400 mb-2">Weight (kg)
                                *</label>
                            <input type="number" step="0.1" name="weight" id="weight"
                                value="{{ old('weight', $progress->weight ?? Auth::user()->weight) }}"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/50 text-white placeholder-emerald-400/60 transition-all duration-300"
                                required>
                            @error('weight')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Height --}}
                        <div class="col-span-1">
                            <label for="height" class="block text-sm font-semibold text-emerald-400 mb-2">Height
                                (cm)</label>
                            <input type="number" step="0.1" name="height" id="height"
                                value="{{ old('height', $progress->height ?? Auth::user()->height) }}"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/50 text-white placeholder-emerald-400/60 transition-all duration-300">
                            @error('height')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Body Fat --}}
                        <div class="col-span-1">
                            <label for="body_fat" class="block text-sm font-semibold text-emerald-400 mb-2">Body Fat
                                (%)</label>
                            <input type="number" step="0.1" name="body_fat" id="body_fat"
                                value="{{ old('body_fat', $progress->body_fat ?? '') }}"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/50 text-white placeholder-emerald-400/60 transition-all duration-300">
                            @error('body_fat')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Muscle Mass --}}
                        <div class="col-span-1">
                            <label for="muscle_mass" class="block text-sm font-semibold text-emerald-400 mb-2">Muscle Mass
                                (kg)</label>
                            <input type="number" step="0.1" name="muscle_mass" id="muscle_mass"
                                value="{{ old('muscle_mass', $progress->muscle_mass ?? '') }}"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/50 text-white placeholder-emerald-400/60 transition-all duration-300">
                            @error('muscle_mass')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Waist --}}
                        <div class="col-span-1">
                            <label for="waist" class="block text-sm font-semibold text-emerald-400 mb-2">Waist (cm)</label>
                            <input type="number" step="0.1" name="waist" id="waist"
                                value="{{ old('waist', $progress->waist ?? '') }}"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/50 text-white placeholder-emerald-400/60 transition-all duration-300">
                            @error('waist')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Chest --}}
                        <div class="col-span-1">
                            <label for="chest" class="block text-sm font-semibold text-emerald-400 mb-2">Chest (cm)</label>
                            <input type="number" step="0.1" name="chest" id="chest"
                                value="{{ old('chest', $progress->chest ?? '') }}"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/50 text-white placeholder-emerald-400/60 transition-all duration-300">
                            @error('chest')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Arm --}}
                        <div class="col-span-1">
                            <label for="arm" class="block text-sm font-semibold text-emerald-400 mb-2">Arm (cm)</label>
                            <input type="number" step="0.1" name="arm" id="arm"
                                value="{{ old('arm', $progress->arm ?? '') }}"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/50 text-white placeholder-emerald-400/60 transition-all duration-300">
                            @error('arm')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Recorded Date --}}
                        <div class="col-span-1">
                            <label for="recorded_at" class="block text-sm font-semibold text-emerald-400 mb-2">Recorded Date
                                *</label>
                            <input type="date" name="recorded_at" id="recorded_at"
                                value="{{ old('recorded_at', isset($progress) ? $progress->recorded_at->format('Y-m-d') : now()->format('Y-m-d')) }}"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/50 text-white placeholder-emerald-400/60 transition-all duration-300"
                                required>
                            @error('recorded_at')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Photo Progress --}}
                        <div class="col-span-2">
                            <label for="photo_progress" class="block text-sm font-semibold text-emerald-400 mb-2">Progress
                                Photo</label>
                            <input type="file" name="photo_progress" id="photo_progress"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/50 text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-500 file:text-white hover:file:bg-emerald-600 transition-all duration-300">
                            @error('photo_progress')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror

                            @if(isset($progress) && $progress->photo_progress)
                                <div class="mt-3">
                                    <p class="text-emerald-400 text-sm mb-2">Current Photo:</p>
                                    <img src="{{ asset('storage/' . $progress->photo_progress) }}" alt="Progress Photo"
                                        class="h-32 rounded-xl border border-emerald-500/20">
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Form Actions --}}
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-emerald-500/20">
                        <button type="submit"
                            class="flex-1 px-8 py-4 rounded-2xl text-base font-black text-white bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25 flex items-center justify-center gap-3">
                            <span class="text-xl">💾</span>
                            {{ isset($progress) ? 'Update Progress' : 'Save Progress' }}
                        </button>
                        <a href="{{ route('user.progress.index') }}"
                            class="px-8 py-4 rounded-2xl text-base font-semibold text-emerald-400 hover:text-white border border-emerald-500/30 hover:bg-emerald-500/10 transition-all duration-300 flex items-center justify-center gap-3">
                            <span>Cancel</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .text-gradient {
            background: linear-gradient(135deg, #10b981 0%, #34d399 50%, #6ee7b7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glass {
            background: rgba(10, 10, 10, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .glass-dark {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
    </style>
@endsection