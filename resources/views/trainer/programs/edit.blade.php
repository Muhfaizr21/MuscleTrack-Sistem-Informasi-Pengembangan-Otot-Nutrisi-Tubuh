@extends('layouts.trainer')

@section('title', 'Edit Program - ' . $member->name)

@section('content')
    <div class="min-h-screen py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header Section --}}
            <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-8">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center animate-glow">
                            <span class="text-2xl">⚙️</span>
                        </div>
                        <div>
                            <h1 class="text-3xl sm:text-4xl font-black text-white">
                                Edit <span class="text-gradient">Program</span>
                            </h1>
                            <p class="text-emerald-400/80 text-lg mt-2">Manage workout program for {{ $member->name }}</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('trainer.programs.show', $member->id) }}"
                            class="group flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-blue-500/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View Program
                        </a>
                        <a href="{{ route('trainer.programs.index') }}"
                            class="group flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-gray-400 hover:text-white transition-all duration-300 border border-gray-600 hover:bg-gray-700/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Members
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-8">
                    {{-- Workout Program Form --}}
                    <div class="glass-dark rounded-3xl p-6 border border-emerald-500/20 shadow-xl shadow-emerald-500/10">
                        <h2 class="text-2xl font-black text-white mb-6 flex items-center gap-3">
                            <span class="text-gradient">🏋️ Workout Program</span>
                        </h2>

                        <form action="{{ route('trainer.programs.update', ['memberId' => $member->id]) }}" method="POST"
                            class="space-y-6">
                            @csrf
                            @method('PATCH')

                            {{-- Basic Information --}}
                            <div class="space-y-4">
                                <h3 class="text-lg font-bold text-emerald-400 mb-4">Basic Information</h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-emerald-400 mb-2">Program Title</label>
                                        <input type="text" name="workout_title" value="{{ $workoutPlan->title ?? '' }}"
                                            placeholder="e.g., Upper Body Strength, Fat Loss Program"
                                            class="w-full px-4 py-3 bg-white border border-emerald-500/20 rounded-xl text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all duration-300">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-emerald-400 mb-2">Difficulty
                                            Level</label>
                                        <select name="level"
                                            class="w-full px-4 py-3 bg-white border border-emerald-500/20 rounded-xl text-black focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all duration-300">
                                            <option value="">Select Level</option>
                                            <option value="beginner"
                                                {{ ($workoutPlan->level ?? '') == 'beginner' ? 'selected' : '' }}>Beginner
                                            </option>
                                            <option value="intermediate"
                                                {{ ($workoutPlan->level ?? '') == 'intermediate' ? 'selected' : '' }}>
                                                Intermediate</option>
                                            <option value="advanced"
                                                {{ ($workoutPlan->level ?? '') == 'advanced' ? 'selected' : '' }}>Advanced
                                            </option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-emerald-400 mb-2">Duration
                                            (Weeks)</label>
                                        <input type="number" name="duration_weeks"
                                            value="{{ $workoutPlan->duration_weeks ?? '' }}" placeholder="e.g., 4, 8, 12"
                                            min="1"
                                            class="w-full px-4 py-3 bg-white border border-emerald-500/20 rounded-xl text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all duration-300">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-emerald-400 mb-2">Session Duration
                                            (Minutes)</label>
                                        <input type="number" name="duration_minutes"
                                            value="{{ $workoutPlan->duration_minutes ?? '' }}"
                                            placeholder="e.g., 30, 45, 60" min="5"
                                            class="w-full px-4 py-3 bg-white border border-emerald-500/20 rounded-xl text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all duration-300">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-emerald-400 mb-2">Target
                                            Fitness</label>
                                        <select name="target_fitness"
                                            class="w-full px-4 py-3 bg-white border border-emerald-500/20 rounded-xl text-black focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all duration-300">
                                            <option value="">Select Target</option>
                                            <option value="fat_loss"
                                                {{ ($workoutPlan->target_fitness ?? '') == 'fat_loss' ? 'selected' : '' }}>
                                                Fat Loss</option>
                                            <option value="muscle_gain"
                                                {{ ($workoutPlan->target_fitness ?? '') == 'muscle_gain' ? 'selected' : '' }}>
                                                Muscle Gain</option>
                                            <option value="strength"
                                                {{ ($workoutPlan->target_fitness ?? '') == 'strength' ? 'selected' : '' }}>
                                                Strength</option>
                                            <option value="endurance"
                                                {{ ($workoutPlan->target_fitness ?? '') == 'endurance' ? 'selected' : '' }}>
                                                Endurance</option>
                                            <option value="toning"
                                                {{ ($workoutPlan->target_fitness ?? '') == 'toning' ? 'selected' : '' }}>
                                                Toning</option>
                                            <option value="general"
                                                {{ ($workoutPlan->target_fitness ?? '') == 'general' ? 'selected' : '' }}>
                                                General Fitness</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-emerald-400 mb-2">Focus Area</label>
                                        <input type="text" name="focus_area" value="{{ $workoutPlan->focus_area ?? '' }}"
                                            placeholder="e.g., Upper Body, Core, Full Body"
                                            class="w-full px-4 py-3 bg-white border border-emerald-500/20 rounded-xl text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all duration-300">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-emerald-400 mb-2">Program
                                        Description</label>
                                    <textarea name="description" rows="3"
                                        placeholder="Describe the workout program, goals, and any specific instructions..."
                                        class="w-full px-4 py-3 bg-white border border-emerald-500/20 rounded-xl text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all duration-300">{{ $workoutPlan->description ?? '' }}</textarea>
                                </div>
                            </div>

                            {{-- Exercises Section --}}
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-lg font-bold text-emerald-400">Exercise Plan</h3>
                                    <button type="button" id="addExercise"
                                        class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-white bg-emerald-500/20 border border-emerald-500/30 rounded-lg hover:bg-emerald-500/30 transition-all duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Add Exercise
                                    </button>
                                </div>

                                <div id="exercisesContainer" class="space-y-4">
                                    {{-- Existing exercises will be populated here --}}
                                    @if($workoutPlan && $workoutPlan->workoutExercises->count() > 0)
                                        @foreach($workoutPlan->workoutExercises as $index => $exercise)
                                            <div class="exercise-item glass rounded-xl p-4 border border-emerald-500/10">
                                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
                                                    <div>
                                                        <label class="block text-xs font-medium text-emerald-400 mb-1">Exercise
                                                            Name</label>
                                                        <input type="text" name="exercises[{{ $index }}][name]"
                                                            value="{{ $exercise->name }}" placeholder="e.g., Bench Press, Squat"
                                                            class="w-full px-3 py-2 bg-white border border-emerald-500/20 rounded-lg text-black text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-emerald-400">
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-medium text-emerald-400 mb-1">Type</label>
                                                        <select name="exercises[{{ $index }}][type]"
                                                            class="w-full px-3 py-2 bg-white border border-emerald-500/20 rounded-lg text-black text-sm focus:outline-none focus:ring-1 focus:ring-emerald-400">
                                                            <option value="strength"
                                                                {{ $exercise->type == 'strength' ? 'selected' : '' }}>Strength
                                                            </option>
                                                            <option value="cardio"
                                                                {{ $exercise->type == 'cardio' ? 'selected' : '' }}>Cardio</option>
                                                            <option value="core" {{ $exercise->type == 'core' ? 'selected' : '' }}>
                                                                Core</option>
                                                            <option value="flexibility"
                                                                {{ $exercise->type == 'flexibility' ? 'selected' : '' }}>Flexibility
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-medium text-emerald-400 mb-1">Sets</label>
                                                        <input type="number" name="exercises[{{ $index }}][sets]"
                                                            value="{{ $exercise->sets ?? 3 }}" min="1"
                                                            class="w-full px-3 py-2 bg-white border border-emerald-500/20 rounded-lg text-black text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-emerald-400">
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-medium text-emerald-400 mb-1">Reps</label>
                                                        <input type="text" name="exercises[{{ $index }}][reps]"
                                                            value="{{ $exercise->reps ?? '10-12' }}" placeholder="e.g., 10-12, 8-10"
                                                            class="w-full px-3 py-2 bg-white border border-emerald-500/20 rounded-lg text-black text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-emerald-400">
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-medium text-emerald-400 mb-1">Rest
                                                            (sec)</label>
                                                        <input type="number" name="exercises[{{ $index }}][rest_seconds]"
                                                            value="{{ $exercise->rest_seconds ?? 60 }}" min="0"
                                                            class="w-full px-3 py-2 bg-white border border-emerald-500/20 rounded-lg text-black text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-emerald-400">
                                                    </div>
                                                </div>
                                                <button type="button"
                                                    class="remove-exercise mt-2 text-xs text-red-400 hover:text-red-300 transition-colors duration-200">
                                                    Remove Exercise
                                                </button>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="flex gap-4 pt-6">
                                <button type="submit"
                                    class="flex items-center gap-2 px-8 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Save Program
                                </button>

                                <a href="{{ route('trainer.programs.show', $member->id) }}"
                                    class="flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-gray-400 hover:text-white transition-all duration-300 border border-gray-600 hover:bg-gray-700/50">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>

                    {{-- Recommended Plans --}}
                    @if($recommendedPlans && $recommendedPlans->count() > 0)
                        <div class="glass-dark rounded-3xl p-6 border border-blue-500/20 shadow-xl shadow-blue-500/10">
                            <h3 class="text-xl font-black text-white mb-4 flex items-center gap-2">
                                <span class="text-blue-400">💡 Recommended Plans</span>
                            </h3>
                            <p class="text-blue-400/80 text-sm mb-4">Based on member's profile and goals</p>

                            <div class="space-y-3">
                                @foreach($recommendedPlans->take(3) as $plan)
                                    <div class="glass rounded-xl p-4 border border-blue-500/10">
                                        <div class="flex justify-between items-start mb-2">
                                            <h4 class="font-bold text-white text-sm">{{ $plan->title }}</h4>
                                            <span
                                                class="text-xs px-2 py-1 rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20 capitalize">
                                                {{ $plan->difficulty_level }}
                                            </span>
                                        </div>
                                        <p class="text-blue-400/70 text-xs mb-2">{{ Str::limit($plan->description, 80) }}</p>
                                        <div class="flex justify-between items-center text-xs">
                                            <span class="text-blue-400/60">{{ $plan->duration_weeks }} weeks</span>
                                            <span class="text-blue-400/60">{{ $plan->target_fitness }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <div class="space-y-8">
                    {{-- Member Info --}}
                    <div class="glass-dark rounded-3xl p-6 border border-emerald-500/20 shadow-xl shadow-emerald-500/10">
                        <h3 class="text-lg font-black text-white mb-4 flex items-center gap-2">
                            <span class="text-gradient">👤 Member Info</span>
                        </h3>

                        <div class="space-y-3">
                            <div>
                                <span class="text-emerald-400 text-sm font-medium">Name</span>
                                <p class="text-white font-medium">{{ $member->name }}</p>
                            </div>
                            <div>
                                <span class="text-emerald-400 text-sm font-medium">Email</span>
                                <p class="text-white text-sm">{{ $member->email }}</p>
                            </div>
                            <div>
                                <span class="text-emerald-400 text-sm font-medium">Goal</span>
                                <p class="text-white text-sm capitalize">{{ $member->goal->name ?? 'Not set' }}</p>
                            </div>
                            @if($member->age)
                                <div>
                                    <span class="text-emerald-400 text-sm font-medium">Age</span>
                                    <p class="text-white text-sm">{{ $member->age }} years</p>
                                </div>
                            @endif
                            @if($member->gender)
                                <div>
                                    <span class="text-emerald-400 text-sm font-medium">Gender</span>
                                    <p class="text-white text-sm capitalize">{{ $member->gender }}</p>
                                </div>
                            @endif
                            @if($member->height && $member->weight)
                                <div>
                                    <span class="text-emerald-400 text-sm font-medium">BMI</span>
                                    <p class="text-white text-sm">
                                        @php
                                            $heightInMeter = $member->height / 100;
                                            $bmi = $member->weight / ($heightInMeter ** 2);
                                        @endphp
                                        {{ number_format($bmi, 1) }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Quick Actions --}}
                    <div class="glass-dark rounded-3xl p-6 border border-purple-500/20 shadow-xl shadow-purple-500/10">
                        <h3 class="text-lg font-black text-white mb-4 flex items-center gap-2">
                            <span class="text-purple-400">⚡ Quick Actions</span>
                        </h3>

                        <div class="space-y-3">
                            <a href="{{ route('trainer.programs.show', $member->id) }}"
                                class="flex items-center gap-3 p-3 rounded-xl bg-purple-500/10 border border-purple-500/20 hover:bg-purple-500/20 transition-all duration-300 group">
                                <div
                                    class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center group-hover:bg-purple-500/30 transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div>
                                <span class="text-white text-sm font-medium">View Program</span>
                            </a>

                            <a href="{{ route('trainer.programs.progress', $member->id) }}"
                                class="flex items-center gap-3 p-3 rounded-xl bg-blue-500/10 border border-blue-500/20 hover:bg-blue-500/20 transition-all duration-300 group">
                                <div
                                    class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center group-hover:bg-blue-500/30 transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <span class="text-white text-sm font-medium">View Progress</span>
                            </a>
                        </div>
                    </div>
                </div>
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

        .animate-glow {
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from {
                box-shadow: 0 0 10px rgba(16, 185, 129, 0.4);
            }

            to {
                box-shadow: 0 0 20px rgba(16, 185, 129, 0.6), 0 0 30px rgba(16, 185, 129, 0.4);
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let exerciseCount = {{ $workoutPlan && $workoutPlan->workoutExercises ? $workoutPlan->workoutExercises->count() : 0 }};
            const exercisesContainer = document.getElementById('exercisesContainer');
            const addExerciseBtn = document.getElementById('addExercise');

            // Add new exercise
            addExerciseBtn.addEventListener('click', function () {
                const exerciseHtml = `
                        <div class="exercise-item glass rounded-xl p-4 border border-emerald-500/10">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-emerald-400 mb-1">Exercise Name</label>
                                    <input type="text" name="exercises[${exerciseCount}][name]"
                                           placeholder="e.g., Bench Press, Squat"
                                           class="w-full px-3 py-2 bg-white border border-emerald-500/20 rounded-lg text-black text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-emerald-400">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-emerald-400 mb-1">Type</label>
                                    <select name="exercises[${exerciseCount}][type]" class="w-full px-3 py-2 bg-white border border-emerald-500/20 rounded-lg text-black text-sm focus:outline-none focus:ring-1 focus:ring-emerald-400">
                                        <option value="strength">Strength</option>
                                        <option value="cardio">Cardio</option>
                                        <option value="core">Core</option>
                                        <option value="flexibility">Flexibility</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-emerald-400 mb-1">Sets</label>
                                    <input type="number" name="exercises[${exerciseCount}][sets]"
                                           value="3"
                                           min="1"
                                           class="w-full px-3 py-2 bg-white border border-emerald-500/20 rounded-lg text-black text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-emerald-400">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-emerald-400 mb-1">Reps</label>
                                    <input type="text" name="exercises[${exerciseCount}][reps]"
                                           value="10-12"
                                           placeholder="e.g., 10-12, 8-10"
                                           class="w-full px-3 py-2 bg-white border border-emerald-500/20 rounded-lg text-black text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-emerald-400">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-emerald-400 mb-1">Rest (sec)</label>
                                    <input type="number" name="exercises[${exerciseCount}][rest_seconds]"
                                           value="60"
                                           min="0"
                                           class="w-full px-3 py-2 bg-white border border-emerald-500/20 rounded-lg text-black text-sm placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-emerald-400">
                                </div>
                            </div>
                            <button type="button" class="remove-exercise mt-2 text-xs text-red-400 hover:text-red-300 transition-colors duration-200">
                                Remove Exercise
                            </button>
                        </div>
                    `;

                exercisesContainer.insertAdjacentHTML('beforeend', exerciseHtml);
                exerciseCount++;
            });

            // Remove exercise
            exercisesContainer.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-exercise')) {
                    e.target.closest('.exercise-item').remove();
                }
            });
        });
    </script>
@endsection